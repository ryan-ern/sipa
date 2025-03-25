<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pendaftaran;
use App\Models\Riwayat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DataAnak extends Controller
{
  public function index()
  {
    $data = Anak::select('*')->orderBy('updated_at', 'DESC')->get();
    $aktif = Anak::select('*')->where('status', 'aktif')->get();
    $alumni = Anak::select('*')->where('status', 'alumni lulus')->get();
    $alumniBermasalah = Anak::select('*')->where('status', 'alumni keluar')->get();
    $user = User::where('role', 'user')
      ->whereIn('sebagai', ['ortu', 'wali'])
      ->where('status', '1')
      ->get();
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
      'user' => $user
    ]);
  }

  public function detail($id)
  {
    $info = Anak::where('id', $id)->first();
    if ($info) {
      $splitData = explode('~', $info->biodata);
      $info->biodata = (object) [
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
    }
    return view('content.pages.data-anak-detail',  [
      'filesAnak' => $info,
      'info' => $info,
    ]);
  }

  public function store(Request $request, $id = null)
  {
    if ($id == null) {
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
        'fp_formulir' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
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
    }

    $files = [
      'fp_formulir',
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
      'fn_formulir',
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
        $file = $request->file($fileKey);
        $originalFileName = $file->getClientOriginalName();
        $fileName = str_replace('fn_', '', $fileNames[array_search($fileKey, $files)]) . '_' . $request->nik . '_' . preg_replace('/\s+/', '_', $originalFileName);
        $filePath = $file->storeAs('documents/' . str_replace('fp_', '', $fileKey), $fileName, 'private');
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
      $request->ortu ?? $existingData->where('ortu', $request->ortu)->first()->ortu ?? '-',
      $request->pekerjaan,
      $request->no_tel ?? $existingData->where('ortu', $request->ortu)->first()->no_tel ?? '-',
    ]);

    try {
      if ($id) {
        $daftar = Pendaftaran::find($request->pendaftarans_id ?? $id);
        if (!$daftar) {
          return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }
        $dataAnakLama = Anak::find($id);
        Anak::where('id', $id)->update([
          'user_id' => $request->user_id ?? Auth::id(),
          'biodata' => $biodata,
          'status' => $request->status ?? 'aktif',
          'keterangan' => $request->keterangan ?? '-',
          'fp_formulir' => $data['fp_formulir'] ?? $daftar->fp_formulir ?? $dataAnakLama->fp_formulir,
          'fn_formulir' => $data['fn_formulir'] ?? $daftar->fn_formulir ?? $dataAnakLama->fn_formulir,
          'fp_surat_izin' => $data['fp_surat_izin'] ?? $daftar->fp_surat_izin ?? $dataAnakLama->fp_surat_izin,
          'fn_surat_izin' => $data['fn_surat_izin'] ?? $daftar->fn_surat_izin ?? $dataAnakLama->fn_surat_izin,
          'fp_suket_tidak_mampu' => $data['fp_suket_tidak_mampu'] ?? $daftar->fp_suket_tidak_mampu ?? $dataAnakLama->fp_suket_tidak_mampu,
          'fn_suket_tidak_mampu' => $data['fn_suket_tidak_mampu'] ?? $daftar->fn_suket_tidak_mampu ?? $dataAnakLama->fn_suket_tidak_mampu,
          'fp_suket_kematian' => $data['fp_suket_kematian'] ?? $daftar->fp_suket_kematian ?? $dataAnakLama->fp_suket_kematian,
          'fn_suket_kematian' => $data['fn_suket_kematian'] ?? $daftar->fn_suket_kematian ?? $dataAnakLama->fn_suket_kematian,
          'fp_suket_sehat' => $data['fp_suket_sehat'] ?? $daftar->fp_suket_sehat ?? $dataAnakLama->fp_suket_sehat,
          'fn_suket_sehat' => $data['fn_suket_sehat'] ?? $daftar->fn_suket_sehat ?? $dataAnakLama->fn_suket_sehat,
          'fp_ktp' => $data['fp_ktp'] ?? $daftar->fp_ktp ?? $dataAnakLama->fp_ktp,
          'fn_ktp' => $data['fn_ktp'] ?? $daftar->fn_ktp ?? $dataAnakLama->fn_ktp,
          'fp_kk' => $data['fp_kk'] ?? $daftar->fp_kk ?? $dataAnakLama->fp_kk,
          'fn_kk' => $data['fn_kk'] ?? $daftar->fn_kk ?? $dataAnakLama->fn_kk,
          'fp_bpjs' => $data['fp_bpjs'] ?? $daftar->fp_bpjs ?? $dataAnakLama->fp_bpjs,
          'fn_bpjs' => $data['fn_bpjs'] ?? $daftar->fn_bpjs ?? $dataAnakLama->fn_bpjs,
          'fp_akte' => $data['fp_akte'] ?? $daftar->fp_akte ?? $dataAnakLama->fp_akte,
          'fn_akte' => $data['fn_akte'] ?? $daftar->fn_akte ?? $dataAnakLama->fn_akte,
          'fp_foto' => $data['fp_foto'] ?? $daftar->fp_foto ?? $dataAnakLama->fp_foto,
          'fn_foto' => $data['fn_foto'] ?? $daftar->fn_foto ?? $dataAnakLama->fn_foto,
        ]);
        $anakBaru = Anak::find($id);
        if ($anakBaru) {
          Pendaftaran::where('id', $id)->update([
            'biodata' => $anakBaru->biodata,
            'fp_formulir' => $anakBaru->fp_formulir,
            'fn_formulir' => $anakBaru->fn_formulir,
            'fp_surat_izin' => $anakBaru->fp_surat_izin,
            'fn_surat_izin' => $anakBaru->fn_surat_izin,
            'fp_suket_tidak_mampu' => $anakBaru->fp_suket_tidak_mampu,
            'fn_suket_tidak_mampu' => $anakBaru->fn_suket_tidak_mampu,
            'fp_suket_kematian' => $anakBaru->fp_suket_kematian,
            'fn_suket_kematian' => $anakBaru->fn_suket_kematian,
            'fp_suket_sehat' => $anakBaru->fp_suket_sehat,
            'fn_suket_sehat' => $anakBaru->fn_suket_sehat,
            'fp_ktp' => $anakBaru->fp_ktp,
            'fn_ktp' => $anakBaru->fn_ktp,
            'fp_kk' => $anakBaru->fp_kk,
            'fn_kk' => $anakBaru->fn_kk,
            'fp_bpjs' => $anakBaru->fp_bpjs,
            'fn_bpjs' => $anakBaru->fn_bpjs,
            'fp_akte' => $anakBaru->fp_akte,
            'fn_akte' => $anakBaru->fn_akte,
            'fp_foto' => $anakBaru->fp_foto,
            'fn_foto' => $anakBaru->fn_foto,
            'tahap' => '3',
          ]);
        }
        if ($request->hasFile('files')) {
          foreach ($request->file('files') as $index => $file) {
            $fileNameOpt = $request->file_name[$index] ?? null;
            $fileNamePath = time() . '_' . $fileNameOpt . '.' . $file->getClientOriginalExtension();
            $filePathOpt = $file->storeAs('documents/opsional', $fileNamePath, 'private');

            $daftar->files()->create([
              'pendaftaran_id' => $id,
              'file_name' => $fileNameOpt,
              'file_path' => $filePathOpt,
            ]);
          }
        }
        if (Auth::user()->role == 'admin') {
          return back()->with('success', 'Data anak ' . $request->nama .  ' berhasil diperbarui');
        } else {
          return redirect()->route('kondisi-anak')->with('success', 'Data anak ' . $request->nama . ' berhasil diperbarui');
        }
      } else {
        if ($existingData->contains('nik', $request->nik)) {
          return back()->with('error', 'Data anak gagal disimpan: NIK sudah terdaftar');
        }
        $daftarBaru = Pendaftaran::create([
          'id' => Str::uuid(),
          'user_id' => $request->user_id,
          'biodata' => $biodata,
          'status' => 'lulus',
          'keterangan' => '-',
          'tahap' => '3',
        ]);
        if ($daftarBaru) {
          Anak::create([
            'id' => $daftarBaru->id,
            'user_id' => $request->user_id,
            'pendaftarans_id' => $daftarBaru->id,
            'biodata' => $biodata,
            'status' => 'aktif',
            'keterangan' => '-',
          ]);
        }
        return back()->with('success', 'Data anak berhasil disimpan');
      }
    } catch (\Exception $e) {
      return back()->with('error', 'Data anak gagal disimpan: ' . $e->getMessage());
    }
  }

  public function destroy($id)
  {
    $anak = Anak::findOrFail($id);
    $data = $anak->biodata;
    $splitData = explode('~', $data);
    try {
      $anak->delete();
      return back()->with('success', 'Data ' . $splitData[0] . ' berhasil dihapus');
    } catch (\Exception $e) {
      return back()->with('error', 'Data ' . $splitData[0] . ' gagal dihapus: ' . $e->getMessage());
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
        'fp_riwayat' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
      ],
      [
        '*.required' => ':attribute harus diisi.',
        '*.file' => ':attribute harus berupa file yang valid.',
        '*.mimes' => ':attribute harus memiliki ekstensi jpeg, png, pdf atau jpg.',
      ]
    );



    if ($validator->fails()) {
      return back()->with('error', 'Data riwayat gagal disimpan: ' . $validator->errors()->first());
    }
    try {
      $data = $request->all();
      if ($request->hasFile('fp_riwayat')) {
        $file = $request->file('fp_riwayat');
        $originalFileName = $file->getClientOriginalName();
        $fileName = time() . '_' . preg_replace('/\s+/', '_', $originalFileName);
        $filePath = $file->storeAs('riwayat', $fileName, 'private');
        $data['fp_riwayat'] = $filePath;
        $data['fn_riwayat'] = $fileName;
      }
      Riwayat::create($data);
      return back()->with('success', 'Data riwayat berhasil disimpan');
    } catch (\Exception $e) {
      return back()->with('error', 'Data riwayat gagal disimpan: ' . $e->getMessage());
    }
  }
}
