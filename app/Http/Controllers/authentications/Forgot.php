<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Forgot extends Controller
{
  public function index()
  {
    return view('content.authentications.forgot');
  }

  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nik' => ['required', 'string', 'regex:/^\d{10,20}$/', 'exists:users,nik'],
    ], [
      '*.required' => ':attribute harus diisi.',
      '*.exists' => ':attribute tidak ditemukan.',
      '*.max' => ':attribute maksimal :max karakter.',
      '*.regex' => ':attribute harus berupa 16 angka atau nik yang terdaftar.',
    ]);

    if ($validator->fails()) {
      return back()->with('error', $validator->errors()->first());
    }

    try {
      $user = User::where('nik', $request->nik)->first();
      $user->update([
        'forgot' => 1,
      ]);
      return redirect()->route('login')->with('success', 'Permintaan Ubah Password Berhasil, Silahkan Tunggu Konfirmasi Dari Admin');
    } catch (\Throwable $th) {
      return back()->with('error', $validator->errors()->first());
    }
  }
}
