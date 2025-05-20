<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataKegiatan extends Controller
{
  public function index()
  {
    $data = Kegiatan::select('*')->orderBy('updated_at', 'DESC')->get();
    return view('content.pages.data-kegiatan', compact('data'));
  }

  public function getEvents()
  {
    $events = Kegiatan::select(['id', 'kegiatan as title', 'waktu_mulai as start', 'waktu_selesai as end', 'keterangan as desc'])
      ->get();
    return response()->json($events);
  }



  public function store(Request $request)
  {
    $validated = Validator::make($request->all(), [
      'kegiatan' => ['required', 'string', 'max:255'],
      'waktu_mulai' => ['required', 'date'],
      'waktu_selesai' => ['required', 'date', 'after_or_equal:waktu_mulai'],
      'keterangan' => ['required', 'string'],
    ], [
      'kegiatan.required' => 'Kegiatan harus diisi.',
      'waktu_mulai.required' => 'Waktu mulai harus diisi.',
      'waktu_selesai.required' => 'Waktu selesai harus diisi.',
      'waktu_selesai.after_or_equal' => 'Waktu selesai tidak boleh lebih awal dari waktu mulai.',
      'keterangan.required' => 'Keterangan harus diisi.',
    ]);


    if ($validated->fails()) {
      return back()->with('error', 'Kegiatan ' . $request->kegiatan . ' gagal ditambahkan: ' . $validated->errors()->first());
    }

    try {
      Kegiatan::create($validated->validated());
      return back()->with('success', 'Kegiatan ' . $request->kegiatan . ' berhasil ditambahkan');
    } catch (\Exception $e) {
      return back()->with('error', 'Kegiatan ' . $request->kegiatan . ' gagal ditambahkan: ' . $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'kegiatan' => ['required', 'string', 'max:255'],
      'waktu_mulai' => ['required', 'date'],
      'waktu_selesai' => ['required', 'date'],
      'keterangan' => ['required', 'string'],
    ], [
      'kegiatan.required' => 'Kegiatan harus diisi.',
      'waktu_mulai.required' => 'Waktu mulai harus diisi.',
      'waktu_selesai.required' => 'Waktu selesai harus diisi.',
      'keterangan.required' => 'Keterangan harus diisi.',
    ]);

    if ($validator->fails()) {
      return back()->with('error', 'Kegiatan ' . $request->kegiatan . ' gagal diubah: ' . $validator->errors()->first());
    }

    try {
      $kegiatan = Kegiatan::findOrFail($id);
      $kegiatan->update($validator->validated());
      return back()->with('success', 'Kegiatan ' . $request->kegiatan . ' berhasil diubah');
    } catch (\Exception $e) {
      return back()->with('error', 'Kegiatan ' . $request->kegiatan . ' gagal diubah: ' . $e->getMessage());
    }
  }

  public function destroy($id)
  {
    $kegiatan = Kegiatan::findOrFail($id);
    try {
      $kegiatan->delete();
      return back()->with('success', 'Kegiatan ' . $kegiatan->kegiatan . ' berhasil dihapus');
    } catch (\Exception $e) {
      return back()->with('error', 'Kegiatan ' . $kegiatan->kegiatan . ' gagal dihapus: ' . $e->getMessage());
    }
  }
}
