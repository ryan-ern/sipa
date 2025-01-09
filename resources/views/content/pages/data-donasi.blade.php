@extends('layouts/contentNavbarLayout')

@section('title', 'Data Donasi')

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
                        <div class="divider-text ms-3 fs-5">Data Donasi</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">No. Telp</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $donasi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $donasi->nama }}</td>
                                        <td>{{ $donasi->no_tel }}</td>
                                        <td>{{ $donasi->jenis }}</td>
                                        <td class="truncate">{{ $donasi->keterangan }}</td>
                                        <td class="text-start">{{ $donasi->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-primary p-2 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-pencil-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#dynamicModal" data-modal-type="edit"
                                                            data-id="{{ $donasi->id }}" data-nama="{{ $donasi->nama }}"
                                                            data-no_tel="{{ $donasi->no_tel }}"
                                                            data-jenis="{{ $donasi->jenis }}"
                                                            data-keterangan="{{ $donasi->keterangan }}">
                                                            <i class="ri-file-edit-line me-1"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#dynamicModal" data-modal-type="delete"
                                                            data-id="{{ $donasi->id }}" data-nama="{{ $donasi->nama }}">
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
        <!-- Modal Create, Update, Delete -->
        <div class="modal fade" id="dynamicModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ModalLabel">
            <div class="modal-dialog">
                <form id="dynamicModalForm" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modalContent">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dynamicModal = document.getElementById('dynamicModal');
            const modalTitle = dynamicModal.querySelector('.modal-title');
            const modalContent = document.getElementById('modalContent');
            const modalForm = document.getElementById('dynamicModalForm');

            dynamicModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const modalType = button.getAttribute('data-modal-type');
                const donasiId = button.getAttribute('data-id');

                if (modalType === 'edit') {
                    modalTitle.textContent = 'Edit Data';
                    modalForm.action = `/pages/data-donasi/${donasiId}`;
                    modalForm.method = 'POST';
                    modalContent.innerHTML = `
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="${button.getAttribute('data-nama')}" required>
                            <label for="nama" >Nama</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-floating form-floating-outline">
                            <input type="tel" class="form-control" id="no_tel" name="no_tel" placeholder="Nomor Telepon" value="${button.getAttribute('data-no_tel')}" required>
                            <label for="no_tel" >Nomor Telepon</label>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-floating form-floating-outline">
                            <select class="form-select" id="jenis" name="jenis" required>
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="uang" ${button.getAttribute('data-jenis') === 'uang' ? 'selected' : ''}>Uang Tunai</option>
                                <option value="barang" ${button.getAttribute('data-jenis') === 'barang' ? 'selected' : ''}>Barang</option>
                                <option value="lainnya" ${button.getAttribute('data-jenis') === 'lainnya' ? 'selected' : ''}>Lainnya</option>
                            </select>
                            <label for="jenis" >Jenis</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan" required>${button.getAttribute('data-keterangan')}</textarea>
                        </div>
                      </div>
                `;
                } else if (modalType === 'delete') {
                    modalTitle.textContent = 'Hapus Data';
                    modalForm.action = `/pages/data-donasi/${donasiId}`;
                    modalForm.method = 'POST';
                    modalContent.innerHTML = `
                    @csrf
                    @method('DELETE')
                    <p>Apakah Anda yakin ingin menghapus data <strong>${button.getAttribute('data-nama_lengkap')}</strong>?</p>
                    <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
                `;
                } else {
                    modalTitle.textContent = 'Tambah Data';
                    modalForm.action = '/pages/data-donasi';
                    modalForm.method = 'POST';
                    modalContent.innerHTML = `
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                            <label for="nama">Nama</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-floating form-floating-outline">
                            <input type="tel" placeholder="Nomor Telepon" class="form-control" id="no_tel" name="no_tel" required>
                            <label for="no_tel" >Nomor Telepon</label>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-floating form-floating-outline">
                            <select class="form-select" id="jenis" name="jenis" required>
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="uang">Uang Tunai</option>
                                <option value="barang">Barang</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <label for="jenis" >Jenis</label>
                          </div>
                        </div>
                    </div>

                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan" required></textarea>
                        </div>
                      </div>
                `;
                }
            });
        });
    </script>
@endsection
