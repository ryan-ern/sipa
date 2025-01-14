@extends('layouts/contentNavbarLayout')

@section('title', 'Data Kegiatan')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <div class="divider text-start">
                        <div class="divider-text ms-3 fs-5">Kalender Kegiatan</div>
                    </div>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gy-6 mt-3">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body p-7">
                    <button class="btn btn-primary float-end me-3 mt-3" data-bs-toggle="modal"
                        data-bs-target="#dynamicModal" data-modal-type="tambah">
                        Tambah Data
                    </button>
                    <div class="divider text-start">
                        <div class="divider-text ms-3 fs-5">Data Kegiatan</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Kegiatan</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Waktu Mulai</th>
                                    <th scope="col">Waktu Selesai</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $kegiatan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $kegiatan->kegiatan }}</td>
                                        <td class="truncate">{{ $kegiatan->keterangan }}</td>
                                        <td class="text-truncate">{{ $kegiatan->waktu_mulai }}</td>
                                        <td class="text-truncate">{{ $kegiatan->waktu_selesai }}</td>
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
                                                            data-id="{{ $kegiatan->id }}"
                                                            data-kegiatan="{{ $kegiatan->kegiatan }}"
                                                            data-keterangan="{{ $kegiatan->keterangan }}"
                                                            data-waktu_mulai="{{ $kegiatan->waktu_mulai }}"
                                                            data-waktu_selesai="{{ $kegiatan->waktu_selesai }}">
                                                            <i class="ri-file-edit-line me-1"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#dynamicModal" data-modal-type="delete"
                                                            data-id="{{ $kegiatan->id }}"
                                                            data-kegiatan="{{ $kegiatan->kegiatan }}">
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
@endsection

