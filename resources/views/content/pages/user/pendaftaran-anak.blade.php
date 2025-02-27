@extends('layouts/contentNavbarLayout')

@section('title', 'Pendaftaran Anak')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                @if ($lulus && !$tahap)
                    <div class="card-body p-7">
                        <div class="divider text-center">
                            <div class="divider-text text-capitalize fs-5 ">
                                <span
                                    class="badge  bg-{{ $lulus->status == 'lulus' ? 'success' : ($lulus->status == 'tidak' ? 'danger' : ($lulus->status == 'pemberitahuan' ? 'warning' : 'primary')) }}">
                                    Anak anda bernama {{ $lulus->biodata->nama }}
                                    {{ $lulus->status == 'tidak' ? 'Tidak Lulus' : 'telah ' . $lulus->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($tahap && $tahap->status != 'tidak')
                    <div class="card-body p-7">
                        <div class="divider text-center">
                            <div class="divider-text text-capitalize fs-5 ">
                                <span
                                    class="badge  bg-{{ $tahap->status == 'lulus' ? 'success' : ($tahap->status == 'tidak' ? 'danger' : ($tahap->status == 'pemberitahuan' ? 'warning' : 'primary')) }}">
                                    Status Tahap
                                    {{ $tahap->status == 'tidak' ? $tahap->tahap . ' ' . 'Tidak Lulus' : $tahap->tahap . ' ' . $tahap->status }}

                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control text-capitalize fs-5" rows="5" placeholder="Keterangan" readonly>{{ $tahap->keterangan ?? '-' }}</textarea>
                            </div>
                        </div>
                        <div class="divider text-start">
                            <div class="divider-text fs-5">Data Pendaftaran Tahap 1</div>
                        </div>
                        <form id="pendaftaranForm"
                            action="{{ isset($tahap->id) ? route('pendaftaran-anak.update', $tahap->id) : route('pendaftaran-anak.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($tahap->id))
                                @method('PUT')
                            @else
                                @method('POST')
                            @endif
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama Anak" value="{{ $tahap->biodata->nama }}"
                                            {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'readonly' : '' }}
                                            required>
                                        <label for="nama">Nama Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="ttl" name="ttl"
                                            placeholder="Tempat, Tanggal Lahir Anak" value="{{ $tahap->biodata->ttl }}"
                                            {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'readonly' : '' }}
                                            required>
                                        <label for="ttl">Tempat, Tanggal Lahir Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control" id="nik" name="nik"
                                            placeholder="NIK Anak" value="{{ $tahap->biodata->nik }}"
                                            {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'readonly' : '' }}
                                            required>
                                        <label for="nik">NIK Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="jk" name="jk" required>
                                            <option value="" disabled {{ !$tahap->biodata->jk ? 'selected' : '' }}>
                                                Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki"
                                                {{ $tahap->biodata->jk == 'Laki-laki' ? 'selected' : '' }}
                                                {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'disabled' : '' }}>
                                                Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ $tahap->biodata->jk == 'Perempuan' ? 'selected' : '' }}
                                                {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'disabled' : '' }}>
                                                Perempuan
                                            </option>
                                        </select>
                                        <label for="jk">Jenis Kelamin Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="pendidikan" name="pendidikan"
                                            placeholder="Pendidikan/ Kelas Anak"
                                            value="{{ $tahap->biodata->pendidikan ?? '' }}" required
                                            {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'readonly' : '' }}>
                                        <label for="pendidikan">Pendidikan/ Kelas Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="status_anak" name="status_anak" required>
                                            <option value="" disabled
                                                {{ !$tahap->biodata->status_anak ? 'selected' : '' }}
                                                {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'disabled' : '' }}>
                                                Pilih Status Anak
                                            </option>
                                            <option value="Anak Yatim"
                                                {{ $tahap->biodata->status_anak == 'Anak Yatim' ? 'selected' : '' }}
                                                {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'disabled' : '' }}>
                                                Anak
                                                Yatim</option>
                                            <option value="Anak Piatu"
                                                {{ $tahap->biodata->status_anak == 'Anak Piatu' ? 'selected' : '' }}
                                                {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'disabled' : '' }}>
                                                Anak
                                                Piatu</option>
                                            <option value="Anak Yatim Piatu"
                                                {{ $tahap->biodata->status_anak == 'Anak Yatim Piatu' ? 'selected' : '' }}
                                                {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'disabled' : '' }}>
                                                Anak Yatim Piatu</option>
                                            <option value="Anak Tidak Mampu"
                                                {{ $tahap->biodata->status_anak == 'Anak Tidak Mampu' ? 'selected' : '' }}
                                                {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'disabled' : '' }}>
                                                Anak Tidak Mampu</option>
                                            <option value="Lainnya"
                                                {{ $tahap->biodata->status_anak == 'Lainnya' ? 'selected' : '' }}
                                                {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'disabled' : '' }}>
                                                Lainnya
                                            </option>
                                        </select>
                                        <label for="status_anak">Status Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="ortu" name="ortu"
                                            {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'readonly' : '' }}
                                            value="{{ $tahap->biodata->ortu }}" placeholder="Nama Orang Tua/ Wali">
                                        <label for="ortu">Nama Orang Tua/ Wali</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                            {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'readonly' : '' }}
                                            placeholder="Pekerjaan Orang Tua/ Wali"
                                            value="{{ $tahap->biodata->pekerjaan }}">
                                        <label for="pekerjaan">Pekerjaan Orang Tua/ Wali</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="alamat">Alamat Anak</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                        {{ $tahap->status != 'pemberitahuan' || $tahap->tahap != '1' ? 'readonly' : '' }} required>{{ $tahap->biodata->alamat }}</textarea>
                                </div>
                                @if ($tahap->status == 'pemberitahuan' && $tahap->tahap == '1')
                                    <div class="col-md-12">
                                        <div class="divider text-start">
                                            <div class="divider-text fs-5">Template Administrasi</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 ">
                                        <div class="btn btn-info w-100"
                                            onclick="window.open('/assets/template/formulir_daftar.pdf', '_blank')">
                                            Contoh Formulir Pendaftaran
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 ">
                                        <div class="btn btn-info w-100"
                                            onclick="window.open('/assets/template/surat_izin.pdf', '_blank')">
                                            Contoh Surat Izin Ortu
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="divider text-start">
                                            <div class="divider-text fs-5">Bagian Upload Administrasi</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*" name="fp_formulir"
                                                id="fp_formulir" class="form-control">
                                            <label for="fp_formulir">Formulir Pendaftaran</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*" name="fp_surat_izin"
                                                id="fp_surat_izin" class="form-control">
                                            <label for="fp_surat_izin">Surat Izin</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*"
                                                name="fp_suket_tidak_mampu" id="fp_suket_tidak_mampu"
                                                class="form-control">
                                            <label for="fp_suket_tidak_mampu">Surat Keterangan Tidak Mampu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*"
                                                name="fp_suket_kematian" id="fp_suket_kematian" class="form-control">
                                            <label for="fp_suket_kematian">Surat Keterangan Kematian</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*" name="fp_suket_sehat"
                                                id="fp_suket_sehat" class="form-control">
                                            <label for="fp_suket_sehat">Surat Keterangan Sehat</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*" name="fp_ktp"
                                                id="fp_ktp" class="form-control">
                                            <label for="fp_ktp">KTP</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*" name="fp_kk"
                                                id="fp_kk" class="form-control">
                                            <label for="fp_kk">KK</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*" name="fp_bpjs"
                                                id="fp_bpjs" class="form-control">
                                            <label for="fp_bpjs">BPJS</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*" name="fp_akte"
                                                id="fp_akte" class="form-control">
                                            <label for="fp_akte">Akte Kelahiran Anak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5 mt-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" accept="application/pdf, image/*" name="fp_foto"
                                                id="fp_foto" class="form-control">
                                            <label for="fp_foto">Pas Foto Anak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="divider text-start">
                                            <div class="divider-text fs-5">Bagian Hasil Upload Administrasi</div>
                                        </div>
                                    </div>
                                    @if ($tahap->fp_formulir != null)
                                        <div class="col-md-6 mb-5">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_formulir }}', '_blank')">
                                                Formulir Pendaftaran
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_surat_izin != null)
                                        <div class="col-md-6 mb-5">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_surat_izin }}', '_blank')">
                                                Surat
                                                Izin
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_suket_tidak_mampu != null)
                                        <div class="col-md-6 mb-5">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_suket_tidak_mampu }}', '_blank')">
                                                Surat
                                                Keterangan Tidak Mampu
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_suket_kematian != null)
                                        <div class="col-md-6 mb-5 ">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_suket_kematian }}', '_blank')">
                                                Surat
                                                Keterangan Kematian
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_suket_sehat != null)
                                        <div class="col-md-6 mb-5 ">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_suket_sehat }}', '_blank')">
                                                Surat
                                                Keterangan Sehat
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_ktp != null)
                                        <div class="col-md-6 mb-5 ">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_ktp }}', '_blank')">
                                                KTP
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_kk != null)
                                        <div class="col-md-6 mb-5">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_kk }}', '_blank')">
                                                KK
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_bpjs != null)
                                        <div class="col-md-6 mb-5 ">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_bpjs }}', '_blank')">
                                                BPJS
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_akte != null)
                                        <div class="col-md-6 mb-5 ">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_akte }}', '_blank')">
                                                Akte Kelahiran
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tahap->fp_foto != null)
                                        <div class="col-md-6 mb-5 ">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $tahap->fp_foto }}', '_blank')">
                                                Pas Foto
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <div class="divider text-start">
                                            <div class="divider-text fs-5">
                                                Dokumen Lainnya
                                                <span class="text-muted fs-6">(Bagian ini tidak wajib, isi jika
                                                    diperlukan)</span>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($tahap->files as $optionalFile)
                                        <div class="col-md-6 mb-5 ">
                                            <div class="btn btn-info w-100"
                                                onclick="window.open('/storage/{{ $optionalFile->file_path }}', '_blank')">
                                                {{ $optionalFile->file_name }}
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="file-container">
                                        <div class="file-item">
                                            <div class="row">
                                                <div class="col-md-6 mb-5 mt-2">
                                                    <input type="text" name="file_name[]" class="form-control"
                                                        placeholder="Nama Dokumen lain (tidak wajib)" />
                                                </div>
                                                <div class="col-md-6 mb-5 mt-2">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="file" name="files[]"
                                                            accept="application/pdf, image/*" class="form-control" />
                                                        <label for="files[]">Upload File</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="add-file" class="btn btn-secondary p-3 mt-3">Tambah
                                        File</button>
                                    <div class="col-md-12 mb-3">
                                        <span class="text-danger">* Format dokumen harus .jpg, .jpeg, .png, .pdf dan
                                            maksimal
                                            2MB</span>
                                    </div>
                                @endif
                            </div>
                            @if ($tahap->status == 'pemberitahuan' && $tahap->tahap == '1')
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button type="button" id="saveTemporary" class="btn btn-info me-5">Simpan
                                            Sementara</button>
                                        <button type="submit" id="sendData" class="btn btn-primary">Kirim</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @else
                    <div class="card-body p-7">
                        @if ($tahap && $tahap->status == 'tidak')
                            <div class="divider text-center">
                                <div class="divider-text text-capitalize fs-5 ">
                                    <span class="badge bg-danger text-wrap">
                                        Anak anda bernama {{ $tahap->biodata->nama }}
                                        {{ 'Tidak Lulus Pada Tahap ' . $tahap->tahap . ' ' }}
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control text-capitalize fs-5" rows="5" placeholder="Keterangan" readonly>{{ $tahap->keterangan ?? '-' }}</textarea>
                                </div>
                            </div>
                        @endif
                        <div class="divider text-start">
                            <div class="divider-text fs-5">Form Pendaftaran Masuk</div>
                        </div>
                        <form id="pendaftaranForm" action="{{ route('pendaftaran-anak.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama Anak" required>
                                        <label for="nama">Nama Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="ttl" name="ttl"
                                            placeholder="Tempat, Tanggal Lahir Anak" required>
                                        <label for="ttl">Tempat, Tanggal Lahir Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control" id="nik" name="nik"
                                            placeholder="NIK Anak" required>
                                        <label for="nik">NIK Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="jk" name="jk" required>
                                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        <label for="jk">Jenis Kelamin Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="pendidikan" name="pendidikan"
                                            required placeholder="Pendidikan/ Kelas Anak">
                                        <label for="pendidikan">Pendidikan/ Kelas Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="status_anak" name="status_anak" required>
                                            <option value="" disabled selected>Pilih Status Anak</option>
                                            <option value="Anak Yatim">Anak Yatim</option>
                                            <option value="Anak Piatu">Anak Piatu</option>
                                            <option value="Anak Yatim Piatu">Anak Yatim Piatu</option>
                                            <option value="Anak Tidak Mampu">Anak Tidak Mampu</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        <label for="status_anak">Status Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="ortu" name="ortu"
                                            readonly value="{{ auth()->user()->nama_lengkap }}"
                                            placeholder="Nama Orang Tua/ Wali">
                                        <label for="ortu">Nama Orang Tua/ Wali</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                            placeholder="Pekerjaan Orang Tua/ Wali">
                                        <label for="pekerjaan">Pekerjaan Orang Tua/ Wali</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="alamat">Alamat Anak</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="divider text-start">
                                        <div class="divider-text fs-5">Template Administrasi</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 ">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/assets/template/formulir_daftar.pdf', '_blank')">
                                        Contoh Formulir Pendaftaran
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 ">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/assets/template/surat_izin.pdf', '_blank')">
                                        Contoh Surat Izin Ortu
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="divider text-start">
                                        <div class="divider-text fs-5">Bagian Administrasi</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*" name="fp_formulir"
                                            id="fp_formulir" class="form-control" required>
                                        <label for="fp_formulir">Formulir Pendaftaran</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*" name="fp_surat_izin"
                                            id="fp_surat_izin" class="form-control" required>
                                        <label for="fp_surat_izin">Surat Izin Ortu</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*"
                                            name="fp_suket_tidak_mampu" id="fp_suket_tidak_mampu" class="form-control">
                                        <label for="fp_suket_tidak_mampu">Surat Keterangan Tidak Mampu</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*" name="fp_suket_kematian"
                                            id="fp_suket_kematian" class="form-control">
                                        <label for="fp_suket_kematian">Surat Keterangan Kematian</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*" name="fp_suket_sehat"
                                            id="fp_suket_sehat" class="form-control">
                                        <label for="fp_suket_sehat">Surat Keterangan Sehat</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*" name="fp_ktp"
                                            id="fp_ktp" class="form-control" required>
                                        <label for="fp_ktp">KTP</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*" name="fp_kk"
                                            id="fp_kk" class="form-control" required>
                                        <label for="fp_kk">KK</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*" name="fp_bpjs"
                                            id="fp_bpjs" class="form-control">
                                        <label for="fp_bpjs">BPJS</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="application/pdf, image/*" name="fp_akte"
                                            id="fp_akte" class="form-control" required>
                                        <label for="fp_akte">Akte Kelahiran Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" accept="image/*" name="fp_foto" id="fp_foto"
                                            class="form-control" required>
                                        <label for="fp_foto">Pas Foto Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="divider text-start">
                                        <div class="divider-text fs-5">
                                            Dokumen Lainnya
                                            <span class="text-muted fs-6">(Bagian ini tidak wajib, isi jika
                                                diperlukan)</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="file-container">
                                    <div class="file-item">
                                        <div class="row">
                                            <div class="col-md-6 mb-5 mt-2">
                                                <input type="text" name="file_name[]" class="form-control"
                                                    placeholder="Nama Dokumen lain (tidak wajib)" />
                                            </div>
                                            <div class="col-md-6 mb-5 mt-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="file" name="files[]"
                                                        accept="application/pdf, image/*" class="form-control" />
                                                    <label for="files[]">Upload File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-file" class="btn btn-secondary p-3 mt-3">Tambah
                                    File</button>
                                <div class="col-md-12 mb-3">
                                    <span class="text-danger">* Format dokumen harus .jpg, .jpeg, .png, .pdf dan maksimal
                                        2MB</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="button" id="saveTemporary" class="btn btn-info me-5">Simpan
                                        Sementara</button>
                                    <button type="submit" id="sendData" class="btn btn-success">Kirim</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            if (document.getElementById('add-file')) {

                document.getElementById('add-file').addEventListener('click', function() {
                    const container = document.getElementById('file-container');
                    const newItem = document.createElement('div');
                    newItem.className = 'file-item mt-3';
                    newItem.innerHTML = `
            <div class="row">
<div class="col-md-6 mb-5 mt-2">
<input type="text" name="file_name[]" class="form-control" placeholder="Nama Dokumen lain (tidak wajib)" />
</div>
<div class="col-md-6 mb-5 mt-2">
<div class="form-floating form-floating-outline">
<input type="file" name="files[]" accept="application/pdf, image/*" class="form-control" />
<label for="files[]">Upload File</label>
</div>
</div>
</div>
        `;
                    container.appendChild(newItem);
                });
            }

            const form = document.getElementById("pendaftaranForm");
            const saveButton = document.getElementById("saveTemporary");
            const sendData = document.getElementById("sendData");

            if (saveButton) {
                sendData.addEventListener("click", function() {
                    localStorage.removeItem("pendaftaranAnak");
                })

                saveButton.addEventListener("click", function() {
                    const formData = new FormData(form);
                    let tempData = {};

                    formData.forEach((value, key) => {
                        tempData[key] = value;
                    });

                    localStorage.setItem("pendaftaranAnak", JSON.stringify(tempData));
                    alert("Data berhasil disimpan sementara.");
                });

            }
            const savedData = localStorage.getItem("pendaftaranAnak");
            if (savedData) {
                const tempData = JSON.parse(savedData);

                Object.keys(tempData).forEach((key) => {
                    const input = document.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.type === "file") return;
                        if (input.tagName === "TEXTAREA" || input.tagName === "INPUT") {
                            input.value = tempData[key];
                        } else if (input.tagName === "SELECT") {
                            input.value = tempData[key];
                            input.dispatchEvent(new Event("change"));
                        }
                    }
                });
            }
        });
    </script>
@endsection
