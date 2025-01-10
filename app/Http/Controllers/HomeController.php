<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $provincesData = Province::all();

        return view('home.index', [
            'title' => 'Home',
            'provincesData' => $provincesData
        ]);
    }
}
