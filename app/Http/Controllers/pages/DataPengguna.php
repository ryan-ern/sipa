<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataPengguna extends Controller
{
  public function index()
  {
    $data = User::select('*')->orderBy('updated_at', 'DESC')->get();

    return view('content.pages.data-pengguna', compact('data'));
  }

  public function store(Request $request)
  {
    // Validasi input
    $validator = $request->validate([
      'username' => ['required', 'string', 'max:255', 'unique:users'],
      'nama_lengkap' => ['required', 'string', 'max:255'],
      'no_tel' => ['required', 'regex:/^(?:\+62|0)[2-9][0-9]{7,11}$/'],
      'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
      'alamat' => ['required', 'string', 'max:255'],
      'sebagai' => ['required', 'string', 'in:ortu,wali,staff'],
      'role' => ['required', 'string', 'in:admin,user'],
      'password' => ['required', 'string', 'min:3', 'confirmed'],
      'status' => ['required', 'string', 'in:1,0'],
    ], [
      'username.required' => 'Username harus diisi.',
      'username.unique' => 'Username sudah terdaftar.',
      'nama_lengkap.required' => 'Nama lengkap harus diisi.',
      'no_tel.required' => 'Nomor telepon harus diisi.',
      'no_tel.regex' => 'Format nomor telepon tidak valid (gunakan +62 atau 08).',
      'jenis_kelamin.required' => 'Jenis kelamin harus diisi.',
      'alamat.required' => 'Alamat harus diisi.',
      'sebagai.required' => 'Jenis akun harus diisi.',
      'password.required' => 'Password harus diisi.',
      'password.min' => 'Password minimal harus 8 karakter.',
      'password.confirmed' => 'Password tidak cocok.',
      'status.required' => 'Status harus diisi.',
      'role.required' => 'Role harus diisi.',
    ]);

    try {
      User::create([
        'username' => $validator['username'],
        'nama_lengkap' => $validator['nama_lengkap'],
        'sebagai' => $validator['sebagai'],
        'no_tel' => $validator['no_tel'],
        'alamat' => $validator['alamat'],
        'jenis_kelamin' => $validator['jenis_kelamin'],
        'role' => $validator['role'],
        'status' => $validator['status'],
        'password' => bcrypt($validator['password']),
      ]);
    } catch (\Exception $e) {
      return back()->with('error', 'Data pengguna' . $validator['nama_lengkap'] . ' gagal ditambahkan : ' . $e->getMessage());
    }

    return back()->with('success', 'Data pengguna' . $validator['nama_lengkap'] . ' berhasil ditambahkan');
  }

  public function update(Request $request, $id)
  {
    $validated = Validator::make($request->all(), [
      'nama_lengkap' => ['required', 'string', 'max:255'],
      'no_tel' => ['required', 'regex:/^(?:\+62|0)[2-9][0-9]{7,11}$/'],
      'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan'],
      'alamat' => ['required', 'string', 'max:255'],
      'sebagai' => ['required', 'string', 'in:ortu,wali,staff'],
      'role' => ['required', 'string', 'in:admin,user'],
      'status' => ['required', 'string', 'in:1,0'],
      'password' => ['nullable', 'string', 'min:3'],
    ], [
      'nama_lengkap.required' => 'Nama lengkap harus diisi.',
      'no_tel.required' => 'Nomor telepon harus diisi.',
      'no_tel.regex' => 'Format nomor telepon tidak valid (gunakan +62 atau 08).',
      'jenis_kelamin.required' => 'Jenis kelamin harus diisi.',
      'alamat.required' => 'Alamat harus diisi.',
      'sebagai.required' => 'Jenis akun harus diisi.',
      'status.required' => 'Status harus diisi.',
      'role.required' => 'Role harus diisi.',
      'password.min' => 'Password minimal harus 3 karakter.',
    ]);

    if ($validated->fails()) {
      return back()->with('error', 'Data pengguna ' . $request->nama_lengkap . ' gagal diubah: ' . $validated->errors()->first());
    }

    try {
      $user = User::findOrFail($id);
      $validatedData = $validated->validated();

      if ($request->filled('password')) {
        $validatedData['password'] = bcrypt($request->password);
      } else {
        unset($validatedData['password']);
      }

      $user->update($validatedData);

      return back()->with('success', 'Data pengguna ' . $user->nama_lengkap . ' berhasil diubah');
    } catch (\Exception $e) {
      return back()->with('error', 'Data pengguna' . $user->nama_lengkap . ' gagal diubah: ' . $e->getMessage());
    }
  }



  public function destroy($id)
  {
    $user = User::findOrFail($id);
    if (!$user) {
      return back()->with('error', 'Data pengguna tidak ditemukan');
    }
    try {
      if (Auth::user()->id == $id) {
        return back()->with('error', 'Data pengguna' . $user->nama_lengkap . ' tidak dapat dihapus');
      }
      User::findOrFail($id)->delete();
      return back()->with('success', 'Data pengguna' . $user->nama_lengkap . ' berhasil dihapus');
    } catch (\Exception $e) {
      return back()->with('error', 'Data pengguna' . $user->nama_lengkap . ' gagal dihapus : ' . $e->getMessage());
    }
  }
}
