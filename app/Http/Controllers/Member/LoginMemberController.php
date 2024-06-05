<?php

namespace App\Http\Controllers\Member;

use App\Helpers\Constants\Queue;
use App\Http\Controllers\Controller;
use App\Jobs\Auth\Logout;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\RateLimiter;
use App\Jobs\SendEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use App\Models\SyaratPendaftaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class LoginMemberController extends Controller
{
    protected $modelMenu;

    public function __construct()
    {
        $this->modelMenu = new Menu();
    }

    public function index()
    {
        return view('pages.memberArea');
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->only(['email', 'password']), [
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')->whereNot('role_id', 1),
            ],
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('status', 'active')->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Error Validation', 'error' => ['email' => 'Akun Anda belum diaktifkan, silakan periksa email Anda']], 442);
        }

        try {
            $this->checkTooManyFailedAttempts($request);

            if (Cache::has('blocked_emails:'.$request->email)) {
                return response()->json(['status' => false, 'message' => 'Anda telah diblokir dari mencoba login. Silakan tunggu satu jam untuk mencoba lagi.'], 442);
            }
        
            if (Auth::attempt($validate->validated())) {
                RateLimiter::clear($this->throttleKey($request));
                
                $role_id = Auth::user()->role_id;
                $menu = $this->modelMenu->getMenuUser($role_id);
                $data = [
                    'menu' => $menu,
                ];
        
                $sessionLifetime = Config::get('session.lifetime');
                $currentTime = now('Asia/Jakarta');
                $formattedDateTime = $currentTime->toDateTimeString();
                $expirationTime = $currentTime->addMinute($sessionLifetime);
        
                $payload = [
                    'lifetime' => $expirationTime->toDateTimeString(),
                    'email' => $request->input('email'),
                ];
        
                $token = security()->encrypt($payload);
        
                return response()->json(['status' => true, 'message' => 'Berhasil Login', 'data' => $data])
                    ->withCookie(cookie('app_token', $token, $sessionLifetime));
            } else {
                RateLimiter::hit($this->throttleKey($request));
                
                if (RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
                    $failedEmail = $request->email;

                    Cache::put('blocked_emails:'.$failedEmail, true, 60*60);

                    $timeDetected = now()->toDateTimeString();
                    SendEmail::dispatch('aktivitas-ilegal', [
                        'title' => 'Aktivitas Ilegal Terdeteksi pada Akun Anda',
                        'email' => $failedEmail,
                        'content' => [
                            'link' => now('Asia/Jakarta')->toDateTimeString(),
                            'message' => 'Aktivitas ilegal terdeteksi pada akun Anda. Silakan hubungi admin untuk informasi lebih lanjut.',
                        ],
                    ]);

                    $retryAfter = 3600;
 
                    RateLimiter::clear($this->throttleKey($request));

                    return response()->json(['status' => false, 'message' => 'Anda telah gagal login sebanyak 3 kali. Silakan tunggu satu jam untuk mencoba login kembali', 'retry_after' => $retryAfter], 442);
                } else {
                    return response()->json(['status' => false, 'message' => 'Gagal Login, Password atau Email anda salah'], 500);
                }
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => 'Gagal Login'], 500);
        }
    }

protected function throttleKey(Request $request)
{
    return Str::lower($request->input('email')) . '|' . $request->ip();
}

protected function checkTooManyFailedAttempts(Request $request)
{
    if (RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
        throw new \Exception('Anda telah mencoba login melebihi batas yang diizinkan.');
    }
}
 
    public function logout()
    {
        $cookies = Cookie::forget('app_token');
        $userId = auth()->user()->id;

        Logout::dispatch([
            'user_id' => $userId,
            'logout_at' => now()->toDateTimeString(),
        ])->onQueue(Queue::LOGOUT_LMS);
        
        Logout::dispatch([
            'user_id' => $userId,
            'logout_at' => now()->toDateTimeString(),
        ])->onQueue(Queue::LOGOUT_TS);

        Auth::logout();

        return redirect()->route('home')->withCookie($cookies);
    }
}