<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Profile\ChangePasswordRequest;
use App\Models\KotaKab;
use App\Models\Provinsi;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ChangeProfileController extends Controller
{
    protected $model;

    protected $modelProvinsi;

    protected $modelKotaKab;

    protected $dirView = 'member.pages.change-profile.';

    protected $apiBaseUrl;

    public function __construct()
    {
        $this->model = new User();
        $this->modelProvinsi = new Provinsi();
        $this->modelKotaKab = new KotaKab();
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function index()
    {
        try {
            $user = auth()->user()->getMe();
            $provinsi = $this->modelProvinsi->all();
            $kotaKab = $this->modelKotaKab->where('ref_provinsi_id', $user->ref_provinsi_id)->get();
            $apiData = $this->getDataFromAPI('referensi/instansi');
            $apiDataPangkat = $this->getDataFromAPI('referensi/pangkat');
            $apiDataJabatan = $this->getDataFromAPI('referensi/jabatan');
            $apiDataJenjang = $this->getDataFromAPI('referensi/jenjang-jabatan');

            $kodeInstansi = $user->kode_instansi;
            $apiDataUnit = $this->getDataFromAPI('referensi/unit-kerja',['kode_instansi'=> $kodeInstansi]);

            $data = [
                'title' => 'Change Profile',
                'user' => $user,
                'provinsi' => $provinsi,
                'kotaKab' => $kotaKab,
                'instansi' => $apiData,
                'pangkat' => $apiDataPangkat,
                'jabatan' => $apiDataJabatan,
                'jenjang' => $apiDataJenjang,
                'unitkerja' => $apiDataUnit,
            ];

            // dd( $data);

            return view($this->dirView . 'index', $data);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getDataFromUNIT(Request $request)
    {
        $kodeInstansi = $request->input('kode_instansi');
        $selectedUnit = $request->input('selected_unit');
        
        try {
            $apiDataUnit = $this->getDataFromAPI('referensi/unit-kerja', [
                'kode_instansi' => $kodeInstansi,
                'selected_unit' => $selectedUnit
            ]);
    
            // Kirim respons JSON yang berisi data unit kerja dari API
            return response()->json($apiDataUnit);
        } catch (Exception $e) {
            // Tangani kesalahan dan kirim respons JSON dengan pesan kesalahan
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function getDataFromAPI($endpoint ,$params = [])
    {
        $client = new Client();
        $url = $this->apiBaseUrl . $endpoint;

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'x-api-key' => 'aaipi',
                    'Accept' => 'application/json',
                    'x-api-token' => 'VauxPIG2h5lrs8TqCGe1z0rPRiGWSsiuYvSF0y6ixsqj1WG31PrmoelYwHUvFu0O',
                ],
                'query' => $params,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $data = json_decode($response->getBody(), true);

            return $data;
        } catch (Exception $e) {
            throw new Exception("Failed to fetch data from API: {$e->getMessage()}");
        }
    }


    public function changeProfile(Request $request)
    {
   


    $validated = $request->validate([
        'fullname' => ['required', 'string', 'max:150'],
        'email' => ['required', 'email', 'string', 'max:255', 'unique:users,email,' . auth()->user()->id],
        'mobile' => ['required', 'string', 'max:17'],
        'nama_gelar' => ['nullable'],
        'gelar_depan' => ['nullable'],
        'gelar_belakang' => ['required'],
        'ref_provinsi_id' => ['nullable'],
        'ref_kota_kab_id' => ['nullable'],
        'status_nip_nrp' => ['nullable'],
        'nip_nrp' => ['required'],
        'nama_pangkat' => ['required'],
        'nama_jenjang_jabatan' => ['required'],
        'kelompok_jabatan' => ['required'],
        'nama_unit' => ['required'],
        'nama_instansi' => ['required'],
        'kode_jenjang_jabatan' => ['nullable'],
        'kode_jabatan' => ['nullable'],
        'kode_unit_kerja' => ['nullable'],
        'kode_instansi' => ['nullable'],
        'avatar' => ['nullable', 'file'],
        'nama_jabatan' => ['nullable'],

    ]);
        
    try {
        $data = $validated;
        $user = $this->model->find(auth()->user()->id);
        

        $avatar = $user->avatar;
        if ($request->file('avatar')) {
            $file = $request['avatar']->getContent();
            $file_extension = $request['avatar']->extension();

            $file = file_helper()->upload(
                fileContent: $file,
                ext: $file_extension,
                path: 'profile'
            );

            $data['avatar'] = $file['filename'];
        } elseif (!$request->hasFile('avatar') && $avatar) {
            $data['avatar'] = $avatar;
        } else {
            $data['avatar'] = null;
        }

        $result = DB::transaction(function () use ($data, $user, $request) {

            
            $dataInput = [
                'fullname' => $data['fullname'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'nama_gelar' => $data['nama_gelar']?? null ,
                'gelar_depan' => $data['gelar_depan']?? null,
                'gelar_belakang' => $data['gelar_belakang'],
                'ref_provinsi_id' => $data['ref_provinsi_id']?? null,
                'ref_kota_kab_id' => $data['ref_kota_kab_id'] ?? null,
                'nip' => $data['status_nip_nrp'] == 'nip' ? $data['nip_nrp'] : null,
                'nrp' => $data['status_nip_nrp'] == 'nrp' ? $data['nip_nrp'] : null,
                'nama_pangkat' => $data['nama_pangkat'],
                'nama_jenjang_jabatan' => $data['nama_jenjang_jabatan'],
                'kelompok_jabatan' => $data['kelompok_jabatan'],
                'nama_unit' => $data['nama_unit'],
                'nama_instansi' => $data['nama_instansi'] ?? null,
                'kode_jenjang_jabatan' => $data['kode_jenjang_jabatan'] ?? null,
                'kode_jabatan' => $data['kode_jabatan'] ?? null,
                'kode_unit_kerja' => $data['kode_unit_kerja'] ?? null,
                'kode_instansi' => $data['kode_instansi'] ?? null,
                'nama_jabatan' => $data['nama_jabatan'] ?? null,
                'avatar' => $data['avatar'],
            ];

            if ($request->has('ref_provinsi_id') && $data['ref_provinsi_id'] == $user->ref_provinsi_id) {
                
                $dataInput['ref_kota_kab_id'] = $user->ref_kota_kab_id;
            }

            if ($data['avatar']) {
                $dataInput['avatar'] = $data['avatar'];
            }
            // dd($dataInput);
            $user->update($dataInput);

            return $user;
        });

        if (!$result) {
            if ($data['avatar']) {
                file_helper()->delete($data['avatar']);
            }
        }

        return redirect()->route('member.change-profile.index')->with('status', 'Profile berhasil diperbarui');
    } catch (Exception $e) {
        return redirect()->route('member.change-profile.index')->withErrors(['error' => $e->getMessage()]);
    }
}


    public function kotaKab(Request $request)
    {
        $provinsi_id = $request->input('ref_provinsi_id');
        $data = $this->modelKotaKab->where('ref_provinsi_id', $provinsi_id)->get();

        return response()->json($data);
    }

    public function changePassword()
    {
        $data = [
            'title' => 'Ubah Password',
            'user' => auth()->user()->getMe(),
        ];

        return view($this->dirView . 'change-password', $data);
    }

    public function changePasswordAction(ChangePasswordRequest $request)
    {
        try {
            $data = $request->validated();

            $user = $this->model->find(auth()->user()->id);

            if (Hash::check($data['current_password'], $user->password) === false) {
                return redirect()->route('member.change-password.index')->withErrors(['error' => [
                    'message' => 'Error Validation',
                    'errors' => [
                        'current_password' => [
                            'Password tidak valid',
                        ],
                    ],
                ]]);
            }

            if ($data['current_password'] === $data['new_password']) {
                return redirect()->route('member.change-password.index')->withErrors(['error' => [
                    'message' => 'Error Validation',
                    'errors' => [
                        'current_password' => [
                            'Passwort baru harus berbeda dengan password sebelumnya',
                        ],
                        'new_password' => [
                            'Passwort baru harus berbeda dengan password sebelumnya',
                        ],
                    ],
                ]]);
            }

            $result = DB::transaction(function () use ($user, $data) {
                return $user->update([
                    'password' => Hash::make($data['new_password']),
                ]);
            });

            return redirect()->route('member.change-password.index')->with('status', 'Password berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->route('member.change-password.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
