<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    protected $modelMenu;

    public function __construct()
    {
        $this->modelMenu = new Menu();
    }

    public function index()
    {
        return view('admin.pages.auth.login');
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->only(['email', 'password']), [
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')
                    ->where('status', 'active')
                    ->where('role_id', 1),
            ],
            'password' => 'required',
        ]);

        // dd($validate);

        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Error Validation', 'error' => $validate->errors()], 442);
        }

        if (Auth::attempt($validate->validated())) {
            // dd(Auth::user());
            $role_id = Auth::user()->role_id;
            $menu = $this->modelMenu->getMenuUser($role_id);
            $data = [
                'menu' => $menu,
            ];

            return response()->json(['status' => true, 'message' => 'Berhasil Login', 'data' => $data]);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal Login'], 442);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
        // return response()->json(['status' => true, 'message' => 'Berhasil Logout']);
    }
}
