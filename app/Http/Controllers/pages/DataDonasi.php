<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataDonasi extends Controller
{
  public function index()
  {
    $data = Donasi::select('*')->orderBy('updated_at', 'DESC')->get();

    return view('content.pages.data-donasi', compact('data'));
  }

  public function store(Request $request)
  {
    $validated = Validator::make($request->all(), [
      'nama' => ['required', 'string', 'max:255'],
      'no_tel' => ['required', 'regex:/^(?:\+62|0)[2-9][0-9]{7,11}$/'],
      'jenis' => ['required', 'string', 'in:uang,barang,lainnya'],
      'keterangan' => ['required', 'string', 'max:255'],
    ], [
      'nama.required' => 'Nama harus diisi.',
      'no_tel.required' => 'Nomor telepon harus diisi.',
      'no_tel.regex' => 'Format nomor telepon tidak valid (gunakan +62xxxxx atau 08xxxxxx).',
      'jenis.required' => 'Jenis donasi harus diisi.',
      'keterangan.required' => 'Keterangan harus diisi.',
    ]);

    if ($validated->fails()) {
      return back()->with('error', 'Data Donasi ' . $request->nama . ' gagal ditambahkan: ' . $validated->errors()->first());
    }

    try {
      Donasi::create($validated->validated());
      return back()->with('success', 'Data Donasi ' . $request->nama . ' berhasil ditambahkan');
    } catch (\Exception $e) {
      return back()->with('error', 'Data Donasi ' . $request->nama . ' gagal ditambahkan: ' . $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'nama' => ['required', 'string', 'max:255'],
      'no_tel' => ['required', 'regex:/^(?:\+62|0)[2-9][0-9]{7,11}$/'],
      'jenis' => ['required', 'string', 'in:uang,barang,lainnya'],
      'keterangan' => ['required', 'string', 'max:255'],
    ], [
      'nama.required' => 'Nama harus diisi.',
      'no_tel.required' => 'Nomor telepon harus diisi.',
      'no_tel.regex' => 'Format nomor telepon tidak valid (gunakan +62xxxxx atau 08xxxxxx).',
      'jenis.required' => 'Jenis donasi harus diisi.',
      'keterangan.required' => 'Keterangan harus diisi.',
    ]);

    if ($validator->fails()) {
      return back()->with('error', 'Data Donasi ' . $request->nama . ' gagal diubah: ' . $validator->errors()->first());
    }

    $donasi = Donasi::find($id);
    if (!$donasi) {
      return back()->with('error', 'Data Donasi tidak ditemukan.');
    }

    try {
      $donasi->update($validator->validated());
      return back()->with('success', 'Data Donasi ' . $request->nama . ' berhasil diubah');
    } catch (\Exception $e) {
      return back()->with('error', 'Data Donasi ' . $request->nama . ' gagal diubah: ' . $e->getMessage());
    }
  }

  public function destroy($id)
  {
    $donasi = Donasi::findOrFail($id);
    try {
      $donasi->delete();
      return back()->with('success', 'Data Donasi ' . $donasi->nama . ' berhasil dihapus');
    } catch (\Exception $e) {
      return back()->with('error', 'Data Donasi ' . $donasi->nama . ' gagal dihapus: ' . $e->getMessage());
    }
  }
}
