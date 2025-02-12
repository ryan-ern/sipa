<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
      'tujuan' => ['required', 'string'],
      'jenis' => ['required', 'string', 'in:makanan,barang,lainnya'],
      'keterangan' => ['required', 'string', 'max:255'],
      'kegunaan' => ['required', 'string'],
      'fp_donasi' => ['nullable', 'file', 'mimes:jpeg,png,jpg'],
    ], [
      'nama.required' => 'Nama harus diisi.',
      'tujuan.required' => 'Nomor telepon harus diisi.',
      'jenis.required' => 'Jenis donasi harus diisi.',
      'keterangan.required' => 'Keterangan harus diisi.',
      'kegunaan.required' => 'Kegunaan harus diisi.',
      'fp_donasi.mimes' => 'Format file harus jpeg, png, jpg.',
      'fp_donasi.file' => 'File harus berupa file yang valid.',
      'fp_donasi.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
    ]);

    if ($validated->fails()) {
      return back()->with('error', 'Data Donasi ' . $request->nama . ' gagal ditambahkan: ' . $validated->errors()->first());
    }

    try {
      $data = $validated->validated();
      if ($request->hasFile('fp_donasi')) {
        $file = $request->file('fp_donasi');
        $originalFileName = $file->getClientOriginalName();
        $fileName = time() . '_' . preg_replace('/\s+/', '_', $originalFileName);
        $filePath = $file->storeAs('donasi', $fileName, 'public');
        $data['fp_donasi'] = $filePath;
        $data['fn_donasi'] = $fileName;
      }
      Donasi::create($data);
      return back()->with('success', 'Data Donasi ' . $request->nama . ' berhasil ditambahkan');
    } catch (\Exception $e) {
      return back()->with('error', 'Data Donasi ' . $request->nama . ' gagal ditambahkan: ' . $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'nama' => ['required', 'string', 'max:255'],
      'tujuan' => ['required', 'string'],
      'jenis' => ['required', 'string', 'in:makanan,barang,lainnya'],
      'keterangan' => ['required', 'string', 'max:255'],
      'kegunaan' => ['required', 'string'],
      'fp_donasi' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
    ], [
      'nama.required' => 'Nama harus diisi.',
      'tujuan.required' => 'Nomor telepon harus diisi.',
      'jenis.required' => 'Jenis donasi harus diisi.',
      'keterangan.required' => 'Keterangan harus diisi.',
      'kegunaan.required' => 'Kegunaan harus diisi.',
      'fp_donasi.mimes' => 'Format file harus jpeg, png, jpg.',
      'fp_donasi.max' => 'Ukuran file tidak boleh lebih dari 2MB.',

    ]);

    if ($validator->fails()) {
      return back()->with('error', 'Data Donasi ' . $request->nama . ' gagal diubah: ' . $validator->errors()->first());
    }

    $donasi = Donasi::find($id);
    if (!$donasi) {
      return back()->with('error', 'Data Donasi tidak ditemukan.');
    }

    try {
      $data = $validator->validated();
      if ($request->hasFile('fp_donasi')) {
        if ($donasi->fp_donasi && Storage::disk('public')->exists($donasi->fp_donasi)) {
          Storage::disk('public')->delete($donasi->fp_donasi);
        }

        $file = $request->file('fp_donasi');
        $originalFileName = $file->getClientOriginalName();
        $fileName = time() . '_' . preg_replace('/\s+/', '_', $originalFileName);
        $filePath = $file->storeAs('donasis', $fileName, 'public');

        $data['fp_donasi'] = $filePath;
        $data['fn_donasi'] = $fileName;
      }
      $donasi->update($data);
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
