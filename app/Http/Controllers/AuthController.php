<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->input('remember'))) {
            Log::info('Remember log', ['remember' => $request->input('remember')]);
            return "Logged";
        } else {
            return back()->withErrors(['email' => 'Invalid credentials!']);
        }
    }
}
