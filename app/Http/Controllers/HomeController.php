<?php

namespace App\Http\Controllers;

use App\Services\MataKuliahService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        switch (Auth::user()->role) {
            case '00':
            case '01':
                return view('kpu.index');
                break;
            case '02':
            case '03':
                return view('ppl.index');
                break;
            default:
                Auth::logout();
                return redirect('/')->with('error', 'user tidak dikenali');
        }
    }
}
