<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Register extends Controller
{
  public function index()
  {
    return view('content.authentications.register');
  }

  public function store(Request $request): RedirectResponse
  {
    $validated = $request->validate([
      'username' => ['required', 'string', 'max:255', 'unique:users'],
      'nama_lengkap' => ['required', 'string', 'max:255'],
      'no_tel' => ['required', 'regex:/^\+628\d{9,15}$/'],
      'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
      'alamat' => ['required', 'string'],
      'sebagai' => ['required', 'string', 'in:ortu,wali'],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ], [
      'username.required' => 'Username harus diisi.',
      'username.unique' => 'Username sudah terdaftar.',
      'nama_lengkap.required' => 'Nama lengkap harus diisi.',
      'no_tel.required' => 'Nomor telepon harus diisi.',
      'no_tel.regex' => 'Format nomor telepon tidak valid (harus diawali +628 dan diikuti 9-15 digit angka).',
      'jenis_kelamin.required' => 'Jenis kelamin harus diisi.',
      'alamat.required' => 'Alamat harus diisi.',
      'sebagai.required' => 'Jenis akun harus diisi.',
      'password.required' => 'Password harus diisi.',
      'password.min' => 'Password minimal harus 8 karakter.',
      'password.confirmed' => 'Password tidak cocok.',
    ]);


    try {
      User::create([
        'nama_lengkap' => $validated['nama_lengkap'],
        'username' => $validated['username'],
        'no_tel' => $validated['no_tel'],
        'jenis_kelamin' => $validated['jenis_kelamin'],
        'alamat' => $validated['alamat'],
        'sebagai' => $validated['sebagai'],
        'password' => bcrypt($validated['password']),
      ]);
      return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan tunggu notifikasi selanjutnya.');
    } catch (\Exception $e) {
      return back()->with('error', 'Terjadi kesalahan saat mendaftarkan akun. Silakan coba lagi. Error: ' . $e->getMessage());
    }
  }
}
