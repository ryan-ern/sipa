<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DataAnak extends Controller
{
  public function index()
  {
    $data = Anak::select('*')->orderBy('updated_at', 'DESC')->get();
    $aktif = Anak::select('*')->where('status', 'aktif')->get();
    $alumni = Anak::select('*')->where('status', 'alumni lulus')->get();
    $alumniBermasalah = Anak::select('*')->where('status', 'alumni bermasalah')->get();
    $riwayat = Riwayat::select('riwayats.*', 'anaks.biodata')
      ->join('anaks', 'riwayats.anaks_id', '=', 'anaks.id')
      ->orderBy('riwayats.updated_at', 'DESC')
      ->get();
    $data = $data->map(function ($item) {
      $splitData = explode('~', $item->biodata);
      $item->biodata = (object)[
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
    return view('content.pages.data-anak', [
      'riwayat' => $processData($riwayat),
      'data' => $data,
      'aktif' => $processData($aktif),
      'alumni' => $processData($alumni),
      'alumniBermasalah' => $processData($alumniBermasalah),
    ]);
  }


  public function store(Request $request, $id = null)
  {
    $validator = Validator::make($request->all(), [
      'user_id' => ['nullable', 'string'],
      'nama' => ['required', 'string', 'max:255'],
      'ttl' => ['required', 'string', 'max:255'],
      'nik' => ['required', 'string', 'max:255'],
      'jk' => ['required', 'string'],
      'status_anak' => ['required', 'string'],
      'pendidikan' => ['required', 'string'],
      'alamat' => ['required', 'string'],
      'ortu' => ['required', 'string'],
      'pekerjaan' => ['required', 'string'],
      'status' => ['nullable', 'string'],
      'keterangan' => ['nullable', 'string'],
      'fp_surat_izin' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
      'fp_suket_tidak_mampu' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
      'fp_suket_kematian' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
      'fp_suket_sehat' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
      'fp_ktp' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
      'fp_kk' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
      'fp_bpjs' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
      'fp_akte' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
      'fp_foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
    ], [
      '*.required' => ':attribute harus diisi.',
      '*.file' => ':attribute harus berupa file yang valid.',
      '*.mimes' => 'Format file :attribute harus pdf, jpg, jpeg, atau png.',
      '*.max' => 'Ukuran file :attribute maksimal 2MB.',
    ]);

    if ($validator->fails()) {
      return back()->with('error', 'Pendaftaran anak gagal disimpan: ' . $validator->errors()->first());
    }

    $files = [
      'fp_surat_izin',
      'fp_suket_tidak_mampu',
      'fp_suket_kematian',
      'fp_suket_sehat',
      'fp_ktp',
      'fp_kk',
      'fp_bpjs',
      'fp_akte',
      'fp_foto',
    ];

    $fileNames = [
      'fn_surat_izin',
      'fn_suket_tidak_mampu',
      'fn_suket_kematian',
      'fn_suket_sehat',
      'fn_ktp',
      'fn_kk',
      'fn_bpjs',
      'fn_akte',
      'fn_foto',
    ];

    $data = [];
    foreach ($files as $fileKey) {
      if ($request->hasFile($fileKey)) {
        if ($id) {
          $existingFile = Anak::find($id)->$fileKey;
          if ($existingFile && Storage::disk('public')->exists($existingFile)) {
            Storage::disk('public')->delete($existingFile);
          }
        }
        $file = $request->file($fileKey);
        $originalFileName = $file->getClientOriginalName();
        $fileName = str_replace('fn_', '', $fileNames[array_search($fileKey, $files)]) . '_' . $request->nik . '_' . preg_replace('/\s+/', '_', $originalFileName);
        $filePath = $file->storeAs('documents/' . str_replace('fp_', '', $fileKey), $fileName, 'public');
        $data[$fileKey] = $filePath;
        $data[$fileNames[array_search($fileKey, $files)]] = $fileName;
      }
    }

    $existingData = Anak::all()->map(function ($item) {
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

    $biodata = implode('~', [
      $request->nama,
      $request->ttl,
      $request->nik,
      $request->jk,
      $request->status_anak,
      $request->pendidikan,
      $request->alamat,
      $request->ortu,
      $request->pekerjaan,
      $request->no_tel
    ]);

    try {
      $data['user_id'] = $request->user_id ?? Auth::id();
      $data['biodata'] = $biodata;
      $data['status'] = $request->status ?? 'aktif';
      $data['keterangan'] = $request->keterangan ?? '-';

      if ($id) {
        Anak::where('id', $id)->update($data);
        if (Auth::user()->role == 'admin') {
          return back()->with('success', 'Data anak ' . $request->nama .  ' berhasil diperbarui');
        } else {
          return redirect()->route('kondisi-anak')->with('success', 'Data anak ' . $request->nama . ' berhasil diperbarui');
        }
      } else {
        if ($existingData->contains('nik', $request->nik)) {
          return back()->with('error', 'Data anak gagal disimpan: NIK sudah terdaftar');
        }
        Anak::create($data);
        return back()->with('success', 'Data anak berhasil disimpan');
      }
    } catch (\Exception $e) {
      return back()->with('error', 'Data anak gagal disimpan: ' . $e->getMessage());
    }
  }

  public function riwayat(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'status' => 'required',
        'keterangan' => 'required',
        'user_id' => 'required',
        'anaks_id' => 'required',
      ],
      [
        '*.required' => ':attribute harus diisi.',
      ]
    );

    if ($validator->fails()) {
      return back()->with('error', 'Data riwayat gagal disimpan: ' . $validator->errors()->first());
    }
    try {
      $data = $request->all();
      Riwayat::create($data);
      return back()->with('success', 'Data riwayat berhasil disimpan');
    } catch (\Exception $e) {
      return back()->with('error', 'Data riwayat gagal disimpan: ' . $e->getMessage());
    }
  }
}
