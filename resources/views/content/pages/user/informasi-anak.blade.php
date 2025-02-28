@extends('layouts/contentNavbarLayout')

@section('title', 'Kondisi Anak')

@section('content')
    <div class="row gy-6 mb-5">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('informasi-anak.get') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="anak" class="form-label">Pilih Anak Anda</label>
                            <select class="form-select" id="anak" name="id" onchange="this.form.submit()">
                                <option selected disabled value="">Pilih Anak</option>
                                @foreach ($anak as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $info && $info->id === $item->id ? 'selected' : '' }}>
                                        {{ $item->biodata->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col md-12 sm-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5>Informasi Data Anak</h5>
                    <form id="pendaftaranForm" action="{{ route('data-anak.update', $info->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $info->id }}">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Nama Anak" value="{{ $info->nama }}" required>
                                    <label for="nama">Nama Anak</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="ttl" name="ttl"
                                        placeholder="Tempat, Tanggal Lahir Anak" value="{{ $info->ttl }}" required>
                                    <label for="ttl">Tempat, Tanggal Lahir Anak</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="nik" name="nik"
                                        placeholder="NIK Anak" value="{{ $info->nik }}" readonly>
                                    <label for="nik">NIK Anak</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select" id="jk" name="jk" required>
                                        <option value="" {{ !$info->jk ? 'selected' : '' }}>
                                            Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ $info->jk == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ $info->jk == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                    <label for="jk">Jenis Kelamin Anak</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="pendidikan" name="pendidikan"
                                        placeholder="Pendidikan/ Kelas Anak" value="{{ $info->pendidikan ?? '' }}"
                                        required>
                                    <label for="pendidikan">Pendidikan/ Kelas Anak</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select" id="status_anak" name="status_anak" required>
                                        <option value="" disabled {{ $info->status_anak ? 'selected' : '' }}>
                                            Pilih Status Anak
                                        </option>
                                        <option value="Anak Yatim"
                                            {{ $info->status_anak == 'Anak Yatim' ? 'selected' : '' }}>
                                            Anak
                                            Yatim</option>
                                        <option value="Anak Piatu"
                                            {{ $info->status_anak == 'Anak Piatu' ? 'selected' : '' }}>
                                            Anak
                                            Piatu</option>
                                        <option value="Anak Yatim Piatu"
                                            {{ $info->status_anak == 'Anak Yatim Piatu' ? 'selected' : '' }}>
                                            Anak Yatim Piatu</option>
                                        <option value="Anak Tidak Mampu"
                                            {{ $info->status_anak == 'Anak Tidak Mampu' ? 'selected' : '' }}>
                                            Anak Tidak Mampu</option>
                                        <option value="Lainnya" {{ $info->status_anak == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya
                                        </option>
                                    </select>
                                    <label for="status_anak">Status Anak</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="ortu" name="ortu"
                                        value="{{ $info->ortu }}" placeholder="Nama Orang Tua/ Wali">
                                    <label for="ortu">Nama Orang Tua/ Wali</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="no_tel" name="no_tel"
                                        value="{{ $info->no_tel }}" placeholder="Nama Orang Tua/ Wali">
                                    <label for="no_tel">Nomor Telepon</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                        placeholder="Pekerjaan Orang Tua/ Wali" value="{{ $info->pekerjaan }}">
                                    <label for="pekerjaan">Pekerjaan Orang Tua/ Wali</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                              <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control text-capitalize text-white @if($info->status == 'aktif') bg-success @elseif($info->status == 'alumni lulus') bg-info @else bg-danger @endif" id="status" name="status" value="{{ $info->status }}" placeholder="Status Keaktifan" readonly>
                                  <label for="status">Status Keaktifan</label>
                              </div>
                          </div>
                            <div class="col-md-12 mb-3">
                                <label for="alamat">Alamat Anak</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $info->alamat }}</textarea>
                            </div>
                            @if ($info->fp_formulir != null || $info->fp_izin != null)
                                <div class="col-md-12">
                                    <div class="divider text-start">
                                        <div class="divider-text fs-5">Bagian Administrasi</div>
                                    </div>
                                </div>
                            @else
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
                              @endif
                              @if($info->status == 'aktif')
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
                                        <input type="file" accept="application/pdf, image/*" name="fp_suket_tidak_mampu"
                                            id="fp_suket_tidak_mampu" class="form-control">
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
                                        <input type="file" accept="image/*" name="fp_foto" id="fp_foto"
                                            class="form-control">
                                        <label for="fp_foto">Pas Foto Anak</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="divider text-start">
                                        <div class="divider-text fs-5">Bagian Hasil Upload Administrasi</div>
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_formulir != null)
                                <div class="col-md-6 mb-5">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_formulir }}', '_blank')">
                                        Formulir Pendaftaran
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_surat_izin != null)
                                <div class="col-md-6 mb-5">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_surat_izin }}', '_blank')">
                                        Surat
                                        Izin
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_suket_tidak_mampu != null)
                                <div class="col-md-6 mb-5">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_suket_tidak_mampu }}', '_blank')">
                                        Surat
                                        Keterangan Tidak Mampu
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_suket_kematian != null)
                                <div class="col-md-6 mb-5 ">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_suket_kematian }}', '_blank')">
                                        Surat
                                        Keterangan Kematian
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_suket_sehat != null)
                                <div class="col-md-6 mb-5 ">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_suket_sehat }}', '_blank')">
                                        Surat
                                        Keterangan Sehat
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_ktp != null)
                                <div class="col-md-6 mb-5 ">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_ktp }}', '_blank')">
                                        KTP
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_kk != null)
                                <div class="col-md-6 mb-5">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_kk }}', '_blank')">
                                        KK
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_bpjs != null)
                                <div class="col-md-6 mb-5 ">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_bpjs }}', '_blank')">
                                        BPJS
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_akte != null)
                                <div class="col-md-6 mb-5 ">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_akte }}', '_blank')">
                                        Akte Kelahiran
                                    </div>
                                </div>
                            @endif
                            @if ($info->fp_foto != null)
                                <div class="col-md-6 mb-5 ">
                                    <div class="btn btn-info w-100"
                                        onclick="window.open('/storage/{{ $info->fp_foto }}', '_blank')">
                                        Pas Foto
                                    </div>
                                </div>
                            @endif
                            @if($info->status == 'aktif')
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
                                                  <input type="file" name="files[]" accept="application/pdf, image/*"
                                                      class="form-control" />
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
                        @if($info->status != 'alumni keluar')
                          <div class="row">
                              <div class="col-md-12 text-end">
                                  <button type="reset" class="btn btn-danger me-5">Batal</button>
                                  <button type="submit" id="sendData" class="btn btn-primary">Perbarui Data</button>
                              </div>
                          </div>
                        @endif
                    </form>
                    <div class="row">
                      @if($filesAnak->pendaftaran->files->count() > 0)
                        <div class="col-md-12">
                            <div class="divider text-start">
                                <div class="divider-text fs-5">Bagian Dokumen Lainnya</div>
                            </div>
                        </div>
                        @foreach ($filesAnak->pendaftaran->files as $optionalFile)
                            <div class="col-md-6 mb-5">
                                <div class="btn-group w-100">
                                    <a href="{{ asset('storage/' . $optionalFile->file_path) }}" target="_blank"
                                        class="btn btn-info">
                                        {{ $optionalFile->file_name }}
                                    </a>
                                    @if($info->status != 'alumni keluar')
                                    <form action="{{ route('delete-file-info', $optionalFile->id) }}" method="POST"
                                        class="btn-group"
                                        onsubmit="return confirm('Yakin ingin menghapus file {{ $optionalFile->file_name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="ri-delete-bin-line me-2"></i>Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
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
    </script>
@endsection
