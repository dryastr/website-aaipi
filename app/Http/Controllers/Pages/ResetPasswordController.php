<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\ResetPasswordRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class ResetPasswordController extends Controller
{
    protected $model;

    protected $dirView = 'pages.memberArea.reset-password.';

    public function __construct()
    {
        $this->model = new User();
    }

    public function resetPassword(Request $request)
    {
        // Retrieve the token from the request or generate it as needed
        $token = $request->token;
        
        $data = [
            'pageTitle' => 'Reset Password',
            'token' => $token,
        ];
    
        return view($this->dirView . 'reset-password', $data);
    }




    public function resetPasswordAction(ResetPasswordRequest $request, $token)
    {
        try {
            // Validasi token
            if (!$token || !is_string($token)) {
                throw new \InvalidArgumentException('Invalid token provided.');
            }
    
            $kode = security()->decrypt($token);
    
            if (!$kode || !is_string($kode)) {
                throw new \InvalidArgumentException('Failed to decrypt the token.');
            }
    
            $checkData = $this->model->where('email_verify_key', $kode)->first();
    
            if (!$checkData) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
    
            $checkData->update([
                'password' => Hash::make($request->new_password),
            ]);
    
            return response()->json(['message' => 'Password berhasil diubah']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan internal.'], 500);
        }
    }
}   