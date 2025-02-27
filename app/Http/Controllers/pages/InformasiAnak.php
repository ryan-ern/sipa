<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pendaftaran;
use App\Models\PendaftaranFile;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InformasiAnak extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();
    if (!Anak::where('user_id', $user->id)->exists()) {
      return redirect('/pages/pendaftaran-anak')->with('info', 'Silahkan daftarkan anak anda terlebih dahulu');
    }
    $selectedId = $request->id;

    $anak = Anak::where('user_id', Auth::user()->id)->get();

    $info = $selectedId
      ? Anak::where('user_id', Auth::user()->id)->where('id', $selectedId)->first()
      : Anak::where('user_id', Auth::user()->id)->first();

    $data = Riwayat::select('riwayats.*', 'anaks.biodata')
      ->join('anaks', 'riwayats.anaks_id', '=', 'anaks.id')
      ->orderBy('riwayats.updated_at', 'DESC')
      ->where('anaks.id', $selectedId ?? $info->id)
      ->get();

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

    return view('content.pages.user.informasi-anak', [
      'data' => $processData($data),
      'riwayat' => $riwayat ?? null,
      'anak' => $processData($anak),
      'filesAnak' => $info,
      'info' => $infoData ?? null,
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
          return redirect()->route('informasi-anak')->with('success', 'Data anak ' . $request->nama . ' berhasil diperbarui');
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
    $file = PendaftaranFile::where('id', $id)->first();
    $file->delete();
    return redirect()->route('informasi-anak')->with('success', 'Berhasil hapus File ' . $file->name);
  }
}
