@extends('layouts/contentNavbarLayout')

@section('title', 'Kondisi Anak')

@section('content')
    <div class="row gy-6 mb-5">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('kondisi-anak.get') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="anak" class="form-label">Pilih Anak Anda</label>
                            <select class="form-select" id="anak" name="id" onchange="this.form.submit()">
                              <option selected disabled value="">Pilih Anak</option>
                              @foreach ($anak as $item)
                                  <option value="{{ $item->id }}"
                                      class="{{ $item->status == 'aktif' ? 'bg-success text-white' : 'bg-info text-white' }}"
                                      {{ $info && $info->id === $item->id ? 'selected' : '' }}
                                      {{$item->status != 'aktif' ? 'disabled' : ''}}>
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
    @if($info->status == 'aktif')
      <div class="row gy-6">
          <div class="col-md-6 col-sm-12 mb-4">
              <div class="card">
                  <div class="card-body">
                      {{ $riwayat ? $riwayat->created_at->translatedFormat('l, d-m-Y') : now()->translatedFormat('l, d-m-Y') }}
                  </div>
              </div>
          </div>
          <div class="col-md-6 col-sm-12">
              <div class="card">
                  <div class="card-body text-capitalize">
                      Anak anda
                      {{ $riwayat ? ' ' . $riwayat->status : 'Dalam Keadaan Baik' }}
                  </div>
              </div>
          </div>
      </div>

      @if ($riwayat)
      <div class="row gy-6">
          <div class="col-md-12 col-sm-12 mb-4">
              <div class="card">
                  @if($riwayat->fp_riwayat)
                      <img src="{{ asset('storage/' . $riwayat->fp_riwayat) }}"
                          alt="Gambar Riwayat"
                            class="card-img-top img-fluid"
                            style="height: 200px; object-fit: cover;"
                          data-bs-toggle="modal"
                          data-bs-target="#imageModal{{ $riwayat->fn_riwayat }}">
                          <marquee class="text-info mt-2">Klik gambar untuk melihat lebih jelas</marquee>
                  @endif
                  <div class="card-body text-capitalize text-wrap">
                      {{ $riwayat ? $riwayat->keterangan : '-' }}
                  </div>
              </div>
          </div>
      </div>
      @endif
    @endif

    @if($info->status == 'aktif')
    <div class="row">
        <div class="col md-12 sm-12 mb-4">
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
                                <th scope="col">File Pendukung</th>
                                <th scope="col">Tanggal</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $riwayatAnak)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $riwayatAnak->biodata->nama }}</td>
                                        <td class="text-capitalize">{{ $riwayatAnak->status }}</td>
                                        <td class="text-capitalize truncate">{{ $riwayatAnak->keterangan }}</td>
                                        <td>
                                          @if(!empty($riwayatAnak->fp_riwayat))
                                          <img src="{{ asset('storage/' . $riwayatAnak->fp_riwayat) }}"
                                          alt="Gambar Riwayat"
                                          width="100"
                                          class="rounded img-thumbnail"
                                          data-bs-toggle="modal"
                                          data-bs-target="#imageModal{{ $riwayatAnak->fn_riwayat }}">
                                          @else
                                          -
                                          @endif
                                      </td>
                                        <td class="text-capitalize text-truncate">
                                            {{ $riwayatAnak->updated_at->translatedFormat('l, d-m-Y H:i') }}
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
    @endif
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
