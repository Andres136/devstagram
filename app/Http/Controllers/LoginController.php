<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            return back()->with('mensaje', 'Credenciales incorrectas');
        }

        $request->session()->regenerate();

        return redirect()->route('posts.index', ['user' => Auth::user()->username]);
    }
}

   