@extends('layouts/contentNavbarLayout')

@section('title', 'Data Anak')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body p-7">
                    <button class="btn btn-primary float-end me-3 mt-3" data-bs-toggle="modal" data-bs-target="#dynamicModal"
                        data-modal-type="tambah">
                        Tambah Data
                    </button>
                    <div class="divider text-start">
                        <div class="divider-text ms-3 fs-5">Data Anak</div>
                    </div>
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="tahapTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="default-tab" data-bs-toggle="tab" data-bs-target="#default"
                                type="button" role="tab" aria-controls="default" aria-selected="true">Default</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#aktif"
                                type="button" role="tab" aria-controls="aktif" aria-selected="true">Aktif</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="alumni-tab" data-bs-toggle="tab" data-bs-target="#alumni"
                                type="button" role="tab" aria-controls="alumni" aria-selected="false">Alumni
                                Lulus</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="alumniBermasalah-tab" data-bs-toggle="tab"
                                data-bs-target="#alumniBermasalah" type="button" role="tab"
                                aria-controls="alumniBermasalah" aria-selected="false">Alumni Keluar</button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content mt-4" id="tahapTabsContent">
                        <!-- Tab Default -->
                        <div class="tab-pane fade show active" id="default" role="tabpanel" aria-labelledby="default-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>TTL</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th>Pendidikan</th>
                                            <th>Alamat Asal</th>
                                            <th>Nama Ortu</th>
                                            <th>Pekerjaan</th>
                                            <th>No. Telp</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $dataAnak)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dataAnak->biodata->nama }}</td>
                                                <td class="truncate">
                                                    {{ $dataAnak->biodata->nik }}
                                                </td>
                                                <td class="truncate">
                                                    {{ $dataAnak->biodata->ttl }}
                                                </td>
                                                <td>{{ $dataAnak->biodata->jk }}</td>
                                                <td>{{ $dataAnak->biodata->status_anak }}</td>
                                                <td>{{ $dataAnak->biodata->pendidikan }}</td>
                                                <td class="truncate">{{ $dataAnak->biodata->alamat }}</td>
                                                <td>{{ $dataAnak->biodata->ortu }}</td>
                                                <td>{{ $dataAnak->biodata->pekerjaan }}</td>
                                                <td class="text-capitalize">
                                                    <a class="text-primary"
                                                        href="https://wa.me/{{ $dataAnak->biodata->no_tel }}"
                                                        target="_blank">
                                                        {{ $dataAnak->biodata->no_tel }}
                                                    </a>
                                                </td>

                                                <td class="text-capitalize">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $dataAnak->status == 'aktif' ? 'success' : ($dataAnak->status == 'alumni lulus' ? 'primary' : 'danger') }}">
                                                        {{ $dataAnak->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-primary p-2 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-pencil-fill"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                @if ($dataAnak->status == 'aktif')
                                                                    <li>
                                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                                            data-bs-target="#dynamicModal"
                                                                            data-modal-type="riwayat"
                                                                            data-nama="{{ $dataAnak->biodata->nama }}"
                                                                            data-userid="{{ $dataAnak->user_id }}"
                                                                            data-id="{{ $dataAnak->id }}"
                                                                            data-no_tel="{{ $dataAnak->biodata->no_tel }}">
                                                                            <i class="ri-pulse-line me-2"></i>Keadaan
                                                                            Anak
                                                                        </button>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('data-anak.status', $dataAnak->id) }}"
                                                                            method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="user_id"
                                                                                value="{{ $dataAnak->user_id }}">
                                                                            <input type="hidden" name="nama"
                                                                                value="{{ $dataAnak->biodata->nama }}">
                                                                            <input type="hidden" name="jk"
                                                                                value="{{ $dataAnak->biodata->jk }}">
                                                                            <input type="hidden" name="status_anak"
                                                                                value="{{ $dataAnak->biodata->status_anak }}">
                                                                            <input type="hidden" name="pendidikan"
                                                                                value="{{ $dataAnak->biodata->pendidikan }}">
                                                                            <input type="hidden" name="ttl"
                                                                                value="{{ $dataAnak->biodata->ttl }}">
                                                                            <input type="hidden" name="ortu"
                                                                                value="{{ $dataAnak->biodata->ortu }}">
                                                                            <input type="hidden" name="pekerjaan"
                                                                                value="{{ $dataAnak->biodata->pekerjaan }}">
                                                                            <input type="hidden" name="no_tel"
                                                                                value="{{ $dataAnak->biodata->no_tel }}">
                                                                            <input type="hidden" name="alamat"
                                                                                value="{{ $dataAnak->biodata->alamat }}">
                                                                            <input type="hidden" name="nik"
                                                                                value="{{ $dataAnak->biodata->nik }}">
                                                                            <input type="hidden" name="status"
                                                                                value="aktif">
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="ri-check-line me-2"></i>Anak
                                                                                Aktif
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <form
                                                                        action="{{ route('data-anak.status', $dataAnak->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ $dataAnak->user_id }}">
                                                                        <input type="hidden" name="nama"
                                                                            value="{{ $dataAnak->biodata->nama }}">
                                                                        <input type="hidden" name="jk"
                                                                            value="{{ $dataAnak->biodata->jk }}">
                                                                        <input type="hidden" name="status_anak"
                                                                            value="{{ $dataAnak->biodata->status_anak }}">
                                                                        <input type="hidden" name="pendidikan"
                                                                            value="{{ $dataAnak->biodata->pendidikan }}">
                                                                        <input type="hidden" name="ttl"
                                                                            value="{{ $dataAnak->biodata->ttl }}">
                                                                        <input type="hidden" name="ortu"
                                                                            value="{{ $dataAnak->biodata->ortu }}">
                                                                        <input type="hidden" name="pekerjaan"
                                                                            value="{{ $dataAnak->biodata->pekerjaan }}">
                                                                        <input type="hidden" name="no_tel"
                                                                            value="{{ $dataAnak->biodata->no_tel }}">
                                                                        <input type="hidden" name="alamat"
                                                                            value="{{ $dataAnak->biodata->alamat }}">
                                                                        <input type="hidden" name="nik"
                                                                            value="{{ $dataAnak->biodata->nik }}">
                                                                        <input type="hidden" name="status"
                                                                            value="alumni lulus">
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-check-line me-2"></i>Alumni Lulus
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#dynamicModal"
                                                                        data-modal-type="edit"
                                                                        data-userid="{{ $dataAnak->user_id }}"
                                                                        data-id="{{ $dataAnak->id }}"
                                                                        data-nama="{{ $dataAnak->biodata->nama }}"
                                                                        data-jenis_kelamin="{{ $dataAnak->biodata->jk }}"
                                                                        data-status_anak="{{ $dataAnak->biodata->status_anak }}"
                                                                        data-pendidikan="{{ $dataAnak->biodata->pendidikan }}"
                                                                        data-ttl="{{ $dataAnak->biodata->ttl }}"
                                                                        data-ortu="{{ $dataAnak->biodata->ortu }}"
                                                                        data-pekerjaan="{{ $dataAnak->biodata->pekerjaan }}"
                                                                        data-no_tel="{{ $dataAnak->biodata->no_tel }}"
                                                                        data-alamat="{{ $dataAnak->biodata->alamat }}"
                                                                        data-nik="{{ $dataAnak->biodata->nik }}"
                                                                        data-status="alumni bermasalah">
                                                                        <i class="ri-edit-line me-1"></i> Alumni Bermasalah
                                                                    </button>
                                                                </li>
                                                              <li>
                                                                    <a class="dropdown-item text-primary" href="{{route('data-anak.detail', $dataAnak->id)}}">
                                                                        <i class="ri-edit-box-line me-1"></i> Edit Data Anak
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <div class="dropdown-divider"></div>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item text-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#dynamicModal"
                                                                        data-id="{{ $dataAnak->id }}"
                                                                        data-nama="{{ $dataAnak->biodata->nama }}"
                                                                        data-modal-type="hapus">
                                                                        <i class="ri-delete-bin-line me-1"></i> Hapus Data
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <button type="button" class="btn btn-primary p-2"
                                                            data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                            data-id="{{ $dataAnak->id }}"
                                                            data-nik="{{ $dataAnak->biodata->nik }}"
                                                            data-nama="{{ $dataAnak->biodata->nama }}"
                                                            data-jenis_kelamin="{{ $dataAnak->biodata->jk }}"
                                                            data-ttl="{{ $dataAnak->biodata->ttl }}"
                                                            data-pendidikan="{{ $dataAnak->biodata->pendidikan }}"
                                                            data-alamat="{{ $dataAnak->biodata->alamat }}"
                                                            data-pekerjaan="{{ $dataAnak->biodata->pekerjaan }}"
                                                            data-no_tel="{{ $dataAnak->biodata->no_tel }}"
                                                            data-status_anak="{{ $dataAnak->biodata->status_anak }}"
                                                            data-orang_tua="{{ $dataAnak->biodata->ortu }}"
                                                            data-tahap="{{ $dataAnak->tahap }}"
                                                            data-status="{{ $dataAnak->status }}"
                                                            data-fp_formulir="{{ $dataAnak->fp_formulir }}"
                                                            data-fp_surat_izin="{{ $dataAnak->fp_surat_izin }}"
                                                            data-fp_ktp="{{ $dataAnak->fp_ktp }}"
                                                            data-fp_kk="{{ $dataAnak->fp_kk }}"
                                                            data-fp_suket_tidak_mampu="{{ $dataAnak->fp_suket_tidak_mampu }}"
                                                            data-fp_suket_kematian="{{ $dataAnak->fp_suket_kematian }}"
                                                            data-fp_suket_sehat="{{ $dataAnak->fp_suket_sehat }}"
                                                            data-fp_bpjs="{{ $dataAnak->fp_bpjs }}"
                                                            data-fp_akte="{{ $dataAnak->fp_akte }}"
                                                            data-fp_foto="{{ $dataAnak->fp_foto }}"
                                                            @if (!empty($dataAnak->pendaftaran->files)) @foreach ($dataAnak->pendaftaran->files as $fileName => $filePath)
                                                        data-file-{{ $fileName }}="{{ $filePath->file_path }}"
                                                        data-fn{{ $fileName }}="{{ $filePath->file_name }}"
                                                    @endforeach @endif>
                                                            <i class="ri-search-eye-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Tab Aktif -->
                        <div class="tab-pane fade show" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>TTL</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th>Pendidikan</th>
                                            <th>Alamat Asal</th>
                                            <th>Nama Ortu</th>
                                            <th>Pekerjaan</th>
                                            <th>No. Telp</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aktif as $dataAnak)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dataAnak->biodata->nama }}</td>
                                                <td class="truncate">{{ $dataAnak->biodata->nik }}</td>
                                                <td class="truncate">{{ $dataAnak->biodata->ttl }}</td>
                                                <td>{{ $dataAnak->biodata->jk }}</td>
                                                <td>{{ $dataAnak->biodata->status_anak }}</td>
                                                <td>{{ $dataAnak->biodata->pendidikan }}</td>
                                                <td class="truncate">{{ $dataAnak->biodata->alamat }}</td>
                                                <td>{{ $dataAnak->biodata->ortu }}</td>
                                                <td>{{ $dataAnak->biodata->pekerjaan }}</td>
                                                <td class="text-capitalize">
                                                    <a class="text-primary"
                                                        href="https://wa.me/{{ $dataAnak->biodata->no_tel }}"
                                                        target="_blank">
                                                        {{ $dataAnak->biodata->no_tel }}
                                                    </a>
                                                </td>
                                                <td class="text-capitalize">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $dataAnak->status == 'aktif' ? 'success' : ($dataAnak->status == 'alumni lulus' ? 'primary' : 'danger') }}">
                                                        {{ $dataAnak->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-primary p-2 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-pencil-fill"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <form
                                                                        action="{{ route('data-anak.status', $dataAnak->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ $dataAnak->user_id }}">
                                                                        <input type="hidden" name="nama"
                                                                            value="{{ $dataAnak->biodata->nama }}">
                                                                        <input type="hidden" name="jk"
                                                                            value="{{ $dataAnak->biodata->jk }}">
                                                                        <input type="hidden" name="status_anak"
                                                                            value="{{ $dataAnak->biodata->status_anak }}">
                                                                        <input type="hidden" name="pendidikan"
                                                                            value="{{ $dataAnak->biodata->pendidikan }}">
                                                                        <input type="hidden" name="ttl"
                                                                            value="{{ $dataAnak->biodata->ttl }}">
                                                                        <input type="hidden" name="ortu"
                                                                            value="{{ $dataAnak->biodata->ortu }}">
                                                                        <input type="hidden" name="pekerjaan"
                                                                            value="{{ $dataAnak->biodata->pekerjaan }}">
                                                                        <input type="hidden" name="no_tel"
                                                                            value="{{ $dataAnak->biodata->no_tel }}">
                                                                        <input type="hidden" name="alamat"
                                                                            value="{{ $dataAnak->biodata->alamat }}">
                                                                        <input type="hidden" name="nik"
                                                                            value="{{ $dataAnak->biodata->nik }}">
                                                                        <input type="hidden" name="tahap"
                                                                            value="2">
                                                                        <input type="hidden" name="status"
                                                                            value="alumni lulus">
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-check-line me-1"></i>Alumni Lulus
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#dynamicModal"
                                                                        data-modal-type="edit"
                                                                        data-userid="{{ $dataAnak->user_id }}"
                                                                        data-id="{{ $dataAnak->id }}"
                                                                        data-nama="{{ $dataAnak->biodata->nama }}"
                                                                        data-jenis_kelamin="{{ $dataAnak->biodata->jk }}"
                                                                        data-status_anak="{{ $dataAnak->biodata->status_anak }}"
                                                                        data-pendidikan="{{ $dataAnak->biodata->pendidikan }}"
                                                                        data-ttl="{{ $dataAnak->biodata->ttl }}"
                                                                        data-ortu="{{ $dataAnak->biodata->ortu }}"
                                                                        data-pekerjaan="{{ $dataAnak->biodata->pekerjaan }}"
                                                                        data-no_tel="{{ $dataAnak->biodata->no_tel }}"
                                                                        data-alamat="{{ $dataAnak->biodata->alamat }}"
                                                                        data-nik="{{ $dataAnak->biodata->nik }}"
                                                                        data-status="alumni bermasalah">
                                                                        <i class="ri-edit-line me-1"></i> Alumni Bermasalah
                                                                    </button>
                                                                </li>
                                                              <li>
                                                                    <a class="dropdown-item text-primary" href="{{route('data-anak.detail', $dataAnak->id)}}">
                                                                        <i class="ri-edit-box-line me-1"></i> Edit Data Anak
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <div class="dropdown-divider"></div>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item text-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#dynamicModal"
                                                                        data-id="{{ $dataAnak->id }}"
                                                                        data-nama="{{ $dataAnak->biodata->nama }}"
                                                                        data-modal-type="hapus">
                                                                        <i class="ri-delete-bin-line me-1"></i> Hapus Data
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <button type="button" class="btn btn-primary p-2"
                                                            data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                            data-id="{{ $dataAnak->id }}"
                                                            data-nik="{{ $dataAnak->biodata->nik }}"
                                                            data-nama="{{ $dataAnak->biodata->nama }}"
                                                            data-jenis_kelamin="{{ $dataAnak->biodata->jk }}"
                                                            data-ttl="{{ $dataAnak->biodata->ttl }}"
                                                            data-pendidikan="{{ $dataAnak->biodata->pendidikan }}"
                                                            data-alamat="{{ $dataAnak->biodata->alamat }}"
                                                            data-pekerjaan="{{ $dataAnak->biodata->pekerjaan }}"
                                                            data-no_tel="{{ $dataAnak->biodata->no_tel }}"
                                                            data-status_anak="{{ $dataAnak->biodata->status_anak }}"
                                                            data-orang_tua="{{ $dataAnak->biodata->ortu }}"
                                                            data-tahap="{{ $dataAnak->tahap }}"
                                                            data-status="{{ $dataAnak->status }}"
                                                            data-fp_formulir="{{ $dataAnak->fp_formulir }}"
                                                            data-fp_surat_izin="{{ $dataAnak->fp_surat_izin }}"
                                                            data-fp_ktp="{{ $dataAnak->fp_ktp }}"
                                                            data-fp_kk="{{ $dataAnak->fp_kk }}"
                                                            data-fp_suket_tidak_mampu="{{ $dataAnak->fp_suket_tidak_mampu }}"
                                                            data-fp_suket_kematian="{{ $dataAnak->fp_suket_kematian }}"
                                                            data-fp_suket_sehat="{{ $dataAnak->fp_suket_sehat }}"
                                                            data-fp_bpjs="{{ $dataAnak->fp_bpjs }}"
                                                            data-fp_akte="{{ $dataAnak->fp_akte }}"
                                                            data-fp_foto="{{ $dataAnak->fp_foto }}"
                                                            @if (!empty($dataAnak->pendaftaran->files)) @foreach ($dataAnak->pendaftaran->files as $fileName => $filePath)
                                                        data-file-{{ $fileName }}="{{ $filePath->file_path }}"
                                                        data-fn{{ $fileName }}="{{ $filePath->file_name }}"
                                                    @endforeach @endif>
                                                            <i class="ri-search-eye-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab alumni -->
                        <div class="tab-pane fade" id="alumni" role="tabpanel" aria-labelledby="alumni-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>TTL</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th>Pendidikan</th>
                                            <th>Alamat Asal</th>
                                            <th>Nama Ortu</th>
                                            <th>Pekerjaan</th>
                                            <th>No. Telp</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alumni as $dataAnak)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dataAnak->biodata->nama }}</td>
                                                <td class="truncate">{{ $dataAnak->biodata->nik }}</td>
                                                <td class="truncate">{{ $dataAnak->biodata->ttl }}</td>
                                                <td>{{ $dataAnak->biodata->jk }}</td>
                                                <td>{{ $dataAnak->biodata->status_anak }}</td>
                                                <td>{{ $dataAnak->biodata->pendidikan }}</td>
                                                <td class="truncate">{{ $dataAnak->biodata->alamat }}</td>
                                                <td>{{ $dataAnak->biodata->ortu }}</td>
                                                <td>{{ $dataAnak->biodata->pekerjaan }}</td>
                                                <td class="text-capitalize">
                                                    <a class="text-primary"
                                                        href="https://wa.me/{{ $dataAnak->biodata->no_tel }}"
                                                        target="_blank">
                                                        {{ $dataAnak->biodata->no_tel }}
                                                    </a>
                                                </td>
                                                <td class="text-capitalize">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $dataAnak->status == 'aktif' ? 'success' : ($dataAnak->status == 'alumni lulus' ? 'primary' : 'danger') }}">
                                                        {{ $dataAnak->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-primary p-2 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-pencil-fill"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <form
                                                                        action="{{ route('data-anak.status', $dataAnak->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ $dataAnak->user_id }}">
                                                                        <input type="hidden" name="nama"
                                                                            value="{{ $dataAnak->biodata->nama }}">
                                                                        <input type="hidden" name="jk"
                                                                            value="{{ $dataAnak->biodata->jk }}">
                                                                        <input type="hidden" name="status_anak"
                                                                            value="{{ $dataAnak->biodata->status_anak }}">
                                                                        <input type="hidden" name="pendidikan"
                                                                            value="{{ $dataAnak->biodata->pendidikan }}">
                                                                        <input type="hidden" name="ttl"
                                                                            value="{{ $dataAnak->biodata->ttl }}">
                                                                        <input type="hidden" name="ortu"
                                                                            value="{{ $dataAnak->biodata->ortu }}">
                                                                        <input type="hidden" name="pekerjaan"
                                                                            value="{{ $dataAnak->biodata->pekerjaan }}">
                                                                        <input type="hidden" name="no_tel"
                                                                            value="{{ $dataAnak->biodata->no_tel }}">
                                                                        <input type="hidden" name="alamat"
                                                                            value="{{ $dataAnak->biodata->alamat }}">
                                                                        <input type="hidden" name="nik"
                                                                            value="{{ $dataAnak->biodata->nik }}">
                                                                        <input type="hidden" name="tahap"
                                                                            value="2">
                                                                        <input type="hidden" name="status"
                                                                            value="alumni lulus">
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-check-line me-1"></i>Alumni Lulus
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#dynamicModal"
                                                                        data-modal-type="edit"
                                                                        data-userid="{{ $dataAnak->user_id }}"
                                                                        data-id="{{ $dataAnak->id }}"
                                                                        data-nama="{{ $dataAnak->biodata->nama }}"
                                                                        data-jenis_kelamin="{{ $dataAnak->biodata->jk }}"
                                                                        data-status_anak="{{ $dataAnak->biodata->status_anak }}"
                                                                        data-pendidikan="{{ $dataAnak->biodata->pendidikan }}"
                                                                        data-ttl="{{ $dataAnak->biodata->ttl }}"
                                                                        data-ortu="{{ $dataAnak->biodata->ortu }}"
                                                                        data-pekerjaan="{{ $dataAnak->biodata->pekerjaan }}"
                                                                        data-no_tel="{{ $dataAnak->biodata->no_tel }}"
                                                                        data-alamat="{{ $dataAnak->biodata->alamat }}"
                                                                        data-nik="{{ $dataAnak->biodata->nik }}"
                                                                        data-status="alumni bermasalah">
                                                                        <i class="ri-edit-line me-1"></i> Alumni Bermasalah
                                                                    </button>
                                                                </li>
                                                              <li>
                                                                    <a class="dropdown-item text-primary" href="{{route('data-anak.detail', $dataAnak->id)}}">
                                                                        <i class="ri-edit-box-line me-1"></i> Edit Data Anak
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <div class="dropdown-divider"></div>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item text-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#dynamicModal"
                                                                        data-id="{{ $dataAnak->id }}"
                                                                        data-nama="{{ $dataAnak->biodata->nama }}"
                                                                        data-modal-type="hapus">
                                                                        <i class="ri-delete-bin-line me-1"></i> Hapus Data
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <button type="button" class="btn btn-primary p-2"
                                                            data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                            data-id="{{ $dataAnak->id }}"
                                                            data-nik="{{ $dataAnak->biodata->nik }}"
                                                            data-nama="{{ $dataAnak->biodata->nama }}"
                                                            data-jenis_kelamin="{{ $dataAnak->biodata->jk }}"
                                                            data-ttl="{{ $dataAnak->biodata->ttl }}"
                                                            data-pendidikan="{{ $dataAnak->biodata->pendidikan }}"
                                                            data-alamat="{{ $dataAnak->biodata->alamat }}"
                                                            data-pekerjaan="{{ $dataAnak->biodata->pekerjaan }}"
                                                            data-no_tel="{{ $dataAnak->biodata->no_tel }}"
                                                            data-status_anak="{{ $dataAnak->biodata->status_anak }}"
                                                            data-orang_tua="{{ $dataAnak->biodata->ortu }}"
                                                            data-tahap="{{ $dataAnak->tahap }}"
                                                            data-status="{{ $dataAnak->status }}"
                                                            data-fp_formulir="{{ $dataAnak->fp_formulir }}"
                                                            data-fp_surat_izin="{{ $dataAnak->fp_surat_izin }}"
                                                            data-fp_ktp="{{ $dataAnak->fp_ktp }}"
                                                            data-fp_kk="{{ $dataAnak->fp_kk }}"
                                                            data-fp_suket_tidak_mampu="{{ $dataAnak->fp_suket_tidak_mampu }}"
                                                            data-fp_suket_kematian="{{ $dataAnak->fp_suket_kematian }}"
                                                            data-fp_suket_sehat="{{ $dataAnak->fp_suket_sehat }}"
                                                            data-fp_bpjs="{{ $dataAnak->fp_bpjs }}"
                                                            data-fp_akte="{{ $dataAnak->fp_akte }}"
                                                            data-fp_foto="{{ $dataAnak->fp_foto }}"
                                                            @if (!empty($dataAnak->pendaftaran->files)) @foreach ($dataAnak->pendaftaran->files as $fileName => $filePath)
                                                        data-file-{{ $fileName }}="{{ $filePath->file_path }}"
                                                        data-fn{{ $fileName }}="{{ $filePath->file_name }}"
                                                    @endforeach @endif>
                                                            <i class="ri-search-eye-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab alumni masalah-->
                        <div class="tab-pane fade" id="alumniBermasalah" role="tabpanel"
                            aria-labelledby="alumniBermasalah-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>TTL</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th>Pendidikan</th>
                                            <th>Alamat Asal</th>
                                            <th>Nama Ortu</th>
                                            <th>Pekerjaan</th>
                                            <th>No. Telp</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alumniBermasalah as $dataAnak)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dataAnak->biodata->nama }}</td>
                                                <td>{{ $dataAnak->biodata->nik }}</td>
                                                <td>{{ $dataAnak->biodata->ttl }}</td>
                                                <td>{{ $dataAnak->biodata->jk }}</td>
                                                <td>{{ $dataAnak->biodata->status_anak }}</td>
                                                <td>{{ $dataAnak->biodata->pendidikan }}</td>
                                                <td>{{ $dataAnak->biodata->alamat }}</td>
                                                <td>{{ $dataAnak->biodata->ortu }}</td>
                                                <td>{{ $dataAnak->biodata->pekerjaan }}</td>
                                                <td class="text-capitalize">
                                                    <a class="text-primary"
                                                        href="https://wa.me/{{ $dataAnak->biodata->no_tel }}"
                                                        target="_blank">
                                                        {{ $dataAnak->biodata->no_tel }}
                                                    </a>
                                                </td>
                                                <td class="text-capitalize">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $dataAnak->status == 'aktif' ? 'success' : ($dataAnak->status == 'alumni lulus' ? 'primary' : 'danger') }}">
                                                        {{ $dataAnak->status }}
                                                    </span>
                                                </td>
                                                <td class="text-capitalize truncate">{{ $dataAnak->keterangan }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-primary p-2 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-pencil-fill"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <form
                                                                        action="{{ route('data-anak.status', $dataAnak->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ $dataAnak->user_id }}">
                                                                        <input type="hidden" name="nama"
                                                                            value="{{ $dataAnak->biodata->nama }}">
                                                                        <input type="hidden" name="jk"
                                                                            value="{{ $dataAnak->biodata->jk }}">
                                                                        <input type="hidden" name="status_anak"
                                                                            value="{{ $dataAnak->biodata->status_anak }}">
                                                                        <input type="hidden" name="pendidikan"
                                                                            value="{{ $dataAnak->biodata->pendidikan }}">
                                                                        <input type="hidden" name="ttl"
                                                                            value="{{ $dataAnak->biodata->ttl }}">
                                                                        <input type="hidden" name="ortu"
                                                                            value="{{ $dataAnak->biodata->ortu }}">
                                                                        <input type="hidden" name="pekerjaan"
                                                                            value="{{ $dataAnak->biodata->pekerjaan }}">
                                                                        <input type="hidden" name="no_tel"
                                                                            value="{{ $dataAnak->biodata->no_tel }}">
                                                                        <input type="hidden" name="alamat"
                                                                            value="{{ $dataAnak->biodata->alamat }}">
                                                                        <input type="hidden" name="nik"
                                                                            value="{{ $dataAnak->biodata->nik }}">
                                                                        <input type="hidden" name="tahap"
                                                                            value="2">
                                                                        <input type="hidden" name="status"
                                                                            value="alumni lulus">
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-check-line me-1"></i>Alumni Lulus
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#dynamicModal"
                                                                        data-modal-type="edit"
                                                                        data-userid="{{ $dataAnak->user_id }}"
                                                                        data-id="{{ $dataAnak->id }}"
                                                                        data-nama="{{ $dataAnak->biodata->nama }}"
                                                                        data-jenis_kelamin="{{ $dataAnak->biodata->jk }}"
                                                                        data-status_anak="{{ $dataAnak->biodata->status_anak }}"
                                                                        data-pendidikan="{{ $dataAnak->biodata->pendidikan }}"
                                                                        data-ttl="{{ $dataAnak->biodata->ttl }}"
                                                                        data-ortu="{{ $dataAnak->biodata->ortu }}"
                                                                        data-pekerjaan="{{ $dataAnak->biodata->pekerjaan }}"
                                                                        data-no_tel="{{ $dataAnak->biodata->no_tel }}"
                                                                        data-alamat="{{ $dataAnak->biodata->alamat }}"
                                                                        data-nik="{{ $dataAnak->biodata->nik }}"
                                                                        data-status="alumni bermasalah">
                                                                        <i class="ri-edit-line me-1"></i> Alumni Bermasalah
                                                                    </button>
                                                                </li>
                                                              <li>
                                                                    <a class="dropdown-item text-primary" href="{{route('data-anak.detail', $dataAnak->id)}}">
                                                                        <i class="ri-edit-box-line me-1"></i> Edit Data Anak
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <div class="dropdown-divider"></div>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item text-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#dynamicModal"
                                                                        data-id="{{ $dataAnak->id }}"
                                                                        data-nama="{{ $dataAnak->biodata->nama }}"
                                                                        data-modal-type="hapus">
                                                                        <i class="ri-delete-bin-line me-1"></i> Hapus Data
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <button type="button" class="btn btn-primary p-2"
                                                            data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                            data-id="{{ $dataAnak->id }}"
                                                            data-nik="{{ $dataAnak->biodata->nik }}"
                                                            data-nama="{{ $dataAnak->biodata->nama }}"
                                                            data-jenis_kelamin="{{ $dataAnak->biodata->jk }}"
                                                            data-ttl="{{ $dataAnak->biodata->ttl }}"
                                                            data-pendidikan="{{ $dataAnak->biodata->pendidikan }}"
                                                            data-alamat="{{ $dataAnak->biodata->alamat }}"
                                                            data-pekerjaan="{{ $dataAnak->biodata->pekerjaan }}"
                                                            data-no_tel="{{ $dataAnak->biodata->no_tel }}"
                                                            data-status_anak="{{ $dataAnak->biodata->status_anak }}"
                                                            data-orang_tua="{{ $dataAnak->biodata->ortu }}"
                                                            data-tahap="{{ $dataAnak->tahap }}"
                                                            data-status="{{ $dataAnak->status }}"
                                                            data-fp_formulir="{{ $dataAnak->fp_formulir }}"
                                                            data-fp_surat_izin="{{ $dataAnak->fp_surat_izin }}"
                                                            data-fp_ktp="{{ $dataAnak->fp_ktp }}"
                                                            data-fp_kk="{{ $dataAnak->fp_kk }}"
                                                            data-fp_suket_tidak_mampu="{{ $dataAnak->fp_suket_tidak_mampu }}"
                                                            data-fp_suket_kematian="{{ $dataAnak->fp_suket_kematian }}"
                                                            data-fp_suket_sehat="{{ $dataAnak->fp_suket_sehat }}"
                                                            data-fp_bpjs="{{ $dataAnak->fp_bpjs }}"
                                                            data-fp_akte="{{ $dataAnak->fp_akte }}"
                                                            data-fp_foto="{{ $dataAnak->fp_foto }}"
                                                            @if (!empty($dataAnak->pendaftaran->files)) @foreach ($dataAnak->pendaftaran->files as $fileName => $filePath)
                                                        data-file-{{ $fileName }}="{{ $filePath->file_path }}"
                                                        data-fn{{ $fileName }}="{{ $filePath->file_name }}"
                                                    @endforeach @endif>
                                                            <i class="ri-search-eye-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body p-7">
                    <div class="divider text-start">
                        <div class="divider-text ms-3 fs-5">Data Riwayat Anak</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered dataTable" id="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Nama Ortu / Wali</th>
                                    <th scope="col">No. Telp</th>
                                    <th scope="col">File Pendukung</th>
                                    <th scope="col">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat as $riwayatAnak)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $riwayatAnak->biodata->nama }}</td>
                                        <td class="text-capitalize">{{ $riwayatAnak->status }}</td>
                                        <td class="text-capitalize truncate">{{ $riwayatAnak->keterangan }}</td>
                                        <td class="text-capitalize">{{ $riwayatAnak->biodata->ortu }}</td>
                                        <td class="text-capitalize">
                                            <a class="text-primary"
                                                href="https://wa.me/{{ $riwayatAnak->biodata->no_tel }}"
                                                target="_blank">
                                                {{ $riwayatAnak->biodata->no_tel }}
                                            </a>
                                        </td>
                                        <td>
                                          @if(!empty($riwayatAnak->fp_riwayat))
                                          <img src="{{ asset('storage/' . $riwayatAnak->fp_riwayat) }}"
                                          alt="Gambar Riwayat Anak"
                                          width="100"
                                          class="rounded img-thumbnail"
                                          data-bs-toggle="modal"
                                          data-bs-target="#imageModal{{ $riwayatAnak->fn_riwayat }}">
                                          @else
                                          -
                                          @endif
                                        </td>
                                        <td class="text-capitalize">{{ $riwayatAnak->updated_at->format('Y-m-d H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!empty($riwayatAnak->fp_riwayat))
    <div class="modal fade" id="imageModal{{ $riwayatAnak->fn_riwayat }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-body text-center">
                  <img src="{{ asset('storage/' . $riwayatAnak->fp_riwayat) }}" class="img-fluid rounded" alt="Gambar Riwayat Anak">
              </div>
          </div>
      </div>
    @endif
    <!-- Modal Detail -->
    <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dynamicModalForm">
                        <div id="modalContent">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModal"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        function handleConfirmation(event, number, anak) {
            event.preventDefault();
            const button = event.target;

            if (confirm('Apakah anda ingin mengabarkan orang tua?')) {

                const message = `Halo, saya dari Sistem Informasi Panti Asuhan. Ada update terbaru atas kondisi anak anda ${anak}. Silahkan kunjungi website kami untuk informasi lebih lanjut.`;

                const whatsappUrl = `https://wa.me/${number}?text=${encodeURIComponent(message)}`;
                window.open(whatsappUrl, '_blank');
            }

            const form = button.closest('form');
            if (form) {
                form.submit();
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const dynamicModal = document.getElementById('dynamicModal');
            const modalTitle = dynamicModal.querySelector('.modal-title');
            const modalContent = document.getElementById('modalContent');
            const modalForm = document.getElementById('dynamicModalForm');
            const closeModal = document.getElementById('closeModal');

            function createDocumentButton(button, attribute, label) {
                const filePath = button.getAttribute(attribute);
                if (filePath) {
                    return `
                        <div class="col-md-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <button class="btn btn-info w-100" onclick="window.open('/storage/${filePath}', '_blank')">
                                    <i class="ri-search-eye-line me-2"></i> ${label}
                                </button>
                            </div>
                        </div>
                    `;
                }
                return '';
            }

            dynamicModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const modalType = button.getAttribute('data-modal-type');
                const modalId = button.getAttribute('data-id');
                const modalStats = button.getAttribute('data-status');
                const modalTahap = button.getAttribute('data-tahap');


                const documents = [
                    createDocumentButton(button, 'data-fp_formulir', 'Formulir'),
                    createDocumentButton(button, 'data-fp_surat_izin', 'Surat Izin'),
                    createDocumentButton(button, 'data-fp_suket_tidak_mampu', 'Suket Tidak Mampu'),
                    createDocumentButton(button, 'data-fp_suket_kematian', 'Suket Kematian'),
                    createDocumentButton(button, 'data-fp_suket_sehat', 'Suket Sehat'),
                    createDocumentButton(button, 'data-fp_ktp', 'KTP'),
                    createDocumentButton(button, 'data-fp_kk', 'KK'),
                    createDocumentButton(button, 'data-fp_bpjs', 'BPJS'),
                    createDocumentButton(button, 'data-fp_akte', 'Akte'),
                    createDocumentButton(button, 'data-fp_foto', 'Pas Foto'),
                ];

                for (const [key, value] of Object.entries(button.dataset)) {
                    if (key.startsWith("file")) {
                        let num = key.replace('file-', '');
                        let fileName = 'fn' + num
                        documents.push(createDocumentButton(button, `data-${key}`, button.dataset[
                            fileName]));
                    }
                }

                const hasDocuments = documents.some(doc => doc !== '');

                if (modalType === 'edit') {
                    modalTitle.textContent = `Ubah Status ${button.getAttribute('data-nama')}`;
                    modalForm.setAttribute('action', `/data-anak/status/${modalId}`);
                    modalForm.setAttribute('method', 'POST');
                    closeModal.replaceWith(
                        ``
                    )
                    modalForm.innerHTML = `
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-5">
                          <input type="hidden" name="id" value="${modalId}">
                          <input type="hidden" name="tahap" value="${modalTahap}">
                          <input type="hidden" name="status" value="${modalStats}">
                          <input type="hidden" name="user_id" value="${button.getAttribute('data-userid')}">
                            <input type="hidden" name="nama" value="${button.getAttribute('data-nama')}">
                            <input type="hidden" name="jk" value="${button.getAttribute('data-jenis_kelamin')}">
                            <input type="hidden" name="ttl" value="${button.getAttribute('data-ttl')}">
                            <input type="hidden" name="ortu" value="${button.getAttribute('data-ortu')}">
                            <input type="hidden" name="alamat" value="${button.getAttribute('data-alamat')}">
                            <input type="hidden" name="pekerjaan" value="${button.getAttribute('data-pekerjaan')}">
                            <input type="hidden" name="no_tel" value="${button.getAttribute('data-no_tel')}">
                            <input type="hidden" name="nik" value="${button.getAttribute('data-nik')}">
                            <input type="hidden" name="status_anak" value="${button.getAttribute('data-status_anak')}">
                            <input type="hidden" name="pendidikan" value="${button.getAttribute('data-pendidikan')}">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan" required rows="3"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    </div>`;
                } else if (modalType === 'riwayat') {
                    modalTitle.textContent = `Riwayat Keadaan ${button.getAttribute('data-nama')}`;
                    const number = button.getAttribute("data-no_tel");
                    const anak = button.getAttribute("data-nama");
                    modalForm.setAttribute('action', `/pages/data-riwayat`);
                    modalForm.setAttribute('method', 'POST');
                    modalForm.setAttribute('enctype', 'multipart/form-data');
                    closeModal.replaceWith(
                        ``
                    )
                    modalForm.innerHTML = `
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12 mb-5">
                          <input type="hidden" name="anaks_id" value="${modalId}">
                          <input type="hidden" name="user_id" value="${button.getAttribute('data-userid')}">
                          <div class="form-floating mb-3 form-floating-outline">
                            <input type="text" name="status" class="form-control" placeholder="Status" required>
                            <label for="status">Status</label>
                          </div>
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan" required rows="3"></textarea>
                          <div class="row">
                            <div class="col-md-12 mb-3">
                              <label for="fp_riwayat" class="form-label">Riwayat Keadaan</label>
                              <input type="file" class="form-control" id="fp_riwayat" name="fp_riwayat" accept="image/*, application/pdf">
                              <small class="text-muted">Format: JPEG, PNG, JPG, PDF. Maksimal: 2MB.</small>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    </div>`;
                    modalForm.removeEventListener("submit", handleConfirmation);
                    modalForm.addEventListener("submit", (event) => handleConfirmation(event, number, anak));
                } else if (modalType === 'hapus') {
                    modalTitle.textContent = `Hapus Data ${button.getAttribute('data-nama')}`;
                    modalForm.setAttribute('action', `/data-anak/hapus/${button.getAttribute('data-id')}`);
                    modalForm.setAttribute('method', 'POST');
                    closeModal.replaceWith(
                        ``
                    )
                    modalForm.innerHTML = `
                    @csrf
                    @method('DELETE')
                    <p>Apakah Anda yakin ingin menghapus data <strong>${button.getAttribute('data-nama')}</strong>?</p>
                    <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger me-2">Hapus</button>
                    </div>
                `;
                } else if (modalType === 'tambah') {
                    modalTitle.textContent = `Tambah Data Anak`;
                    modalForm.setAttribute('action', `/pages/data-anak`);
                    modalForm.setAttribute('method', 'POST');
                    closeModal.replaceWith(
                        ``
                    )
                    modalForm.innerHTML = `
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12 mb-5">
                          <select name="user_id" class="form-select mb-3" required>
                            <option value="" disabled selected>Pilih Orang Tua</option>
                            @foreach ($user as $ortu)
                            <option value="{{ $ortu->id }}" data-ortu="{{ $ortu->nama_lengkap }}">{{ $ortu->nama_lengkap }}</option>
                            @endforeach
                          </select>
                          <div class="form-floating mb-3 form-floating-outline">
                            <input type="text" name="ortu" class="form-control" placeholder="Nama Ortu/Wali" required>
                            <label for="ortu">Nama Ortu/Wali</label>
                          </div>
                          <div class="form-floating mb-3 form-floating-outline">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Anak" required>
                            <label for="nama">Nama Anak</label>
                          </div>
                          <div class="form-floating mb-3 form-floating-outline">
                            <input type="number" name="nik" class="form-control" placeholder="NIK" required>
                            <label for="nik">NIK</label>
                          </div>
                          <div class="form-floating mb-3 form-floating-outline">
                            <input type="text" name="ttl" class="form-control" placeholder="Tempat, Tanggal Lahir" required>
                            <label for="ttl">Tempat, Tanggal Lahir</label>
                          </div>
                          <div class="form-floating mb-3 form-floating-outline">
                            <input type="text" name="pekerjaan" class="form-control" placeholder="Pekerjaan" required>
                            <label for="pekerjaan">Pekerjaan</label>
                          </div>
                          <select name="jk" class="form-select mb-3" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                          </select>
                          <select name="status_anak" class="form-select mb-3" required>
                            <option value="" disabled selected>Pilih Status Anak</option>
                            <option value="Anak Yatim">Anak Yatim</option>
                            <option value="Anak Piatu">Anak Piatu</option>
                            <option value="Anak Yatim Piatu">Anak Yatim Piatu</option>
                            <option value="Anak Tidak Mampu">Anak Tidak Mampu</option>
                            <option value="Lainnya">Lainnya</option>
                          </select>
                          <div class="form-floating mb-3 form-floating-outline">
                            <input type="text" name="pendidikan" class="form-control" placeholder="Pendidikan" required>
                            <label for="pendidikan">Pendidikan</label>
                          </div>
                          <div class="mb-3">
                            <label for="alamat">Alamat Anak</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                          </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    </div>
                    `;
                } else {
                    modalTitle.textContent = `Lihat Data ${button.getAttribute('data-nama')}`;

                    modalForm.innerHTML = `
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="d-flex align-items-center flex-column">
                                ${button.getAttribute('data-fp_foto') ?
                                    `<img src="/storage/${button.getAttribute('data-fp_foto')}" alt="foto profil" onclick="window.open('/storage/${button.getAttribute('data-fp_foto')}', '_blank')" class="img-fluid rounded mb-2" width="120">` : ''
                                }
                                <h5 class="mb-0">${button.getAttribute('data-nama')}</h5>
                                <span class="text-muted">${button.getAttribute('data-pendidikan')}</span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="divider text-center">
                                <div class="divider-text fs-5">Biodata</div>
                            </div>
                        </div>

                        ${['data-nama', 'data-jenis_kelamin', 'data-nik', 'data-status_anak',
                           'data-pendidikan', 'data-orang_tua', 'data-pekerjaan',
                           'data-no_tel'].map(attr =>
                           `<div class="col-md-6 mb-3"><div class="form-floating form-floating-outline"><input type="text" class="form-control" id="${attr}" placeholder="${attr.replace('data-', '')}" value="${button.getAttribute(attr)}" readonly> <label for="${attr}" class="text-capitalize">${attr.replace('data-', '').replace('_', ' ')}</label> </div> </div>`).join('')}

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" rows="3" placeholder="Alamat" readonly>
                                    ${button.getAttribute('data-alamat')}
                                </textarea>
                            </div>
                        </div>

                        ${hasDocuments ?
                            `<div class="row"><div class="col-md-12"><div class="divider text-center"><div class="divider-text fs-5">Bagian Administrasi</div></div></div></div><div class="row">${documents.join('')}</div>` : ''}
                    </div>`;
                }
            });
        });
    </script>
@endsection
