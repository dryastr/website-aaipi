<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\ForgotPasswordRequest;

use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class ForgotPasswordController extends Controller
{
    protected $dirView = 'pages.memberArea.forgot-password.';

    public function forgotPassword()
    {
        $data = [
            'pageTitle' => 'Forgot Password',
        ];

        return view($this->dirView . 'forgot-password', $data);
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['email_verify_key'] = Str::random(20);
    
            $result = DB::transaction(function () use ($data) {
                $user = User::updateOrCreate(
                    ['email' => $data['email']],
                    ['email_verify_key' => $data['email_verify_key']]
                );
    
                // Dispatch the email job
                SendEmail::dispatch('reset-password-notification', [
                    'title' => 'Reset Password',
                    'email' => $data['email'],
                    'content' => [
                        'link' => route('memberArea.reset-password.index', ['token' => security()->encrypt($user['email_verify_key'])]),
                    ],
                ]);
    
                return $user;
            });
    
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengirim email verifikasi. Silakan periksa email Anda.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
    

    // Metode-metode yang lain tetap sama seperti pada kode sebelumnya

    protected function broker()
    {
        return Password::broker();
    }

    protected function sendResetLinkResponse($response)
    {
        // Implementasi respons sukses jika diperlukan
    }

    protected function sendResetLinkFailedResponse($request, $response)
    {
        // Implementasi respons gagal jika diperlukan
    }
}
