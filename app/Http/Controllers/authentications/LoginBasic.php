<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function store(Request $request): RedirectResponse
  {
    $credentials = $request->validate([
      'username' => ['required', 'string'],
      'password' => ['required'],
    ]);

    if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'status' => '1'])) {
      $request->session()->regenerate();
      return redirect()->intended('/');
    }
    if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'status' => '0'])) {
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return back()->with('error', 'Akun anda belum diaktifkan, silahkan tunggu notifikasi selanjutnya');
    }

    return back()->with('error', 'Username atau password salah');
  }

  public function logout(Request $request): RedirectResponse
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/auth/login-basic');
  }
}
