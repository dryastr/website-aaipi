<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Profile\ChangePasswordRequest;
use App\Http\Requests\Dashboard\Profile\ChangeProfileRequest;
use App\Models\Attachment;
use App\Models\BiayaKeanggotaan;
use App\Models\PembayaranKeanggotaan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $dirView = 'admin.pages.profile.';

    protected $model;

    protected $modelBiayaKeanggotaan;

    protected $modelPembayaranKeanggotaan;

    protected $modelAttachment;

    public function __construct()
    {
        $this->model = new User();
        $this->modelBiayaKeanggotaan = new BiayaKeanggotaan();
        $this->modelPembayaranKeanggotaan = new PembayaranKeanggotaan();
        $this->modelAttachment = new Attachment();
    }

    public function index()
    {
        $data = [
            'title' => 'Profile',
            'item' => $this->model->getMe(),
            'user' => auth()->user()->getMe(),
        ];

        return view($this->dirView.'informasi-umum', $data);
    }

    public function changePassword()
    {
        $data = [
            'title' => 'Change Password',
            'user' => auth()->user()->getMe(),
        ];

        return view($this->dirView.'change-password', $data);
    }

    public function aktifasiKeanggotaan()
    {
        $data = [
            'title' => 'Aktifiasi Keanggotaan',
            'biaya_keanggotaan' => $this->modelBiayaKeanggotaan->biayaAktif(),
            'user' => $this->model->getMe(),
            'status_keanggotaan' => $this->model->status_keanggotaan(auth()->user()->id),
        ];

        return view($this->dirView.'aktifasi-keanggotaan', $data);
    }

    public function changeProfile(ChangeProfileRequest $request)
    {
        try {

            $data = $request->validated();

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
            } else {
                $data['avatar'] = null;
            }

            $result = DB::transaction(function () use ($data, $user) {
                $user->update([
                    'fullname' => $data['fullname'],
                    'email' => $data['email'],
                    'mobile' => $data['mobile'],
                    'avatar' => $data['avatar'],
                ]);
                if ($user->role_id != 1) {
                    $user->registration()->update([
                        'nip' => $data['nip'],
                        'nama_instansi' => $data['nama_instansi'],
                        'jabatan' => $data['jabatan'],
                        'alamat' => $data['alamat'],
                    ]);
                }

                return $user;
            });

            if (! $result) {
                if ($data['avatar']) {
                    file_helper()->delete($data['avatar']);
                }
            }

            if ($result) {
                if ($avatar) {
                    file_helper()->delete($avatar);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah Data',
                'data' => $data,
            ]);

        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function changePasswordAction(ChangePasswordRequest $request)
    {
        try {
            $data = $request->validated();

            $user = $this->model->find(auth()->user()->id);

            if (Hash::check($data['current_password'], $user->password) === false) {
                return response()->json([
                    'message' => 'Error Validation',
                    'errors' => [
                        'current_password' => [
                            'Password tidak valid',
                        ],
                    ],
                ], 422);
            }

            if ($data['current_password'] === $data['new_password']) {
                return response()->json([
                    'message' => 'Error Validation',
                    'errors' => [
                        'current_password' => [
                            'Passwort baru harus berbeda dengan password sebelumnya',
                        ],
                        'new_password' => [
                            'Passwort baru harus berbeda dengan password sebelumnya',
                        ],
                    ],
                ], 422);
            }

            $result = DB::transaction(function () use ($user, $data) {
                return $user->update([
                    'password' => Hash::make($data['new_password']),
                ]);
            });

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah Data',
                'data' => $result,
            ]);

        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function aktifasiKeanggotaanAction(Request $request)
    {
        try {
            $user = $this->model->find(auth()->user()->id);
            $tagihan = $this->modelBiayaKeanggotaan->biayaAktif();

            $data['user_id'] = $user['id'];
            $data['tagihan_id'] = $tagihan['id'];
            $data['tagihan'] = $tagihan['biaya'];
            $data['nominal_bayar'] = $tagihan['biaya'];
            $data['tanggal_bayar'] = now();

            $result = DB::transaction(function () use ($data) {
                $pembayaran = $this->modelPembayaranKeanggotaan->create($data);

                return $pembayaran;
            });

            if ($result) {
                $file = $request['bukti_transfer'];
                $file_content = $file->getContent();
                $file_extension = $file->extension();
                $date = now()->toDateString();

                $fileUpload = file_helper()->upload(
                    fileContent: $file_content,
                    ext: $file_extension,
                    path: 'bukti_transfer/'.$date
                );

                $attachmentData = [
                    'parent_table' => 'trans_pembayaran_keanggotaan',
                    'table_id' => $result->id,
                    'path' => $fileUpload['filename'],
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'extension' => $file_extension,
                ];

                $this->modelAttachment->create($attachmentData);
            }

            if (! $result) {
                file_helper()->delete($data['bukti_transfer']);
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah Data',
                'data' => $data,
            ]);

            return response()->json(null);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}
