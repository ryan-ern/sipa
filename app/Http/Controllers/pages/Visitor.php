<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Syarat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Visitor extends Controller
{
  public function BerandaUser()
  {

    return view('content.pages.visitor.beranda');
  }

  public function Kegiatan()
  {
    return view('content.pages.visitor.kegiatan');
  }

  public function Persyaratan()
  {
    $data = Syarat::first();
    if (!$data) {
      $data = Syarat::create([
        'id' => Str::uuid(),
        'isi' => 'Default isi syarat masuk.',
      ]);
    }
    return view('content.pages.visitor.persyaratan', compact('data'));
  }

  public function Artikel()
  {
    $data = Artikel::latest()->paginate(10);
    return view('content.pages.visitor.artikel', compact('data'));
  }

  public function ArtikelDetail($id)
  {
    $artikel = Artikel::find($id);

    if (!$artikel) {
      return redirect()->route('artikel-user')->with('error', 'Artikel tidak ditemukan.');
    }

    $prevArtikel = Artikel::where('id', '<', $id)->orderBy('id', 'desc')->first();
    $nextArtikel = Artikel::where('id', '>', $id)->orderBy('id', 'asc')->first();

    return view('content.pages.visitor.artikel-detail', compact('artikel', 'prevArtikel', 'nextArtikel'));
  }

  public function Hubungi()
  {
    return view('content.pages.visitor.hubungi');
  }
}
