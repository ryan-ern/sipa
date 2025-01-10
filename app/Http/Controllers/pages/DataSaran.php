<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Saran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataSaran extends Controller
{
  public function index()
  {
    $data = Saran::select('*')->orderBy('updated_at', 'DESC')->get();

    return view('content.pages.data-saran', compact('data'));
  }

  public function store(Request $request)
  {
    $validated = Validator::make($request->all(), [
      'nama' => ['required', 'string', 'max:255'],
      'no_tel' => ['required', 'regex:/^(?:\+62|0)[2-9][0-9]{7,11}$/'],
      'keterangan' => ['required', 'string', 'max:255'],
    ], [
      'nama.required' => 'Nama harus diisi.',
      'no_tel.required' => 'Nomor telepon harus diisi.',
      'no_tel.regex' => 'Format nomor telepon tidak valid (gunakan +62xxxxx atau 08xxxxxx).',
      'keterangan.required' => 'Keterangan harus diisi.',
    ]);

    if ($validated->fails()) {
      return back()->with('error', 'Data Saran ' . $request->nama . ' gagal ditambahkan: ' . $validated->errors()->first());
    }

    try {
      Saran::create($validated->validated());
      return back()->with('success', 'Data Saran ' . $request->nama . ' berhasil ditambahkan');
    } catch (\Exception $e) {
      return back()->with('error', 'Data Saran ' . $request->nama . ' gagal ditambahkan: ' . $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    $validated = Validator::make($request->all(), [
      'nama' => ['required', 'string', 'max:255'],
      'no_tel' => ['required', 'regex:/^(?:\+62|0)[2-9][0-9]{7,11}$/'],
      'keterangan' => ['required', 'string', 'max:255'],
    ], [
      'nama.required' => 'Nama harus diisi.',
      'no_tel.required' => 'Nomor telepon harus diisi.',
      'no_tel.regex' => 'Format nomor telepon tidak valid (gunakan +62xxxxx atau 08xxxxxx).',
      'keterangan.required' => 'Keterangan harus diisi.',
    ]);

    if ($validated->fails()) {
      return back()->with('error', 'Data Saran ' . $request->nama . ' gagal diubah: ' . $validated->errors()->first());
    }

    try {
      $saran = Saran::findOrFail($id);
      $saran->update($validated->validated());
      return back()->with('success', 'Data Saran ' . $request->nama . ' berhasil diubah');
    } catch (\Exception $e) {
      return back()->with('error', 'Data Saran ' . $request->nama . ' gagal diubah: ' . $e->getMessage());
    }
  }

  public function destroy($id)
  {
    $saran = Saran::findOrFail($id);
    try {
      $saran->delete();
      return back()->with('success', 'Data Saran ' . $saran->nama . ' berhasil dihapus');
    } catch (\Exception $e) {
      return back()->with('error', 'Data Saran ' . $saran->nama . ' gagal dihapus: ' . $e->getMessage());
    }
  }
}
