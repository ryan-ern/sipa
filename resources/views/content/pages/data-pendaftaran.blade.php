@extends('layouts/contentNavbarLayout')

@section('title', 'Data Pendaftaran')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body p-7">
                    <div class="col">
                        <div class="d-flex gap-3">
                            <div class="form-floating form-floating-outline ">
                                <input type="text" id="min" name="min" class="form-control"
                                    placeholder="Tanggal Minimal">
                                <label for="min">Tanggal Minimal</label>
                            </div>
                            <div class="form-floating form-floating-outline ">
                                <input type="text" id="max" name="max" class="form-control"
                                    placeholder="Tanggal Maximal"">
                                <label for="max">Tanggal Maximal</label>
                            </div>
                        </div>
                    </div>
                    <div class="divider text-start">
                        <div class="divider-text ms-3 fs-5">Data Pendaftaran</div>
                    </div>
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="tahapTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tahap1-tab" data-bs-toggle="tab" data-bs-target="#tahap1"
                                type="button" role="tab" aria-controls="tahap1" aria-selected="true">Tahap 1</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tahap2-tab" data-bs-toggle="tab" data-bs-target="#tahap2"
                                type="button" role="tab" aria-controls="tahap2" aria-selected="false">Tahap 2</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tahap3-tab" data-bs-toggle="tab" data-bs-target="#tahap3"
                                type="button" role="tab" aria-controls="tahap3" aria-selected="false">Tahap 3</button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content mt-4" id="tahapTabsContent">
                        <!-- Tab Tahap 1 -->
                        <div class="tab-pane fade show active" id="tahap1" role="tabpanel" aria-labelledby="tahap1-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th>Pendidikan</th>
                                            <th>Nama Ortu</th>
                                            <th>Pekerjaan</th>
                                            <th>No. Telp</th>
                                            <th>Status</th>
                                            <th>Diperbarui</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahap1 as $daftar)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $daftar->biodata->nama }}</td>
                                                <td>{{ $daftar->biodata->jk }}</td>
                                                <td>{{ $daftar->biodata->status_anak }}</td>
                                                <td>{{ $daftar->biodata->pendidikan }}</td>
                                                <td>{{ $daftar->biodata->ortu }}</td>
                                                <td>{{ $daftar->biodata->pekerjaan }}</td>
                                                <td>
                                                    <a class="text-primary"
                                                        href="https://wa.me/{{ $daftar->biodata->no_tel }}"
                                                        target="_blank">{{ $daftar->biodata->no_tel }}
                                                    </a>
                                                </td>
                                                <td class="text-capitalize">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $daftar->status == 'lulus' ? 'success' : ($daftar->status == 'tidak' ? 'danger' : ($daftar->status == 'pemberitahuan' ? 'warning' : 'primary')) }}">
                                                        {{ $daftar->status }}
                                                    </span>
                                                </td>
                                                <td>{{ $daftar->updated_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button"
                                                            class="btn btn-primary p-2 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-pencil-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <form
                                                                    action="{{ route('pendaftaran-anak.status', $daftar->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $daftar->user_id }}">
                                                                    <input type="hidden" name="nama"
                                                                        value="{{ $daftar->biodata->nama }}">
                                                                    <input type="hidden" name="jk"
                                                                        value="{{ $daftar->biodata->jk }}">
                                                                    <input type="hidden" name="status_anak"
                                                                        value="{{ $daftar->biodata->status_anak }}">
                                                                    <input type="hidden" name="pendidikan"
                                                                        value="{{ $daftar->biodata->pendidikan }}">
                                                                    <input type="hidden" name="ttl"
                                                                        value="{{ $daftar->biodata->ttl }}">
                                                                    <input type="hidden" name="ortu"
                                                                        value="{{ $daftar->biodata->ortu }}">
                                                                    <input type="hidden" name="pekerjaan"
                                                                        value="{{ $daftar->biodata->pekerjaan }}">
                                                                    <input type="hidden" name="no_tel"
                                                                        value="{{ $daftar->biodata->no_tel }}">
                                                                    <input type="hidden" name="alamat"
                                                                        value="{{ $daftar->biodata->alamat }}">
                                                                    <input type="hidden" name="nik"
                                                                        value="{{ $daftar->biodata->nik }}">
                                                                    <input type="hidden" name="tahap" value="2">
                                                                    <input type="hidden" name="status"
                                                                        value="berlangsung">
                                                                    <input type="hidden" name="keterangan"
                                                                        value="Pendaftaran telah disetujui lanjut ke tahap 2 - wawancara">
                                                                    <button type="button" class="dropdown-item"
                                                                        data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                        data-nama="{{ $daftar->biodata->nama }}"
                                                                        data-status="lulus" data-tahap="1"
                                                                        onclick="handleConfirmation(event)">
                                                                        <i class="ri-check-line me-1"></i> Lulus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#dynamicModal" data-modal-type="edit"
                                                                    data-userid="{{ $daftar->user_id }}"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}"
                                                                    data-jenis_kelamin="{{ $daftar->biodata->jk }}"
                                                                    data-status_anak="{{ $daftar->biodata->status_anak }}"
                                                                    data-pendidikan="{{ $daftar->biodata->pendidikan }}"
                                                                    data-ttl="{{ $daftar->biodata->ttl }}"
                                                                    data-ortu="{{ $daftar->biodata->ortu }}"
                                                                    data-pekerjaan="{{ $daftar->biodata->pekerjaan }}"
                                                                    data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                    data-alamat="{{ $daftar->biodata->alamat }}"
                                                                    data-nik="{{ $daftar->biodata->nik }}"
                                                                    data-status="pemberitahuan" data-tahap="1"
                                                                    onclick="handleConfirmation(event)">
                                                                    <i class="ri-edit-line me-1"></i> pemberitahuan
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="submit" class="dropdown-item"
                                                                    data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                                    data-modal-type="edit"
                                                                    data-userid="{{ $daftar->user_id }}"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}"
                                                                    data-jenis_kelamin="{{ $daftar->biodata->jk }}"
                                                                    data-status_anak="{{ $daftar->biodata->status_anak }}"
                                                                    data-pendidikan="{{ $daftar->biodata->pendidikan }}"
                                                                    data-ttl="{{ $daftar->biodata->ttl }}"
                                                                    data-ortu="{{ $daftar->biodata->ortu }}"
                                                                    data-pekerjaan="{{ $daftar->biodata->pekerjaan }}"
                                                                    data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                    data-alamat="{{ $daftar->biodata->alamat }}"
                                                                    data-nik="{{ $daftar->biodata->nik }}"
                                                                    data-status="tidak" data-tahap="1"
                                                                    onclick="handleConfirmation(event)">
                                                                    <i class="ri-close-line me-1"></i> Tidak Lulus
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                                    data-modal-type="delete"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}">
                                                                    <i class="ri-delete-bin-line me-1"></i> Hapus
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Tahap 2 -->
                        <div class="tab-pane fade" id="tahap2" role="tabpanel" aria-labelledby="tahap2-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th>Pendidikan</th>
                                            <th>Nama Ortu</th>
                                            <th>Pekerjaan</th>
                                            <th>No. Telp</th>
                                            <th>Status</th>
                                            <th>Diperbarui</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahap2 as $daftar)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $daftar->biodata->nama }}</td>
                                                <td>{{ $daftar->biodata->jk }}</td>
                                                <td>{{ $daftar->biodata->status_anak }}</td>
                                                <td>{{ $daftar->biodata->pendidikan }}</td>
                                                <td>{{ $daftar->biodata->ortu }}</td>
                                                <td>{{ $daftar->biodata->pekerjaan }}</td>
                                                <td>
                                                    <a class="text-primary"
                                                        href="https://wa.me/{{ $daftar->biodata->no_tel }}"
                                                        target="_blank">{{ $daftar->biodata->no_tel }}
                                                    </a>
                                                </td>
                                                <td class="text-capitalize">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $daftar->status == 'lulus' ? 'success' : ($daftar->status == 'tidak' ? 'danger' : ($daftar->status == 'pemberitahuan' ? 'warning' : 'primary')) }}">
                                                        {{ $daftar->status }}
                                                    </span>
                                                </td>
                                                <td>{{ $daftar->updated_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button"
                                                            class="btn btn-primary p-2 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-pencil-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <form
                                                                    action="{{ route('pendaftaran-anak.status', $daftar->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $daftar->user_id }}">
                                                                    <input type="hidden" name="nama"
                                                                        value="{{ $daftar->biodata->nama }}">
                                                                    <input type="hidden" name="jk"
                                                                        value="{{ $daftar->biodata->jk }}">
                                                                    <input type="hidden" name="status_anak"
                                                                        value="{{ $daftar->biodata->status_anak }}">
                                                                    <input type="hidden" name="pendidikan"
                                                                        value="{{ $daftar->biodata->pendidikan }}">
                                                                    <input type="hidden" name="ttl"
                                                                        value="{{ $daftar->biodata->ttl }}">
                                                                    <input type="hidden" name="ortu"
                                                                        value="{{ $daftar->biodata->ortu }}">
                                                                    <input type="hidden" name="pekerjaan"
                                                                        value="{{ $daftar->biodata->pekerjaan }}">
                                                                    <input type="hidden" name="no_tel"
                                                                        value="{{ $daftar->biodata->no_tel }}">
                                                                    <input type="hidden" name="alamat"
                                                                        value="{{ $daftar->biodata->alamat }}">
                                                                    <input type="hidden" name="nik"
                                                                        value="{{ $daftar->biodata->nik }}">
                                                                    <input type="hidden" name="tahap" value="3">
                                                                    <input type="hidden" name="status"
                                                                        value="berlangsung">
                                                                    <input type="hidden" name="keterangan"
                                                                        value="Wawancara telah lulus lanjut ke tahap 3 - Survey">
                                                                    <button type="button" class="dropdown-item"
                                                                        data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                        data-nama="{{ $daftar->biodata->nama }}"
                                                                        data-status="lulus" data-tahap="2"
                                                                        onclick="handleConfirmation(event)">
                                                                        <i class="ri-check-line me-1"></i> Lulus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#dynamicModal" data-modal-type="edit"
                                                                    data-userid="{{ $daftar->user_id }}"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}"
                                                                    data-jenis_kelamin="{{ $daftar->biodata->jk }}"
                                                                    data-status_anak="{{ $daftar->biodata->status_anak }}"
                                                                    data-pendidikan="{{ $daftar->biodata->pendidikan }}"
                                                                    data-ttl="{{ $daftar->biodata->ttl }}"
                                                                    data-ortu="{{ $daftar->biodata->ortu }}"
                                                                    data-pekerjaan="{{ $daftar->biodata->pekerjaan }}"
                                                                    data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                    data-alamat="{{ $daftar->biodata->alamat }}"
                                                                    data-nik="{{ $daftar->biodata->nik }}"
                                                                    data-status="pemberitahuan" data-tahap="2"
                                                                    onclick="handleConfirmation(event)">
                                                                    <i class="ri-edit-line me-1"></i> pemberitahuan
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="submit" class="dropdown-item"
                                                                    data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                                    data-modal-type="edit"
                                                                    data-userid="{{ $daftar->user_id }}"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}"
                                                                    data-jenis_kelamin="{{ $daftar->biodata->jk }}"
                                                                    data-status_anak="{{ $daftar->biodata->status_anak }}"
                                                                    data-pendidikan="{{ $daftar->biodata->pendidikan }}"
                                                                    data-ttl="{{ $daftar->biodata->ttl }}"
                                                                    data-ortu="{{ $daftar->biodata->ortu }}"
                                                                    data-pekerjaan="{{ $daftar->biodata->pekerjaan }}"
                                                                    data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                    data-alamat="{{ $daftar->biodata->alamat }}"
                                                                    data-nik="{{ $daftar->biodata->nik }}"
                                                                    data-status="tidak" data-tahap="2"
                                                                    onclick="handleConfirmation(event)">
                                                                    <i class="ri-close-line me-1"></i> Tidak Lulus
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                                    data-modal-type="delete"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}">
                                                                    <i class="ri-delete-bin-line me-1"></i> Hapus
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Tahap 3 -->
                        <div class="tab-pane fade" id="tahap3" role="tabpanel" aria-labelledby="tahap3-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered dataTable">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th>Pendidikan</th>
                                            <th>Nama Ortu</th>
                                            <th>Pekerjaan</th>
                                            <th>No. Telp</th>
                                            <th>Status</th>
                                            <th>Diperbarui</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahap3 as $daftar)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $daftar->biodata->nama }}</td>
                                                <td>{{ $daftar->biodata->jk }}</td>
                                                <td>{{ $daftar->biodata->status_anak }}</td>
                                                <td>{{ $daftar->biodata->pendidikan }}</td>
                                                <td>{{ $daftar->biodata->ortu }}</td>
                                                <td>{{ $daftar->biodata->pekerjaan }}</td>
                                                <td>
                                                    <a class="text-primary"
                                                        href="https://wa.me/{{ $daftar->biodata->no_tel }}"
                                                        target="_blank">{{ $daftar->biodata->no_tel }}
                                                    </a>
                                                </td>
                                                <td class="text-capitalize">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $daftar->status == 'lulus' ? 'success' : ($daftar->status == 'tidak' ? 'danger' : ($daftar->status == 'pemberitahuan' ? 'warning' : 'primary')) }}">
                                                        {{ $daftar->status }}
                                                    </span>
                                                </td>
                                                <td>{{ $daftar->updated_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button"
                                                            class="btn btn-primary p-2 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-pencil-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <form
                                                                    action="{{ route('pendaftaran-anak.status', $daftar->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="pendaftarans_id"
                                                                        value="{{ $daftar->id }}">
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $daftar->user_id }}">
                                                                    <input type="hidden" name="nama"
                                                                        value="{{ $daftar->biodata->nama }}">
                                                                    <input type="hidden" name="jk"
                                                                        value="{{ $daftar->biodata->jk }}">
                                                                    <input type="hidden" name="status_anak"
                                                                        value="{{ $daftar->biodata->status_anak }}">
                                                                    <input type="hidden" name="pendidikan"
                                                                        value="{{ $daftar->biodata->pendidikan }}">
                                                                    <input type="hidden" name="ttl"
                                                                        value="{{ $daftar->biodata->ttl }}">
                                                                    <input type="hidden" name="ortu"
                                                                        value="{{ $daftar->biodata->ortu }}">
                                                                    <input type="hidden" name="pekerjaan"
                                                                        value="{{ $daftar->biodata->pekerjaan }}">
                                                                    <input type="hidden" name="no_tel"
                                                                        value="{{ $daftar->biodata->no_tel }}">
                                                                    <input type="hidden" name="alamat"
                                                                        value="{{ $daftar->biodata->alamat }}">
                                                                    <input type="hidden" name="nik"
                                                                        value="{{ $daftar->biodata->nik }}">
                                                                    <input type="hidden" name="fn_surat_izin"
                                                                        value="{{ $daftar->fn_surat_izin }}">
                                                                    <input type="hidden" name="fp_surat_izin"
                                                                        value="{{ $daftar->fp_surat_izin }}">
                                                                    <input type="hidden" name="fn_kk"
                                                                        value="{{ $daftar->fn_kk }}">
                                                                    <input type="hidden" name="fp_kk"
                                                                        value="{{ $daftar->fp_kk }}">
                                                                    <input type="hidden" name="fn_ktp"
                                                                        value="{{ $daftar->fn_ktp }}">
                                                                    <input type="hidden" name="fp_ktp"
                                                                        value="{{ $daftar->fp_ktp }}">
                                                                    <input type="hidden" name="fn_foto"
                                                                        value="{{ $daftar->fn_foto }}">
                                                                    <input type="hidden" name="fp_foto"
                                                                        value="{{ $daftar->fp_foto }}">
                                                                    <input type="hidden" name="fn_bpjs"
                                                                        value="{{ $daftar->fn_bpjs }}">
                                                                    <input type="hidden" name="fp_bpjs"
                                                                        value="{{ $daftar->fp_bpjs }}">
                                                                    <input type="hidden" name="fn_akte"
                                                                        value="{{ $daftar->fn_akte }}">
                                                                    <input type="hidden" name="fp_akte"
                                                                        value="{{ $daftar->fp_akte }}">
                                                                    <input type="hidden" name="fn_suket_tidak_mampu"
                                                                        value="{{ $daftar->fn_suket_tidak_mampu }}">
                                                                    <input type="hidden" name="fp_suket_tidak_mampu"
                                                                        value="{{ $daftar->fp_suket_tidak_mampu }}">
                                                                    <input type="hidden" name="fn_suket_kematian"
                                                                        value="{{ $daftar->fn_suket_kematian }}">
                                                                    <input type="hidden" name="fp_suket_kematian"
                                                                        value="{{ $daftar->fp_suket_kematian }}">
                                                                    <input type="hidden" name="fn_suket_sehat"
                                                                        value="{{ $daftar->fn_suket_sehat }}">
                                                                    <input type="hidden" name="fp_suket_sehat"
                                                                        value="{{ $daftar->fp_suket_sehat }}">
                                                                    <input type="hidden" name="tahap" value="3">
                                                                    <input type="hidden" name="status" value="lulus">
                                                                    <input type="hidden" name="keterangan"
                                                                        value="Survey telah lulus Anda Diterima">
                                                                    <button type="button" class="dropdown-item"
                                                                        data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                        data-nama="{{ $daftar->biodata->nama }}"
                                                                        data-status="lulus" data-tahap="3"
                                                                        onclick="handleConfirmation(event)">
                                                                        <i class="ri-check-line me-1"></i> Lulus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#dynamicModal" data-modal-type="edit"
                                                                    data-userid="{{ $daftar->user_id }}"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}"
                                                                    data-jenis_kelamin="{{ $daftar->biodata->jk }}"
                                                                    data-status_anak="{{ $daftar->biodata->status_anak }}"
                                                                    data-pendidikan="{{ $daftar->biodata->pendidikan }}"
                                                                    data-ttl="{{ $daftar->biodata->ttl }}"
                                                                    data-ortu="{{ $daftar->biodata->ortu }}"
                                                                    data-pekerjaan="{{ $daftar->biodata->pekerjaan }}"
                                                                    data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                    data-alamat="{{ $daftar->biodata->alamat }}"
                                                                    data-nik="{{ $daftar->biodata->nik }}"
                                                                    data-status="pemberitahuan" data-tahap="3"
                                                                    onclick="handleConfirmation(event)">
                                                                    <i class="ri-edit-line me-1"></i> pemberitahuan
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="submit" class="dropdown-item"
                                                                    data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                                    data-modal-type="edit"
                                                                    data-userid="{{ $daftar->user_id }}"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}"
                                                                    data-jenis_kelamin="{{ $daftar->biodata->jk }}"
                                                                    data-status_anak="{{ $daftar->biodata->status_anak }}"
                                                                    data-pendidikan="{{ $daftar->biodata->pendidikan }}"
                                                                    data-ttl="{{ $daftar->biodata->ttl }}"
                                                                    data-ortu="{{ $daftar->biodata->ortu }}"
                                                                    data-pekerjaan="{{ $daftar->biodata->pekerjaan }}"
                                                                    data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                                    data-alamat="{{ $daftar->biodata->alamat }}"
                                                                    data-nik="{{ $daftar->biodata->nik }}"
                                                                    data-status="tidak" data-tahap="3"
                                                                    onclick="handleConfirmation(event)">
                                                                    <i class="ri-close-line me-1"></i> Tidak Lulus
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    data-bs-toggle="modal" data-bs-target="#dynamicModal"
                                                                    data-modal-type="delete"
                                                                    data-id="{{ $daftar->id }}"
                                                                    data-nama="{{ $daftar->biodata->nama }}">
                                                                    <i class="ri-delete-bin-line me-1"></i> Hapus
                                                                </button>
                                                            </li>
                                                        </ul>
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
                        <div class="divider-text ms-3 fs-5">Data Riwayat Pendaftaran</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered dataTable" id="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Nama Ortu / Wali</th>
                                    <th scope="col">No. Telp</th>
                                    <th scope="col">Tahap</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $daftar)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $daftar->biodata->nama }}</td>
                                        <td class="text-capitalize truncate">{{ $daftar->biodata->jk }}</td>
                                        <td class="text-capitalize text-truncate">{{ $daftar->biodata->status_anak }}
                                        </td>
                                        <td class="text-capitalize text-truncate">{{ $daftar->biodata->ortu }}</td>
                                        <td>
                                            <a class="text-primary" href="https://wa.me/{{ $daftar->biodata->no_tel }}"
                                                target="_blank">{{ $daftar->biodata->no_tel }}
                                            </a>
                                        </td>
                                        <td class="text-capitalize">
                                            <span
                                                class="badge rounded-pill bg-{{ $daftar->tahap == 1 ? 'info' : ($daftar->tahap == 2 ? 'primary' : 'success') }}">
                                                Tahap {{ $daftar->tahap }}
                                            </span>
                                        </td>
                                        <td class="text-capitalize">
                                            <span
                                                class="badge rounded-pill bg-{{ $daftar->status == 'lulus' ? 'success' : ($daftar->status == 'tidak' ? 'danger' : ($daftar->status == 'pemberitahuan' ? 'warning' : 'primary')) }}">
                                                {{ $daftar->status }}
                                            </span>
                                        </td>
                                        <td>{{ $daftar->updated_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary p-2" data-bs-toggle="modal"
                                                    data-bs-target="#dynamicModal" data-id="{{ $daftar->id }}"
                                                    data-modal-type="detail" data-nik="{{ $daftar->biodata->nik }}"
                                                    data-nama="{{ $daftar->biodata->nama }}"
                                                    data-jenis_kelamin="{{ $daftar->biodata->jk }}"
                                                    data-ttl="{{ $daftar->biodata->ttl }}"
                                                    data-pendidikan="{{ $daftar->biodata->pendidikan }}"
                                                    data-alamat="{{ $daftar->biodata->alamat }}"
                                                    data-pekerjaan="{{ $daftar->biodata->pekerjaan }}"
                                                    data-no_tel="{{ $daftar->biodata->no_tel }}"
                                                    data-status_anak="{{ $daftar->biodata->status_anak }}"
                                                    data-orang_tua="{{ $daftar->biodata->ortu }}"
                                                    data-tahap="{{ $daftar->tahap }}"
                                                    data-status="{{ $daftar->status }}"
                                                    data-fp_formulir="{{ $daftar->fp_formulir }}"
                                                    data-fp_surat_izin="{{ $daftar->fp_surat_izin }}"
                                                    data-fp_ktp="{{ $daftar->fp_ktp }}"
                                                    data-fp_kk="{{ $daftar->fp_kk }}"
                                                    data-fp_suket_tidak_mampu="{{ $daftar->fp_suket_tidak_mampu }}"
                                                    data-fp_suket_kematian="{{ $daftar->fp_suket_kematian }}"
                                                    data-fp_suket_sehat="{{ $daftar->fp_suket_sehat }}"
                                                    data-fp_bpjs="{{ $daftar->fp_bpjs }}"
                                                    data-fp_akte="{{ $daftar->fp_akte }}"
                                                    data-fp_foto="{{ $daftar->fp_foto }}"
                                                    @if (!empty($daftar->files)) @foreach ($daftar->files as $fileName => $filePath)
                                                        data-file-{{ $fileName }}="{{ $filePath->file_path }}"
                                                        data-fn{{ $fileName }}="{{ $filePath->file_name }}"
                                                    @endforeach @endif>
                                                    <i class="ri-search-eye-line me-2"></i> Lihat
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
        function handleConfirmation(event) {
            event.preventDefault();

            const button = event.target;

            const confirmation = confirm('Apakah anda ingin mengabarkan orang tua?');
            if (confirmation) {
                const whatsappNumber = button.getAttribute('data-no_tel');
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
                const tahap = button.getAttribute('data-tahap');
                const status = button.getAttribute('data-status');

                const message =
                    `Halo, saya dari UPTD PSAA Harapan Bangsa. Pendaftaran anak anda atas nama ${nama} berada di tahap ${tahap} dengan status ${status === 'tidak' ? 'tidak lulus' : status}. Silahkan kunjungi website kami untuk informasi lebih lanjut.`;

                const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

                window.open(whatsappUrl, '_blank', 'noopener,noreferrer');
                setTimeout(() => {
                    const form = button.closest('form');
                    if (form) {
                        form.submit();
                    }
                }, 1000);
            } else {
                const form = button.closest('form');
                if (form) {
                    form.submit();
                }
            }
        }

        document.querySelectorAll('[data-action="confirm"]').forEach(button => {
            button.addEventListener('click', handleConfirmation);
        });

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

                if (modalType == 'edit') {
                    modalTitle.textContent = `Ubah Status ${button.getAttribute('data-nama')}`;
                    modalForm.setAttribute('action', `/pendaftaran-anak/status/${modalId}`);
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
                } else if (modalType == 'detail') {
                    modalTitle.textContent = `Lihat Data ${button.getAttribute('data-nama')}`;
                    modalForm.innerHTML =
                        `
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
`<div class="col-md-6 mb-3"><div class="form-floating form-floating-outline"><input type="text" class="form-control" id="${attr}" placeholder="${attr.replace('data-', '')}" value="${button.getAttribute(attr)}" readonly> <label for="${attr}" class="text-capitalize">${attr.replace('data-', '').replace('_', ' ')}</label></div></div>`).join('')}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" rows="3" placeholder="Alamat" readonly>
                                    ${button.getAttribute('data-alamat')}
                                </textarea>
                            </div>
                        </div>
                        ${hasDocuments ?
`<div class="row"><div class="col-md-12"><div class="divider text-center"><div class="divider-text fs-5">Bagian Administrasi</div></div></div></div><div class="row">${documents.join('')}</div>` : ''}</div>`;
                } else if (modalType === 'delete') {
                    modalTitle.textContent = 'Hapus Data';
                    modalForm.action = `/pages/pendaftaran-anak/delete/${modalId}`;
                    modalForm.method = 'POST';
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
                }
            });
        });
    </script>
@endsection
