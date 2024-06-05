<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];

        return view('admin.pages.home.index', $data);
    }
}
