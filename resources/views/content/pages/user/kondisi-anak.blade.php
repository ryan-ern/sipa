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
                    Anak anda saat ini
                    {{ $riwayat ? ' ' . $riwayat->status : 'Dalam Keadaan Baik' }}
                </div>
            </div>
        </div>
    </div>
    @if ($riwayat)
        <div class="row gy-6">
            <div class="col-md-12 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body text-capitalize text-wrap">
                        {{ $riwayat ? $riwayat->keterangan : '-' }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col md-12 sm-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5>Informasi Data Anak</h5>
                    <form id="pendaftaranForm" action="{{ route('data-anak.update', $info->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
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
                                        placeholder="NIK Anak" value="{{ $info->nik }}" required>
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
                                        <option value="" disabled {{ !$info->status_anak ? 'selected' : '' }}>
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
                            <div class="col-md-12 mb-3">
                                <label for="alamat">Alamat Anak</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $info->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="reset" class="btn btn-danger me-5">Batal</button>
                                <button type="submit" id="sendData" class="btn btn-primary">Perbarui Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                                        <td class="text-capitalize text-truncate">
                                            {{ $riwayatAnak->updated_at->format('l, d-m-Y H:i') }}
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
@endsection
