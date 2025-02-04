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
      'username' => ['required', 'string', 'max:255', 'exists:users,username'],
    ], [
      '*.required' => ':attribute harus diisi.',
      '*.exists' => ':attribute tidak ditemukan.',
      '*.max' => ':attribute maksimal :max karakter.',
    ]);

    if ($validator->fails()) {
      return back()->with('error', $validator->errors()->first());
    }

    try {
      $user = User::where('username', $request->username)->first();
      $user->update([
        'forgot' => 1,
      ]);
      return redirect()->route('login')->with('success', 'Permintaan Ubah Password Berhasil, Silahkan Tunggu Konfirmasi Dari Admin');
    } catch (\Throwable $th) {
      return back()->with('error', $validator->errors()->first());
    }
  }
}
