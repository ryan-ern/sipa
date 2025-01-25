<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Artikel;
use App\Models\Donasi;
use Illuminate\Http\Request;

class Admin extends Controller
{
  public function index(Request $request)
  {
    $bulan = $request->input('bulan') ? date('m', strtotime($request->input('bulan'))) : now()->format('m');
    $tahun = $request->input('bulan') ? date('Y', strtotime($request->input('bulan'))) : now()->format('Y');
    $filteredData = Anak::whereMonth('created_at', $bulan)
      ->whereYear('created_at', $tahun)
      ->get();

    $existingData = $filteredData->map(function ($item) {
      $splitData = explode('~', $item->biodata);
      return (object) [
        'nama' => $splitData[0] ?? '-',
        'ttl' => $splitData[1] ?? '-',
        'nik' => $splitData[2] ?? '-',
        'jk' => $splitData[3] ?? '-',
        'status_anak' => $splitData[4] ?? '-',
        'pendidikan' => $splitData[5] ?? '-',
        'alamat' => $splitData[6] ?? '-',
        'ortu' => $splitData[7] ?? '-',
        'pekerjaan' => $splitData[8] ?? '-',
        'no_tel' => $splitData[9] ?? '-',
      ];
    });

    // Hitung data anak berdasarkan kriteria
    $countAnakAktif = $filteredData->where('status', 'aktif')->count();
    $countAnakYatimPiatu = $existingData->filter(function ($item) {
      return $item->status_anak === 'Anak Yatim Piatu';
    })->count();
    $countAnakYatim = $existingData->filter(function ($item) {
      return $item->status_anak === 'Anak Yatim';
    })->count();
    $countAnakPiatu = $existingData->filter(function ($item) {
      return $item->status_anak === 'Anak Piatu';
    })->count();
    $countAnakLaki = $existingData->filter(function ($item) {
      return strtolower($item->jk) === 'laki-laki';
    })->count();
    $countAnakPerempuan = $existingData->filter(function ($item) {
      return strtolower($item->jk) === 'perempuan';
    })->count();
    $countAnakLulus = $filteredData->where('status', 'alumni lulus')->count();
    $countAnakBermasalah = $filteredData->where('status', 'alumni bermasalah')->count();
    $countDataDonasi = Donasi::whereMonth('created_at', $bulan)
      ->whereYear('created_at', $tahun)
      ->count();
    $countDataArtikel = Artikel::whereMonth('created_at', $bulan)
      ->whereYear('created_at', $tahun)
      ->count();

    // Return ke view dengan data yang difilter
    return view('content.pages.admin', [
      'countAnakAktif' => $countAnakAktif ?? 0,
      'countAnakYatimPiatu' => $countAnakYatimPiatu ?? 0,
      'countAnakYatim' => $countAnakYatim ?? 0,
      'countAnakPiatu' => $countAnakPiatu ?? 0,
      'countAnakLulus' => $countAnakLulus ?? 0,
      'countAnakBermasalah' => $countAnakBermasalah ?? 0,
      'countDataDonasi' => $countDataDonasi ?? 0,
      'countDataArtikel' => $countDataArtikel ?? 0,
      'countAnakLaki' => $countAnakLaki ?? 0,
      'countAnakPerempuan' => $countAnakPerempuan ?? 0,
      'bulan' => $bulan,
      'tahun' => $tahun,
    ]);
  }
}
