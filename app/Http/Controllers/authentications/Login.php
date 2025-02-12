<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class Login extends Controller
{
  public function index()
  {
    return view('content.authentications.login');
  }

  public function store(Request $request): RedirectResponse
  {
    $credentials = $request->validate([
      'username' => ['required', 'string'],
      'password' => ['required'],
    ]);

    $count = session('count_login', 0);

    if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'status' => '1'])) {
      $request->session()->forget('count_login');
      $request->session()->regenerate();
      if (Auth::user()->role == 'admin') {
        return redirect()->intended('/dashboard')->with('success', 'Selamat datang ' . Auth::user()->nama_lengkap);
      } else {
        $user = Auth::user();
        if (Anak::where('user_id', $user->id)->exists()) {
          return redirect()->intended('/pages/kondisi-anak')->with('success', 'Selamat datang ' . Auth::user()->nama_lengkap);
        } else {
          return redirect()->intended('/pages/pendaftaran-anak')->with('success', 'Selamat datang ' . Auth::user()->nama_lengkap);
        }
      }
    }
    if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'status' => '0'])) {
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return back()->with('error', 'Akun anda belum diaktifkan, silahkan tunggu notifikasi selanjutnya');
    }

    $count++;
    $request->session()->put('count_login', $count);

    if ($count >= 3) {
      return back()->with('error', 'lakukan reset password atau buat akun baru jika belum memiliki akun');
    }

    return back()->with('error', 'Username atau password salah');
  }

  public function logout(Request $request): RedirectResponse
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('beranda-user')->with('success', 'Logout berhasil');
  }
}
