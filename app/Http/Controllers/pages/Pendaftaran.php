<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pendaftaran as ModelsPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Pendaftaran extends Controller
{
  public function index()
  {
    $data = ModelsPendaftaran::select('*')->orderBy('updated_at', 'DESC')->get();
    $tahap1 = ModelsPendaftaran::select('*')->where('tahap', 1)->orderBy('updated_at', 'ASC')->get();
    $tahap2 = ModelsPendaftaran::select('*')->where('tahap', 2)->orderBy('updated_at', 'ASC')->get();
    $tahap3 = ModelsPendaftaran::select('*')->where('tahap', 3)
      ->orderByRaw("CASE WHEN status = 'lulus' THEN 1 ELSE 0 END, updated_at ASC")->get();

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

    return view('content.pages.data-pendaftaran', [
      'data' => $data,
      'tahap1' => $processData($tahap1),
      'tahap2' => $processData($tahap2),
      'tahap3' => $processData($tahap3),
    ]);
  }


  public function indexUser()
  {
    $data = ModelsPendaftaran::select('*')->where('user_id', Auth::user()->id)->get();
    $tahap = ModelsPendaftaran::select('*')->where('status', '!=', 'lulus')->where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->first();
    $lulus = ModelsPendaftaran::select('*')->where('status', 'lulus')->where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->first();
    $processData = function ($item) {
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
    };
    if ($tahap != null) {
      return view('content.pages.user.pendaftaran-anak', [
        'data' => $data,
        'tahap' => $processData($tahap),
        'lulus' => $lulus != null ? $processData($lulus) : null
      ]);
    }
    return view('content.pages.user.pendaftaran-anak', [
      'data' => $data,
      'tahap' => null,
      'lulus' => $lulus != null ? $processData($lulus) : null
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
        'tahap' => ['nullable', 'string'],
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
        'files.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        'file_name.*' => ['nullable', 'string', 'max:255'],
      ], [
        '*.required' => ':attribute harus diisi.',
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
      'fn_formulir',
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
        $file = $request->file($fileKey);
        $originalFileName = $file->getClientOriginalName();
        $fileName = str_replace('fn_', '', $fileNames[array_search($fileKey, $files)]) . '_' . $request->nik . '_' . preg_replace('/\s+/', '_', $originalFileName);
        $filePath = $file->storeAs('documents/' . str_replace('fp_', '', $fileKey), $fileName, 'private');
        $data[$fileKey] = $filePath;
        $data[$fileNames[array_search($fileKey, $files)]] = $fileName;
      }
    }

    $existingData = ModelsPendaftaran::all()->map(function ($item) {
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
    $existingAnak = Anak::all()->map(function ($item) {
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
      $request->no_tel ?? Auth::user()->no_tel,
    ]);

    try {
      $data['user_id'] = $request->user_id ?? Auth::id();
      $data['biodata'] = $biodata;
      $data['status'] = $request->status ?? 'berlangsung';
      $data['tahap'] = $request->tahap ?? '1';
      $data['keterangan'] = $request->keterangan ?? 'pendaftaran anda sudah masuk dalam antrian, silahkan menunggu info selanjutnya';

      if ($id) {
        if ($request->tahap == '3' && $request->status == 'lulus' && !$existingAnak->contains('nik', $request->nik)) {
          $pendaftaran = ModelsPendaftaran::find($id);
          if ($pendaftaran) {
            $daftar = ModelsPendaftaran::where('id', $id)->update($data);
            $data = $pendaftaran->toArray();
            $data['status'] = 'aktif';
            $data['keterangan'] = '-';
            $data['pendaftarans_id'] = $request->pendaftarans_id;
            Anak::create($data);
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
          } else {
            return back()->with('error', 'Pendaftaran anak gagal ditemukan');
          }
        } else {
          ModelsPendaftaran::where('id', $id)->update($data);
          $daftar = ModelsPendaftaran::find($id);
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
        }
        if ($request->status == 'berlangsung') {
          return back()->with('success', 'Pendaftaran anak ' . $request->nama .  ' berhasil lulus dan lanjut tahap ' . $request->tahap);
        } else if ($request->status == 'pemberitahuan') {
          return back()->with('info', 'Pendaftaran anak ' . $request->nama .  ' dalam pemberitahuan di tahap ' . $request->tahap);
        } else if ($request->status == 'tidak') {
          return back()->with('error', 'Pendaftaran anak ' . $request->nama .  ' tidak lulus di tahap ' . $request->tahap);
        } else {
          return back()->with('success', 'Pendaftaran anak ' . $request->nama .  ' berhasil disimpan dan telah lulus di tahap 3');
        }
      } else {
        if ($existingData->contains('nik', $request->nik)) {
          return back()->with('error', 'Pendaftaran anak gagal disimpan: NIK sudah terdaftar');
        }
        $daftar = ModelsPendaftaran::create($data);
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
        return back()->with('success', 'Pendaftaran anak berhasil disimpan');
      }
    } catch (\Exception $e) {
      return back()->with('error', 'Pendaftaran anak gagal disimpan: ' . $e->getMessage());
    }
  }

  public function destroy($id)
  {
    $pendaftaran = ModelsPendaftaran::findOrFail($id);
    try {
      $pendaftaran->delete();
      return back()->with('success', 'Pendaftaran anak ' . $pendaftaran->nama . ' berhasil dihapus');
    } catch (\Exception $e) {
      return back()->with('error', 'Pendaftaran anak ' . $pendaftaran->nama . ' gagal dihapus: ' . $e->getMessage());
    }
  }
}
