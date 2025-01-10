<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Syarat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SyaratMasuk extends Controller
{
  public function index()
  {
    $data = Syarat::first();
    if (!$data) {
      $data = Syarat::create([
        'id' => Str::uuid(),
        'isi' => 'Default isi syarat masuk.',
      ]);
    }
    return view('content.pages.syarat-masuk', compact('data'));
  }

  public function update(Request $request, $id)
  {
    $validated = Validator::make($request->all(), [
      'isi' => ['required', 'string'],
    ], [
      'isi.required' => 'Syarat masuk harus diisi.',
    ]);


    if ($validated->fails()) {
      return back()->with('error', 'Syarat masuk gagal diperbarui: ' . $validated->errors()->first());
    }

    $syarat = Syarat::findOrFail($id);

    if (!$syarat) {
      Syarat::create([
        'id' => Str::uuid(),
        'isi' => 'Default isi syarat masuk.',
      ]);
    }

    try {
      $syarat->update($validated->validated());
      return back()->with('success', 'Syarat masuk berhasil diperbarui.');
    } catch (\Exception $e) {
      return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
  }
}