@section('page-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dynamicModal = document.getElementById('dynamicModal');
            const modalTitle = dynamicModal.querySelector('.modal-title');
            const modalContent = document.getElementById('modalContent');
            const modalForm = document.getElementById('dynamicModalForm');
            const calendarEl = document.getElementById('calendar');

            function formatDateToDatetimeLocal(date) {
                const d = new Date(date);
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                const hours = String(d.getHours()).padStart(2, '0');
                const minutes = String(d.getMinutes()).padStart(2, '0');
                return `${year}-${month}-${day}T${hours}:${minutes}`;
            }

            dynamicModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Tombol yang memicu modal
                const modalType = button.getAttribute('data-modal-type'); // Tipe modal (tambah/edit/delete)
                const id = button.getAttribute('data-id') || null;
                const kegiatan = button.getAttribute('data-kegiatan') || '';
                const keterangan = button.getAttribute('data-keterangan') || '';
                const waktu_mulai = button.getAttribute('data-waktu_mulai') || '';
                const waktu_selesai = button.getAttribute('data-waktu_selesai') || '';

                if (modalType === 'tambah') {
                    modalTitle.textContent = 'Tambah Data';
                    modalForm.action = "{{ route('data-kegiatan.store') }}";
                    modalForm.method = "POST";
                    modalContent.innerHTML = `
                @csrf
                <div class="mb-3">
                    <label for="kegiatan" class="form-label">Nama Kegiatan</label>
                    <input type="text" id="kegiatan" name="kegiatan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                    <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                    <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" required></textarea>
                </div>
            `;
                } else if (modalType === 'edit') {
                    modalTitle.textContent = 'Edit Data';
                    modalForm.action = `{{ url('/pages/data-kegiatan') }}/${id}`;
                    modalForm.method = "POST";
                    modalContent.innerHTML = `
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="kegiatan" class="form-label">Nama Kegiatan</label>
                    <input type="text" id="kegiatan" name="kegiatan" class="form-control" value="${kegiatan}" required>
                </div>
                <div class="mb-3">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                    <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control" value="${formatDateToDatetimeLocal(waktu_mulai)}" required>
                </div>
                <div class="mb-3">
                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                    <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control" value="${formatDateToDatetimeLocal(waktu_selesai)}" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" required>${keterangan}</textarea>
                </div>
            `;
                } else if (modalType === 'delete') {
                    modalTitle.textContent = 'Hapus Data';
                    modalForm.action = `{{ url('/pages/data-kegiatan') }}/${id}`;
                    modalForm.method = "POST";
                    modalContent.innerHTML = `
                @csrf
                @method('DELETE')
                <p>Apakah Anda yakin ingin menghapus kegiatan <strong>${kegiatan}</strong>?</p>
                <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
            `;
                }
            });

            const calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next todayBtn',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                views: {
                    dayGridMonth: {
                        buttonText: "Perbulan"
                    },
                    timeGridWeek: {
                        buttonText: "Perminggu"
                    },
                    timeGridDay: {
                        buttonText: "Perhari"
                    }
                },
                customButtons: {
                    todayBtn: {
                        text: "Hari Ini",
                        click: function() {
                            calendar.gotoDate(new Date());
                        }
                    }
                },
                initialView: 'dayGridMonth',
                events: "{{ url('/pages/data-kegiatan/events') }}",
                editable: true,
                selectable: true,
                locale: 'id',
                eventContent: function(info) {
                    const tooltipContent = `
                      <div>
                          <strong>${info.event.title}</strong><br>
                          ${info.event.extendedProps.desc}
                      </div>`;

                    const container = document.createElement('div');
                    container.classList.add('d-flex', 'align-items-center');

                    const titleElement = document.createElement('span');
                    titleElement.textContent = info.event.title;

                    const descElement = document.createElement('span');
                    descElement.classList.add('ms-2');
                    descElement.textContent = `~ ${info.event.extendedProps.desc}`;

                    // Set tooltip
                    descElement.setAttribute('data-bs-toggle', 'tooltip');
                    descElement.setAttribute('data-bs-placement', 'top');
                    descElement.setAttribute('title', info.event.extendedProps.desc);

                    container.appendChild(titleElement);
                    container.appendChild(descElement);

                    // Initialize Bootstrap tooltip
                    setTimeout(() => {
                        new bootstrap.Tooltip(descElement);
                    }, 0);

                    return {
                        domNodes: [container]
                    };
                },

                // Tambahkan Kegiatan Baru
                select: function(info) {
                    const startDate = formatDateToDatetimeLocal(info.start);
                    const endDate = formatDateToDatetimeLocal(info.end);
                    modalTitle.textContent = "Tambah Kegiatan";
                    modalForm.action = "{{ route('data-kegiatan.store') }}";
                    modalForm.method = "POST";
                    modalContent.innerHTML = `
                    @csrf
                    <div class="mb-3">
                        <label for="kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" id="kegiatan" name="kegiatan" class="form-control" placeholder="Nama Kegiatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control" value="${startDate}" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control" value="${endDate}" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3"  required placeholder="Keterangan"></textarea>
                    </div>
                `;
                    const modal = new bootstrap.Modal(dynamicModal);
                    modal.show();
                },
                // Klik pada Event untuk Edit atau Delete
                eventClick: function(info) {
                    const eventId = info.event.id;
                    console.log(info.event.extendedProps.desc);
                    if (confirm('Apakah Anda ingin mengedit kegiatan ini?')) {
                        modalTitle.textContent = "Edit Kegiatan";
                        modalForm.action = `{{ url('/pages/data-kegiatan') }}/${eventId}`;
                        modalForm.method = "POST";
                        modalContent.innerHTML = `
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" id="kegiatan" name="kegiatan" class="form-control" value="${info.event.title}" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control" value="${formatDateToDatetimeLocal(info.event.start)}" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control" value="${formatDateToDatetimeLocal(info.event.end)}" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3">${info.event.extendedProps.desc || ''}</textarea>
                        </div>
                    `;
                        const modal = new bootstrap.Modal(dynamicModal);
                        modal.show();
                    } else {
                        modalTitle.textContent = "Hapus Kegiatan";
                        modalForm.action = `{{ url('/pages/data-kegiatan') }}/${eventId}`;
                        modalForm.method = "POST";
                        modalContent.innerHTML = `
                        @csrf
                        @method('DELETE')
                        <p>Apakah Anda yakin ingin menghapus kegiatan <strong>${info.event.title}</strong>?</p>
                        <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
                    `;
                        const modal = new bootstrap.Modal(dynamicModal);
                        modal.show();
                    }
                },

                // Drag dan Drop Event untuk Update
                eventDrop: function(info) {
                    modalTitle.textContent = "Perbarui Jadwal Kegiatan";
                    modalForm.action = `{{ url('/pages/data-kegiatan') }}/${info.event.id}`;
                    modalForm.method = "POST";
                    const startDate = formatDateToDatetimeLocal(info.event.start);
                    const endDate = formatDateToDatetimeLocal(info.event.end);
                    modalContent.innerHTML = `
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" id="kegiatan" name="kegiatan" class="form-control" value="${info.event.title}" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control" value="${startDate}" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control" value="${endDate}" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="3">${info.event.extendedProps.desc || ''}</textarea>
                    </div>
                `;
                    const modal = new bootstrap.Modal(dynamicModal);
                    modal.show();
                },
            });
            calendar.render();
        });
    </script>

@endsection
