@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Kegiatan')

@section('content')
        <div class="row gy-6">
          <div class="col-md-12 col-lg-12 mb-4">
              <div class="card">
                  <div class="card-body p-7">
                    <div id='calendar'></div>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="ModalLabel">
        <div class="modal-dialog">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
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
                events: "{{ url('/data-kegiatan/events') }}",
                editable: true,
                selectable: true,
                locale: 'id',
                eventContent: function (info) {
                  const container = document.createElement('div');
                  container.classList.add('d-flex', 'align-items-center');

                  const titleElement = document.createElement('span');
                  titleElement.textContent = info.event.title;

                  const descElement = document.createElement('span');
                  descElement.classList.add('ms-2');
                  descElement.textContent = `~ ${info.event.extendedProps.desc}`;

                  // Set tooltip hanya jika ada deskripsi
                  if (info.event.extendedProps.desc) {
                      descElement.setAttribute('data-bs-toggle', 'tooltip');
                      descElement.setAttribute('data-bs-placement', 'top');
                      descElement.setAttribute('title', info.event.extendedProps.desc);

                      container.appendChild(titleElement);
                      container.appendChild(descElement);

                      // Inisialisasi tooltip dengan Bootstrap
                      setTimeout(() => {
                          new bootstrap.Tooltip(descElement, {
                              trigger: 'hover',
                              container: 'body'
                          });
                      }, 0);
                  } else {
                      container.appendChild(titleElement);
                  }

                  return { domNodes: [container] };
                },

                eventClick: function(info) {
                    const eventId = info.event.id;
                        modalTitle.textContent = "Lihat Kegiatan";
                        modalContent.innerHTML = `
                        <div class="mb-3">
                            <label for="kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" id="kegiatan" name="kegiatan" class="form-control" value="${info.event.title}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" id="waktu_mulai" name="waktu_mulai" class="form-control" value="${formatDateToDatetimeLocal(info.event.start)}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="datetime-local" id="waktu_selesai" name="waktu_selesai" class="form-control" value="${formatDateToDatetimeLocal(info.event.end)}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" readonly>${info.event.extendedProps.desc || ''}</textarea>
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
