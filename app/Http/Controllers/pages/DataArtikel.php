<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataArtikel extends Controller
{
  public function index()
  {
    $data = Artikel::select('*')->orderBy('created_at', 'desc')->get();

    return view('content.pages.data-artikel', compact('data'));
  }


  public function store(Request $request)
  {
    $validated = Validator::make($request->all(), [
      'judul' => ['required', 'string', 'max:255'],
      'jenis' => ['required', 'string', 'in:artikel,informasi'],
      'tgl_berlaku' => ['nullable', 'string', 'max:255'],
      'isi' => ['required', 'string'],
      'fp_cover' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
    ], [
      'judul.required' => 'Judul harus diisi.',
      'jenis.required' => 'Jenis harus diisi.',
      'jenis.in' => 'Jenis harus artikel atau informasi.',
      'isi.required' => 'Isi artikel harus diisi.',
      'fp_cover.mimes' => 'Format file harus jpg, jpeg, png.',
      'fp_cover.file' => 'File harus berupa file yang valid.',
      'fp_cover.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
    ]);

    if ($validated->fails()) {
      return back()->with('error', 'Artikel ' . $request->judul . ' gagal ditambahkan: ' . $validated->errors()->first());
    }

    $data = $validated->validated();

    $data['user_id'] = Auth::user()->id;

    if ($request->hasFile('fp_cover')) {
      $file = $request->file('fp_cover');
      $originalFileName = $file->getClientOriginalName();
      $fileName = time() . '_' . preg_replace('/\s+/', '_', $originalFileName);
      $filePath = $file->storeAs('covers', $fileName, 'public');
      $data['fp_cover'] = $filePath;
      $data['fn_cover'] = $fileName;
    }


    try {
      Artikel::create($data);
      return back()->with('success', 'Artikel ' . $request->judul . ' berhasil ditambahkan');
    } catch (\Exception $e) {
      return back()->with('error', 'Artikel ' . $request->judul . ' gagal ditambahkan');
    }
  }


  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'judul' => ['required', 'string', 'max:255'],
      'jenis' => ['required', 'string', 'in:artikel,informasi'],
      'isi' => ['required', 'string'],
      'tgl_berlaku' => ['nullable', 'string', 'max:255'],
      'fp_cover' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
    ], [
      'judul.required' => 'Judul harus diisi.',
      'jenis.required' => 'Jenis harus diisi.',
      'jenis.in' => 'Jenis harus artikel atau informasi.',
      'isi.required' => 'Isi artikel harus diisi.',
      'fp_cover.mimes' => 'Format file harus jpg, jpeg, png.',
    ]);

    if ($validator->fails()) {
      return back()->with('error', 'Artikel ' . $request->judul . ' gagal diubah: ' . $validator->errors()->first());
    }

    $artikel = Artikel::find($id);
    if (!$artikel) {
      return back()->with('error', 'Artikel tidak ditemukan.');
    }

    $data = $validator->validated();
    $data['user_id'] = Auth::user()->id;

    if ($request->hasFile('fp_cover')) {
      $file = $request->file('fp_cover');
      $originalFileName = $file->getClientOriginalName();
      $fileName = time() . '_' . preg_replace('/\s+/', '_', $originalFileName);
      $filePath = $file->storeAs('covers', $fileName, 'public');

      $data['fp_cover'] = $filePath;
      $data['fn_cover'] = $fileName;
    }
    try {
      $artikel->update($data);
      return back()->with('success', 'Artikel ' . $request->judul . ' berhasil diubah');
    } catch (\Exception $e) {
      return back()->with('error', 'Artikel ' . $request->judul . ' gagal diubah: ' . $e->getMessage());
    }
  }




  public function destroy($id)
  {
    $artikel = Artikel::findOrFail($id);
    try {
      $artikel->delete();
      return back()->with('success', 'Artikel ' . $artikel->judul . ' berhasil dihapus');
    } catch (\Exception $e) {
      return back()->with('error', 'Artikel ' . $artikel->judul . ' gagal dihapus: ' . $e->getMessage());
    }
  }
}
