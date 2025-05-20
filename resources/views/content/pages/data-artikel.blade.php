@extends('layouts/contentNavbarLayout')

@section('title', 'Data Informasi')

@section('page-style')
    <style>
        .buttons-pdf {
            display: none;
        }
    </style>
@endsection
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
                        <button class="btn btn-primary float-end me-3 mt-3" data-bs-toggle="modal"
                            data-bs-target="#dynamicModal" data-modal-type="tambah">
                            Tambah Data
                        </button>
                        <div class="divider text-start">
                            <div class="divider-text ms-3 fs-5">Artikel Informasi</div>
                        </div>
                        <div class="table-responsive text-start">
                            <table class="table table-sm table-bordered dataTable" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">jenis</th>
                                        <th scope="col">Cover</th>
                                        <th scope="col">Isi</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Berlaku/ Dilaksanakan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $artikel)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-capitalize">{{ $artikel->judul }}</td>
                                            <td class="truncate">{{ $artikel->jenis }}</td>
                                            <td><img src="{{ asset('storage/' . $artikel->fp_cover) }}" alt=""
                                                    width="100" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal{{ $artikel->id }}"></td>
                                            <td class="truncate">{!! strip_tags($artikel->isi) !!}</td>
                                            <td class="text-truncate text-start">
                                                {{ $artikel->created_at->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="truncate">{{ $artikel->tgl_berlaku }}</td>
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
                                                                data-id="{{ $artikel->id }}"
                                                                data-judul="{{ $artikel->judul }}"
                                                                data-jenis="{{ $artikel->jenis }}"
                                                                data-tgl_berlaku="{{ $artikel->tgl_berlaku }}"
                                                                data-cover="{{ asset('storage/' . $artikel->fp_cover) }}"
                                                                data-isi="{{ $artikel->isi }}">
                                                                <i class="ri-file-edit-line me-1"></i> Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#dynamicModal" data-modal-type="delete"
                                                                data-id="{{ $artikel->id }}"
                                                                data-judul="{{ $artikel->judul }}">
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
            {{-- modal detail image --}}
            @foreach ($data as $artikel)
                @if (!empty($artikel->fp_cover))
                    <div class="modal fade" id="imageModal{{ $artikel->id }}" tabindex="-1"
                        aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/' . $artikel->fp_cover) }}" class="img-fluid rounded"
                                        alt="Gambar Artikel">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <!-- Modal Create, Update, Delete -->
            <div class="modal fade" id="dynamicModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ModalLabel">
                <div class="modal-dialog modal-xl">
                    <form id="dynamicModalForm" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
                    const artikelId = button.getAttribute('data-id');

                    if (modalType === 'edit') {
                        modalTitle.textContent = 'Edit Data';
                        modalForm.action = `/pages/data-informasi/${artikelId}`;
                        modalForm.method = 'POST';
                        modalForm.enctype = 'multipart/form-data';
                        modalContent.innerHTML = `
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                         <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" value="${button.getAttribute('data-judul')}" required>
                            <label for="judul">Judul</label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                         <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="tgl_berlaku" name="tgl_berlaku" placeholder="Tanggal Berlaku / Dilaksanakan" value="${button.getAttribute('data-tgl_berlaku')}" required>
                            <label for="tgl_berlaku">Tanggal Berlaku/ Dilaksanakan</label>
                          </div>
                        </div>

                        <div class="col-md-12 mb-3">
                           <div class="form-floating form-floating-outline">
                            <select class="form-select" id="jenis" name="jenis" required>
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="informasi" ${button.getAttribute('data-jenis') === 'informasi' ? 'selected' : ''}>Informasi</option>
                                <option value="artikel" ${button.getAttribute('data-jenis') === 'artikel' ? 'selected' : ''}>Artikel</option>
                            </select>
                            <label for="jenis">Jenis</label>
                          </div>
                        </div>
                      </div
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-floating form-floating-outline">
                            <input type="file" class="form-control" id="cover" name="fp_cover" placeholder="cover" accept="image/*">
                            <label for="cover">Cover</label>
                          </div>
                        </div>
                      </div>

                     <div class="row">
                        <div class="col-md-12 mb-3" id="form-article">
                            <label for="isi" class="form-label">Isi Artikel Informasi</label>
                            <div id="toolbar-container">
                                <span class="ql-formats">
                                    <select class="ql-font"></select>
                                    <select class="ql-size"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-color"></select>
                                    <select class="ql-background"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-script" value="sub"></button>
                                    <button class="ql-script" value="super"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-header" value="1"></button>
                                    <button class="ql-header" value="2"></button>
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-code-block"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-indent" value="-1"></button>
                                    <button class="ql-indent" value="+1"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-direction" value="rtl"></button>
                                    <select class="ql-align"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                    <button class="ql-formula"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                            </div>
                            <div id="quill-editor" style="height: 300px;">${button.getAttribute('data-isi')}</div>
                            <input type="hidden" id="isi" name="isi" required>
                          </div>
                      </div>
                `;
                    } else if (modalType === 'delete') {
                        modalTitle.textContent = 'Hapus Data';
                        modalForm.action = `/pages/data-informasi/${artikelId}`;
                        modalForm.method = 'POST';
                        modalContent.innerHTML = `
                    @csrf
                    @method('DELETE')
                    <p>Apakah Anda yakin ingin menghapus data <strong>${button.getAttribute('data-nama_lengkap')}</strong>?</p>
                    <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
                `;
                    } else {
                        modalTitle.textContent = 'Tambah Data';
                        modalForm.action = '/pages/data-informasi';
                        modalForm.method = 'POST';
                        modalForm.enctype = 'multipart/form-data';
                        modalContent.innerHTML = `
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" required>
                            <label for="judul">Judul</label>
                          </div>
                        </div>
                         <div class="col-md-6 mb-3">
                         <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="tgl_berlaku" name="tgl_berlaku" placeholder="Tanggal Berlaku / Dilaksanakan">
                            <label for="tgl_berlaku">Tanggal Berlaku/ Dilaksanakan</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-floating form-floating-outline">
                            <select class="form-select" id="jenis" name="jenis" required>
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="informasi">Informasi</option>
                                <option value="artikel">Artikel</option>
                            </select>
                            <label for="jenis">Jenis</label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-floating form-floating-outline">
                            <input type="file" class="form-control" id="cover" name="fp_cover" placeholder="cover" accept="image/png, image/jpg, image/jpeg" required>
                            <label for="cover">Cover</label>
                          </div>
                        </div>
                    </div>

                      <div class="row">
                        <div class="col-md-12 mb-3" id="form-article">
                            <label for="isi" class="form-label">Isi Artikel Informasi</label>
                            <div id="toolbar-container">
                                <span class="ql-formats">
                                    <select class="ql-font"></select>
                                    <select class="ql-size"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-color"></select>
                                    <select class="ql-background"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-script" value="sub"></button>
                                    <button class="ql-script" value="super"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-header" value="1"></button>
                                    <button class="ql-header" value="2"></button>
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-code-block"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-indent" value="-1"></button>
                                    <button class="ql-indent" value="+1"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-direction" value="rtl"></button>
                                    <select class="ql-align"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                    <button class="ql-formula"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                            </div>
                            <div id="quill-editor" style="height: 300px;"></div>
                            <input type="hidden" id="isi" name="isi" required>
                          </div>
                      </div>
                `;
                    }
                    const quill = new Quill('#quill-editor', {
                        theme: 'snow',
                        placeholder: 'Tulis isi artikel di sini...',
                        modules: {
                            syntax: true,
                            toolbar: '#toolbar-container'
                        }
                    });



                    modalForm.addEventListener('submit', function() {
                        const hiddenInput = modalForm.querySelector('input[name="isi"]');
                        if (quill) {
                            hiddenInput.value = quill.root.innerHTML;
                        }
                    });
                });
            });
        </script>
    @endsection
