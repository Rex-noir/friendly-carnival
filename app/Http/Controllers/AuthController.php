<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], ['email.email' => "Invalid Email"],);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], (bool)($request->input('remember')))) {
            return redirect()->intended(session()->get('url.intended'));
        } else {
            return back()->withErrors(['email' => 'Invalid credentials!']);
        }
    }
}
