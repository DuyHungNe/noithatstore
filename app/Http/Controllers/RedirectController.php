<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('home');
    }
}
