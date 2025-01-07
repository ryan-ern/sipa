@extends('layouts/contentNavbarLayout')

@section('title', 'Data Pengguna')

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
                        <div class="divider-text ms-3 fs-5">Data Pengguna</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="userTable">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Sebagai</th>
                                    <th scope="col">No. Telp</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Diperbarui</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">
                                            {{ $user->nama_lengkap }}
                                        </td>
                                        <td>{{ ucfirst($user->sebagai) }}</td>
                                        <td>{{ $user->no_tel }}</td>
                                        <td class="truncate">{{ $user->alamat }}</td>
                                        <td>{{ $user->jenis_kelamin }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            @if ($user->status == '1')
                                                <span class="badge rounded-pill bg-label-success me-1">Aktif</span>
                                            @else
                                                <span class="badge rounded-pill bg-label-danger me-1">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-start">{{ $user->updated_at->format('Y-m-d H:i') }}</td>
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
                                                            data-id="{{ $user->id }}"
                                                            data-username="{{ $user->username }}"
                                                            data-nama_lengkap="{{ $user->nama_lengkap }}"
                                                            data-no_tel="{{ $user->no_tel }}"
                                                            data-alamat="{{ $user->alamat }}"
                                                            data-jenis_kelamin="{{ $user->jenis_kelamin }}"
                                                            data-role="{{ $user->role }}"
                                                            data-sebagai="{{ $user->sebagai }}"
                                                            data-status="{{ $user->status }}">
                                                            <i class="ri-file-edit-line me-1"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#dynamicModal" data-modal-type="delete"
                                                            data-id="{{ $user->id }}"
                                                            data-nama_lengkap="{{ $user->nama_lengkap }}">
                                                            <i class="ri-delete-bin-line me-1"></i> Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data pengguna tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Create, Update, Delete -->
        <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="ModalLabel">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dynamicModal = document.getElementById('dynamicModal');
            const modalTitle = dynamicModal.querySelector('.modal-title');
            const modalContent = document.getElementById('modalContent');
            const modalForm = document.getElementById('dynamicModalForm');

            dynamicModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const modalType = button.getAttribute('data-modal-type');
                const userId = button.getAttribute('data-id');

                if (modalType === 'edit') {
                    modalTitle.textContent = 'Edit Data';
                    modalForm.action = `/pages/data-pengguna/${userId}`;
                    modalForm.method = 'POST';
                    modalContent.innerHTML = `
                    @csrf
                    @method('PUT')
                    <div class="row">
                      <div class="col-md-4">
                        <!-- username -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                                value="${button.getAttribute('data-username')}">
                            <label for="username">Username</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <!-- Nama Lengkap -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                placeholder="Nama Lengkap" value="${button.getAttribute('data-nama_lengkap')}">
                            <label for="nama_lengkap">Nama Lengkap</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <!-- Nomor Telepon -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="tel" class="form-control" id="no_tel" name="no_tel" placeholder="Nomor Telepon"
                                value="${button.getAttribute('data-no_tel')}">
                            <label for="no_tel">Nomor Telepon</label>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <!-- Sebagai -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select @error('sebagai') is-invalid @enderror" id="sebagai" name="sebagai">
                                <option value="ortu" ${button.getAttribute('data-sebagai') === 'ortu' ? 'selected' : ''}>
                                    Orang Tua
                                </option>
                                <option value="wali" ${button.getAttribute('data-sebagai') === 'wali' ? 'selected' : ''}>
                                    Wali
                                </option>
                                <option value="staff" ${button.getAttribute('data-sebagai') === 'staff' ? 'selected' : ''}>
                                    Staff
                                </option>
                            </select>
                            <label for="sebagai">Sebagai</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <!-- Jenis Kelamin -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="Laki-laki" ${button.getAttribute('data-jenis_kelamin') === 'Laki-laki' ? 'selected' : ''}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" ${button.getAttribute('data-jenis_kelamin') === 'Perempuan' ? 'selected' : ''}>
                                    Perempuan
                                </option>
                            </select>
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <!-- Alamat -->
                        <div>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat">${button.getAttribute('data-alamat')}</textarea>
                        </div>
                      </div>
                    </div>

                    <div class="divider text-center">
                        <div class="divider-text text-danger">Kolom ini Sensitif, Mohon Diperhatikan</div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <!-- role -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="admin" ${button.getAttribute('data-role') === 'admin' ? 'selected' : ''}>
                                    Admin
                                </option>
                                <option value="user" ${button.getAttribute('data-role') === 'user' ? 'selected' : ''}>
                                    User
                                </option>
                            </select>
                            <label for="role">Role</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <!-- Status -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="1" ${button.getAttribute('data-status') === '1' ? 'selected' : ''}>
                                    Aktif
                                </option>
                                <option value="0" ${button.getAttribute('data-status') === '0' ? 'selected' : ''}>
                                    Tidak Aktif
                                </option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <!-- Password -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                      </div>
                    </div>
                `;
                } else if (modalType === 'delete') {
                    modalTitle.textContent = 'Hapus Data';
                    modalForm.action = `/pages/data-pengguna/${userId}`;
                    modalForm.method = 'POST';
                    modalContent.innerHTML = `
                    @csrf
                    @method('DELETE')
                    <p>Apakah Anda yakin ingin menghapus data <strong>${button.getAttribute('data-nama_lengkap')}</strong>?</p>
                    <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
                `;
                } else {
                    modalTitle.textContent = 'Tambah Data';
                    modalForm.action = '/pages/data-pengguna';
                    modalForm.method = 'POST';
                    modalContent.innerHTML = `
                    @csrf
                    @method('POST')
                    <div class="row">
                      <div class="col-md-4">
                        <!-- username -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" autofocus required>
                            <label for="username">Username</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <!-- Nama Lengkap -->
                          <div class="form-floating form-floating-outline mb-4">
                              <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" required>
                              <label for="nama_lengkap">Nama Lengkap</label>
                          </div>
                      </div>
                      <div class="col-md-4">
                        <!-- Nomor Telepon -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="tel" class="form-control" id="no_tel" name="no_tel" placeholder="Nomor Telepon" required>
                            <label for="no_tel">Nomor Telepon</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <!-- Sebagai -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="sebagai" name="sebagai" required>
                                <option value="" disabled selected>Pilih Sebagai</option>
                                <option value="ortu">Orang Tua</option>
                                <option value="wali">Wali</option>
                                <option value="staff">Staff</option>
                            </select>
                            <label for="sebagai">Sebagai</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <!-- Jenis Kelamin -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <!-- Alamat -->
                        <div class="mb-4">
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" cols="50" placeholder="Alamat" required></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <!-- role -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="role" name="role" required>
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <label for="role">Role</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <!-- Status -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                            <label for="status">Status</label>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <!-- Password -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <!-- Konfirmasi Password -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                            <label for="password_confirmation">Konfirmasi Password</label>
                        </div>
                      </div>
                    </div>
                `;
                }
            });
        });
    </script>

@endsection
