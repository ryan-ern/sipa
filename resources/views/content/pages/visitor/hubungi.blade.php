@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Hubungi')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body p-7">
                  <h5>Lokasi Kami</h5>
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3969.906540077962!2d105.5936248106652!3d-5.7266006565765775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e410e2a5f1d7d97%3A0x5c45cfa3bcd8ad78!2sUPTD%20PELAYANAN%20SOSIAL%20ASUHAN%20ANAK%20HARAPAN%20BANGSA!5e0!3m2!1sid!2sid!4v1739328555142!5m2!1sid!2sid" width="600" height="590" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" ></iframe>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 mb-4">
            <div class="row mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-7">
                            <h5>Hubungi Kami</h5>
                            <p class="text-muted">jika ingin berdonasi hubungi Wa/ kontak dibawah ini</p>
                            <ul>
                                <li>
                                   Whatsapp : <a href="https://wa.me/+6283829751860 " target="_blank"> 083829751860 UPTD PSAA Harapan Bangsa </a>
                                </li>
                                <li>
                                   Instagram : <a href="https://www.instagram.com/uptd.psaa_harapanbangsa/" target="_blank"> uptd.psaa_harapanbangsa </a>

                                </li>
                                <li>
                                   Youtube : <a href="https://www.youtube.com/@kitaharapanbangsa2450" target="_blank"> KITA HARAPAN BANGSA ) </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-7">
                            <h5>Kirim Saran atau Pesan Anda</h5>
                            <form action="{{ route('data-saran.store') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Anda</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_tel" class="form-label">Nomor Telepon Anda</label>
                                    <input type="tel" class="form-control" id="no_tel" name="no_tel" placeholder="Nomor Telepon" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Keterangan" class="form-label">Pesan atau Saran</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Pesan atau Saran" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
