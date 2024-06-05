<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BiayaKeanggotaan;
use App\Models\PembayaranKeanggotaan;
use App\Http\Requests\Dashboard\AboutMember\ActionsRequest;
use App\Models\AboutMember;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // Add this line
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardMemberController extends Controller
{
    protected $model;
    protected $modelAboutMember;
    public function __construct()
    {
        $this->model = new User();
        $this->modelAboutMember = new AboutMember();
    }

    private function getTagihanBelumDibayar($userId, $biayaKeanggotaanId)
    {
        // Ambil informasi tagihan yang belum dibayar
        $tagihanBelumDibayar = BiayaKeanggotaan::where('id', $biayaKeanggotaanId)
            ->whereDoesntHave('pembayaran', function ($query) use ($userId) {
                $query->where('user_id', $userId)->whereNotIn('status', ['ditolak']);
            })
            ->get();

        return $tagihanBelumDibayar;
    }


    public function index()
    {
        $userMember = auth()->user()->getMe();
        $renewal = $this->getRenewal();
        $item = AboutMember::where('user_id', $userMember['id'])->first();

        if (!$item) {
            $item = new AboutMember();
        }
        $dataForm['desc_member'] = $item ? $item['desc_member'] : null;


        try {
            if ($userMember['role_id'] == 2) {
                $apiKey = env('X_API_KEY');
                $apiToken = env('X_API_TOKEN');
                $apiURL = env('X_API_URL');
                // https://jsonplaceholder.typicode.com/posts/100
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'x-api-token' => $apiToken,
                ])->get($apiURL . '/jumlah-jp', [
                    'nip' => $userMember['nip'],
                    'verify' => false,
                ]);

                $responseSertifikat = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'x-api-token' => $apiToken,
                ])->get($apiURL . '/sertifikat', [
                    'nip' => $userMember['nip'],
                    'verify' => false,
                ]);

                if ($response->successful() && $responseSertifikat->successful()) {
                    $data = [
                        'title' => 'Dashboard',
                        'user' => auth()->user()->getMe(),
                        'jp' => $response->json(),
                        'sertifikat' => $responseSertifikat->json(),
                        'item' => $dataForm,
                    ];
                } else {
                    // Handle unsuccessful responses (e.g., show an error message)
                    $data = [
                        'title' => 'Dashboard',
                        'user' => auth()->user()->getMe(),
                        'renewal' => $renewal,
                        'item' => $dataForm,
                        'error' => 'Failed to fetch data from the API.',
                    ];
                }
            } else {
                $data = [
                    'title' => 'Dashboard',
                    'user' => auth()->user()->getMe(),
                    'renewal' => $renewal,
                    'item' => $dataForm,
                ];
            }

            return view('member.pages.home.index', $data);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $data = [
                'title' => 'Dashboard',
                'user' => auth()->user()->getMe(),
                'renewal' => $renewal,
                'item' => $dataForm,
                'error' => 'Failed to fetch data from the API.' . $e->getMessage(),
            ];
            return view('member.pages.home.index', $data);
        } catch (\Exception $e) {
            $data = [
                'title' => 'Dashboard',
                'user' => auth()->user()->getMe(),
                'renewal' => $renewal,
                'item' => $dataForm,
                'error' => 'Failed to fetch data from the API.' . $e->getMessage(),
            ];
            return view('member.pages.home.index', $data);
        }
    }

    private function getRenewal()
    {
        try {
            // Dapatkan informasi pengguna yang terautentikasi
            $user = auth()->user()->getMe();

            // Pastikan $user tidak null dan memiliki indeks 'role'
            if ($user && isset($user['role'])) {
                // Pastikan indeks 'role' memiliki nilai dan memiliki indeks 'id'
                $jenis_keanggotaan = $user['role']['id'] == 2 ? 'anggota-biasa' : 'anggota-luar-biasa';

                // Ambil informasi biaya keanggotaan yang aktif
                $biayaKeanggotaanAktif = BiayaKeanggotaan::where('tahun', date('Y'))
                    ->where('status', 'active')
                    ->where('jenis_keanggotaan', $jenis_keanggotaan)
                    ->first();

                // Pastikan biaya keanggotaan aktif tidak null
                if ($biayaKeanggotaanAktif) {
                    // Dapatkan tagihan yang belum dibayar
                    $tagihanBelumDibayar = $this->getTagihanBelumDibayar($user['id'], $biayaKeanggotaanAktif->id);

                    $renewal = 0;

                    // Periksa apakah pengguna memiliki tagihan yang belum dibayar
                    if (count($tagihanBelumDibayar) > 0) {
                        // Dapatkan pembayaran terakhir
                        $getLastPaid = PembayaranKeanggotaan::where('user_id', $user->id)
                            ->orderBy('id', 'desc')
                            ->first();

                        // Hitung periode perpanjangan jika pembayaran terakhir ada
                        if ($getLastPaid) {
                            $renewal = now()->diffInDays($getLastPaid->tanggal_expired);
                        }
                    }

                    return $renewal;
                } else {
                    // Handle jika tidak ada biaya keanggotaan aktif
                    throw new \Exception('Tidak ada biaya keanggotaan aktif');
                }
            } else {
                // Handle jika $user null atau tidak memiliki indeks 'role'
                throw new \Exception('Pengguna tidak terautentikasi atau tidak memiliki peran');
            }
        } catch (\Exception $e) {
            // Tangani error dan kembalikan nilai default atau lempar kembali error
            return 0; // Nilai default untuk periode perpanjangan
        }
    }

    public function resume()
    {
        $userMember = auth()->user()->getMe();
        $renewal = $this->getRenewal();

        try {


            if ($userMember['role_id'] == 2) {
                $apiKey = env('X_API_KEY');
                $apiToken = env('X_API_TOKEN');
                $apiURL = env('X_API_URL');
                // https://jsonplaceholder.typicode.com/posts/100
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'x-api-token' => $apiToken,
                ])->get($apiURL . '/pangkat-jabatan', [
                    'nip' => $userMember['nip'],
                    'verify' => false,
                ]);

                // dd($response);
                $responsePelatihan = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'x-api-token' => $apiToken,
                ])->get($apiURL . '/pelatihan', [
                    'nip' => $userMember['nip'],
                    'verify' => false,
                ]);

                $data = [
                    'title' => 'Resume',
                    'user' => auth()->user()->getMe(),
                    'pangkatJabatan' => $response->json(),
                    'pelatihan' => $responsePelatihan->json(),
                    'renewal' => $renewal,
                ];
            } else {

                $data = [
                    'title' => 'Resume',
                    'user' => auth()->user()->getMe(),
                    'renewal' => $renewal,
                ];
            }

            return view('member.pages.resume.index', $data);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            $data = [
                'title' => 'Dashboard',
                'user' => auth()->user()->getMe(),
                'renewal' => $renewal,
                'error' => 'Failed to fetch data from the API.' . $e->getMessage(),
            ];
            return view('member.pages.home.index', $data);
        } catch (\Exception $e) {
            $data = [
                'title' => 'Dashboard',
                'user' => auth()->user()->getMe(),
                'renewal' => $renewal,
                'error' => 'Failed to fetch data from the API.' . $e->getMessage(),
            ];
            return view('member.pages.home.index', $data);
        }
    }

    public function pembelian()
    {
        $client = new Client();
        $renewal = $this->getRenewal();

        $response = $client->request('GET', 'https://dev-lms.aaipi.id/api/development/courses', [
            'headers' => [
                'x-api-key' => '1234',
                'Accept' => 'application/json',
            ],
            'verify' => false,
        ]);

        // Mendapatkan data dari respons
        $apiData = json_decode($response->getBody(), true);

        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $startIndex = ($currentPage - 1) * $perPage;

        $pelatihan = new LengthAwarePaginator(
            collect($apiData['data'])->slice($startIndex, $perPage),
            count($apiData['data']),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        $data = [
            'title' => 'Pembelian',
            'user' => auth()->user()->getMe(),
            'renewal' => $renewal,
            'pelatihan' => $pelatihan,
        ];

        return view('member.pages.pembelian.index', $data);
    }

    public function tagihan()
    {
        $renewal = $this->getRenewal();
        $data = [
            'title' => 'Tagihan',
            'user' => auth()->user()->getMe(),
            'renewal' => $renewal,
        ];

        return view('member.pages.tagihan.index', $data);
    }

    public function tiket()
    {
        $renewal = $this->getRenewal();
        $data = [
            'title' => 'Tiket',
            'user' => auth()->user()->getMe(),
            'renewal' => $renewal,
        ];

        return view('member.pages.tiket.index', $data);
    }

    public function actions(ActionsRequest $request)
    {
        try {
            $user = auth()->user()->getMe();
            $data = $request->validated();

            $result = DB::transaction(function () use ($data, $user) {
                $existingAboutMember =  AboutMember::where('user_id', $user['id'])->first();

                if ($existingAboutMember) {
                    $existingAboutMember->update([
                        'desc_member' => $data['desc_member'],
                        'user_id' =>  $user['id'],
                    ]);

                    return $existingAboutMember;
                } else {
                    return AboutMember::create([
                        'desc_member' => $data['desc_member'],
                        'user_id' =>  $user['id'],
                    ]);
                }
            });

            return redirect()->route('dashboard.view');
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}
