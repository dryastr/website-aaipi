<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\CheckUserRequest;
use App\Http\Requests\Registration\RegistrasiLuarBiasaRequest;
use App\Http\Requests\Registration\RegistrationActivationRequest;
use App\Http\Requests\Registration\SetupPasswordRequest;
use App\Jobs\SendEmail;
use App\Models\Attachment;
use App\Models\Registration;
use App\Models\SyaratPendaftaran;
use App\Models\User;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MemberAreaController extends Controller
{
    protected $model;

    protected $modelUser;

    protected $modelSyaratPendaftaran;

    protected $modelAttachment;

    public function __construct()
    {
        $this->model = new Registration();
        $this->modelUser = new User();
        $this->modelSyaratPendaftaran = new SyaratPendaftaran();
        $this->modelAttachment = new Attachment();
    }

    public function index()
    {
        $data = [
            'title' => 'Registrasi',
            'persyaratan' => $this->modelSyaratPendaftaran->getAll(),
            'persyaratanForm' => $this->modelSyaratPendaftaran->getTypeFile(),
        ];

        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return to_route('dashboard.admin.view');
            } else {
                return to_route('dashboard.view');
            }
        }

        return view('pages.memberArea.index', $data);
    }

    public function checkDataUser(CheckUserRequest $request)
    {

        try {
            $apiKey = env('X_API_KEY');
            $apiToken = env('X_API_TOKEN');
            $apiURL = env('X_API_URL');
            // https://jsonplaceholder.typicode.com/posts/100
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
                'x-api-token' => $apiToken,
            ])->get($apiURL.'/cek-user', $request->validated());

            // $data = [
            //     'fullname' => fake()->name(),
            //     'jabatan' => fake()->jobTitle(),
            // ];

            if ($response->successful()) {
                $responseData = $response->json();

                return response()->json([
                    'status' => $response->status(),
                    'data' => $responseData
                    ]
                );
            } else {
                return response()->json([
                    'status' => $response->status(),
                    'error' => $response->json(), // You can customize this based on the actual structure of the error response
                ]);
            }
        } catch (\Exception $e) {
            return response()->json($e);
        }

    }

    public function registrasiAktifasi(RegistrationActivationRequest $request)
    {
        try {
            $data = $request->validated();
            $data['email_verify_key'] = Str::random(20);

            $result = DB::transaction(function () use ($data) {
                $user = $this->modelUser->updateOrCreate([
                    'email' => $data['email'],
                    'nip' => $data['nip'],
                    'nama_jenjang_jabatan' => $data['jabatan'],
                ],
                    [
                        'fullname' => $data['fullname'],
                        'password' => Hash::make('Password123'),
                        'role_id' => 2,
                        'email_verify_key' => $data['email_verify_key'],
                        'status' => 'inactive',
                        'created_by_name' => $data['fullname'],
                    ]);

                $user->registration()->updateOrCreate([
                    'nip' => $data['nip'],
                ], [
                    'jabatan' => $data['jabatan'],
                ]);

                return $user;
            });

            if ($result) {
                SendEmail::dispatch('verifikasi-email', [
                    'title' => 'Verifikasi Keanggotaan Anda untuk AAIPI',
                    'email' => $data['email'],
                    'content' => [
                        'link' => route('memberArea.verification').'?kode='.security()->encrypt($data['email_verify_key']),
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Registrasi',
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            dd($e);
            // return response()->json($e->);
        }
    }

    public function verification(Request $request)
    {

        $kode = security()->decrypt($request->kode);
        $checkData = $this->modelUser->where('email_verify_key', '=', $kode)->firstOrFail();

        $data = [
            'title' => 'Verifikasi Email',
            'message' => '',
        ];

        if (! $checkData) {
            $data['message'] = 'Data Tidak Ditemukan';
        } elseif ($checkData->email_verified_at) {
            $data['message'] = 'Email sudah terverifikasi';
        } else {
            if ($checkData->role_id == 2) {
                $data['message'] = 'Sebelum mengaktifasi akun anda, silahkan atur kata sandi anda';
                $data['data'] = [
                    'kode' => $request->kode,
                    'email' => $checkData->email,
                ];
            } else {
                $checkData->update([
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'status' => 'active',
                ]);

                // SendEmail::dispatch('notifikasi-verifikasi-email', [
                //     'title' => 'Notifikasi Verifikasi Email Keanggotaan',
                //     'email' => $checkData->email,
                //     'content' => [
                //         'link' => route('memberArea.index'),
                //     ],
                // ]);

                $data['message'] = 'Hore, email kamu sudah berhasil terverifikasi.';
            }
        }

        return view('pages.memberArea.verifikasi', $data);
    }

    public function setupPassword(SetupPasswordRequest $request)
    {
        try {
            $kode = security()->decrypt($request->kode);
            $checkData = $this->modelUser
                ->where('email_verify_key', '=', $kode)
                ->where('email', $request->email)
                ->firstOrFail();
            if (! $checkData) {
                $data['message'] = 'Data Tidak Ditemukan';
            } elseif ($checkData->email_verified_at) {
                $data['message'] = 'Email sudah terverifikasi';
            } else {

                $apiKey = env('X_API_KEY');
                $apiToken = env('X_API_TOKEN');
                $apiURL = env('X_API_URL');

                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'x-api-token' => $apiToken,
                ])->get($apiURL.'/cek-user?nip='.$checkData['nip'].'&email='.$checkData['email']);


                if ($response->successful()) {
                    $responseData = $response->json();

                    $namaGelar =  $responseData['data']['gelar_depan'] ?? '';
                    $namaLengkap = $responseData['data']['nama_lengkap'] ?? '';
                    $gelarBelakang =  $responseData['data']['gelar_belakang'] ?? '';


                    $checkData->update([
                        'nama_gelar' => trim("$namaGelar $namaLengkap, $gelarBelakang", ' ,'),
                        'kode_jenjang_jabatan' => $responseData['data']['kode_jenjang_jabatan'] ?? 'T',
                        'kode_jabatan' => $responseData['data']['kode_jabatan'] ?? '2',
                        'kelompok_jabatan' => $responseData['data']['kelompok_jabatan'] ?? '4',
                        'kode_unit_kerja' => $responseData['data']['kode_unit_kerja'] ?? '',
                        'nama_unit' => $responseData['data']['nama_unit'] ?? '',
                        'kode_instansi' => $responseData['data']['kode_instansi'] ?? '',
                        'nama_instansi' => $responseData['data']['nama_instansi'] ?? '',
                        'email_verified_at' => now(),
                        'status' => 'active',
                        'password' => Hash::make($request->password),
                    ]);

                    if($checkData){

                        return response()->json(['message' => 'Selamat, akun Anda sudah terverifikasi.',
                        'api_response'=> $checkData]);
                    }else{
                        return response()->json(['message' => 'Gagal Update.',
                        'api_response'=> $checkData]);
                    }

                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal mengambil data pengguna dari API.',
                        'api_response' => $response->json(),
                    ]);
                }
            }

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function registrasiLuarBiasa(RegistrasiLuarBiasaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['email_verify_key'] = Str::random(20);

            $result = DB::transaction(function () use ($data) {
                $user = $this->modelUser->updateOrCreate([
                    'email' => $data['email'],
                ], [
                    'fullname' => $data['fullname'],
                    'password' => Hash::make($data['password']),
                    'role_id' => 3,
                    'mobile' => $data['mobile'],
                    'email_verify_key' => $data['email_verify_key'],
                    'status' => 'inactive',
                    'created_by_name' => $data['fullname'],
                ]);

                $user->registration()->updateOrCreate(['user_id' => $user->id], []);

                return $user;
            });

            if ($result) {
                $getPersyaratanFile = $this->modelSyaratPendaftaran->getTypeFile();
                // $getDataExists = $result->attachment()->get();

                // foreach($getDataExists as $item){
                //     file_helper()->delete($item['path']);
                // }

                $dataAttachment = [];
                foreach ($getPersyaratanFile as $item) {
                    $nameField = 'syarat_pendaftaran_'.$item['id'];
                    $file = $request[$nameField];
                    if ($item['type'] == 'file') {
                        $file_content = $file->getContent();
                        $file_extension = $file->extension();
                        $date = now()->toDateString();

                        $fileUpload = file_helper()->upload(
                            fileContent: $file_content,
                            ext: $file_extension,
                            path: 'syarat_pendaftaran/'.$date
                        );

                        $valueInput = $fileUpload['filename'];
                    } else {
                        $valueInput = $file ? 1 : 0;
                    }

                    $dataAttachment[] = [
                        'ref_id' => $item['id'],
                        'value' => $valueInput,
                    ];
                }

                $result->attachment_register()->updateOrCreate(
                    [
                        'user_id' => $result->id,
                    ], [
                        'value' => json_encode([
                            'persetujuan' => $request->has('agreement') ? 1 : 0,
                            'persyaratan' => $dataAttachment,
                        ]),
                    ]);

                SendEmail::dispatch('verifikasi-email-first', [
                    'title' => 'Notifikasi Registrasi Keanggotaan Anda di AAIPI',
                    'email' => $data['email'],
                    'content' => [
                        'link' => route('memberArea.verification').'?kode='.security()->encrypt($data['email_verify_key']),
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Registrasi',
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Pesan kesalahan kustom'], 500);
        }
    }
}
