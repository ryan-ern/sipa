@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')
    <div class="d-none">
        <a href="https://www.freepik.com/free-psd/diverse-people-3d-composition_53059497.htm" target="_blank"
            rel="noopener noreferrer">
            Image by Freepik
        </a>
        <a
            href="https://www.freepik.com/free-psd/3d-rendering-afro-girl-classroom_77004596.htm#fromView=search&page=1&position=32&uuid=ea9b584c-03e6-433a-b2e4-8e04778b0db5&new_detail=true">Image
            by freepik</a>
    </div>
    <div class="row gy-6">
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex justify-content-end">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-floating form-floating-outline">
                        <input type="month" class="form-control" id="bulan" name="bulan"
                            value="{{ request('bulan', now()->format('Y-m')) }}" max="{{ now()->format('Y-m') }}"
                            onchange="this.form.submit()" />
                        <label for="bulan">Bulan</label>
                    </div>
                </div>
            </div>
        </form>

        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Pendaftar Berlangsung</h5>
                    <h3 class="text-primary mb-0">{{ $countPendaftaran }}</h3>
                </div>
                <img src="{{ asset('assets/img/illustrations/daftar.jpg') }}"
                    class="position-absolute bottom-0 end-0 me-3" width="100" alt="view sales">
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <img src="{{ asset('assets/img/illustrations/pass.jpg') }}"
                    class="position-absolute bottom-0 start-0 ms-5" width="100" alt="view sales">
                <div class="card-body text-nowrap text-end">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Lupa Password</h5>
                    <h3 class="text-primary mb-0">{{ $countForgotPass }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Data Anak Aktif</h5>
                    <h3 class="text-primary mb-0">{{ $countAnakAktif }}</h3>
                </div>
                <img src="{{ asset('assets/img/illustrations/anak_aktif.png') }}"
                    class="position-absolute bottom-0 end-0 me-3" width="120" alt="view sales">
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <img src="{{ asset('assets/img/illustrations/yatimpiatu.png') }}"
                    class="position-absolute bottom-0 start-0 ms-5" width="70" alt="view sales">
                <div class="card-body text-nowrap text-end">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Anak Yatim Piatu</h5>
                    <h3 class="text-primary mb-0">{{ $countAnakYatimPiatu }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Alumni Lulus</h5>
                    <h3 class="text-primary mb-0">{{ $countAnakLulus }}</h3>
                </div>
                <img src="{{ asset('assets/img/illustrations/lulus.png') }}" class="position-absolute bottom-0 end-0 me-5 "
                    width="100" alt="view sales">
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <img src="{{ asset('assets/img/illustrations/nakal.png') }}" class="position-absolute bottom-0 start-0 ms-5"
                    width="80" alt="view sales">
                <div class="card-body text-nowrap text-end">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Alumni Keluar</h5>
                    <h3 class="text-primary mb-0">{{ $countAnakBermasalah }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Anak Yatim</h5>
                    <h3 class="text-primary mb-0">{{ $countAnakYatim }}</h3>
                </div>
                <img src="{{ asset('assets/img/illustrations/yatim.png') }}" class="position-absolute bottom-0 end-0 me-5"
                    width="83" alt="view sales">
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <img src="{{ asset('assets/img/illustrations/piatu.png') }}"
                    class="position-absolute bottom-0 start-0 ms-5" width="90" alt="view sales">
                <div class="card-body text-nowrap text-end">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Anak Piatu</h5>
                    <h3 class="text-primary mb-0">{{ $countAnakPiatu }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Data Donasi</h5>
                    <h3 class="text-primary mb-0">{{ $countDataDonasi }}</h3>
                </div>
                <img src="{{ asset('assets/img/illustrations/donasi.png') }}" class="position-absolute bottom-0 end-0 me-5"
                    width="150" alt="view sales">
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <img src="{{ asset('assets/img/illustrations/artikel.png') }}"
                    class="position-absolute bottom-0 start-0 ms-5" width="130" alt="view sales">
                <div class="card-body text-nowrap text-end">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Artikel Informasi</h5>
                    <h3 class="text-primary mb-0">{{ $countDataArtikel }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Anak Laki-laki</h5>
                    <h3 class="text-primary mb-0">{{ $countAnakLaki }}</h3>
                </div>
                <img src="{{ asset('assets/img/illustrations/laki.png') }}" class="position-absolute bottom-0 end-0 me-5"
                    width="83" alt="view sales">
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <img src="{{ asset('assets/img/illustrations/perempuan.png') }}"
                    class="position-absolute bottom-0 start-0 ms-5" width="83" alt="view sales">
                <div class="card-body text-nowrap text-end">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Jumlah Anak Perempuan</h5>
                    <h3 class="text-primary mb-0">{{ $countAnakPerempuan }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
