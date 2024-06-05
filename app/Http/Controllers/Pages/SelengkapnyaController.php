<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class SelengkapnyaController extends Controller
{
    public function index()
    {
        return view('pages/selengkapnya', ['title' => 'Selengkapnya']);
    }
}
