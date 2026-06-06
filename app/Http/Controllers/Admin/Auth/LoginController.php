<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\CaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create(CaptchaService $captcha)
    {
        $captchaData = $captcha->generate();
        return view('auth.admin-login', compact('captchaData'));
    }

    public function store(Request $request, CaptchaService $captcha)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'captcha' => ['required', 'string'],
        ]);

        if (!$captcha->validate($request->input('captcha'))) {
            return back()->withErrors(['captcha' => 'Jawaban captcha salah.'])->onlyInput('email');
        }

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun ini bukan admin.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        session()->flash('success', 'Selamat datang, ' . Auth::user()->name . '!');
        return redirect()->intended('/dashboard');
    }
}
