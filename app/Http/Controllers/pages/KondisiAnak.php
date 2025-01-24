<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KondisiAnak extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();
    if (!Anak::where('user_id', $user->id)->exists()) {
      return redirect('/pages/pendaftaran-anak')->with('error', 'Silahkan daftarkan anak anda terlebih dahulu');
    }
    $selectedId = $request->id;

    $data = Riwayat::select('riwayats.*', 'anaks.biodata')
      ->join('anaks', 'riwayats.anaks_id', '=', 'anaks.id')
      ->orderBy('riwayats.updated_at', 'DESC')
      ->get();

    $anak = Anak::where('user_id', Auth::user()->id)->get();

    $info = $selectedId
      ? Anak::where('user_id', Auth::user()->id)->where('id', $selectedId)->first()
      : Anak::where('user_id', Auth::user()->id)->first();

    $riwayat = Riwayat::select('*')
      ->where('user_id', Auth::user()->id)
      ->where('anaks_id', $selectedId ?? $info->id)
      ->orderBy('updated_at', 'DESC')
      ->first();

    $processData = function ($data) {
      return $data->map(function ($item) {
        $splitData = explode('~', $item->biodata);
        $item->biodata = (object) [
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
        return $item;
      });
    };

    if ($info) {
      $splitData = explode('~', $info->biodata);
      $parsedBiodata = [
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
      $infoData = (object) array_merge($parsedBiodata, $info->toArray());
    }

    return view('content.pages.user.kondisi-anak', [
      'data' => $processData($data),
      'riwayat' => $riwayat ?? null,
      'anak' => $processData($anak),
      'info' => $infoData ?? null
    ]);
  }
}
