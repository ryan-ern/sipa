@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Beranda')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body p-7">
                    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel"
                        data-bs-interval="5000">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"
                                aria-label="Slide 4"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4"
                                aria-label="Slide 5"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5"
                                aria-label="Slide 6"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="6"
                                aria-label="Slide 7"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="7"
                                aria-label="Slide 8"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="8"
                                aria-label="Slide 9"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="9"
                                aria-label="Slide 10"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="10"
                                aria-label="Slide 11"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="11"
                                aria-label="Slide 12"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/assets/profil/anak.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Selamat Datang di UPTD PSSA Harapan Bangsa Dinas Sosial Provinsi Lampung
                                    </h5>
                                    <p>Sasaran UPTD PSAA Harapan Bangsa dalam pelayanan, pembinaan dan rehabilitasi
                                        pelayanan sosial asuhan anak meliputi anak yatim, piatu, yatim piatu, dan anak dari
                                        keluarga yang tidak mampu usia SD, SLTP, dan SLTA.

                                        Alamat: jl.Lettu Rohani No. 6 Desa Kedaton Kecamatan Kalianda
                                        Kabupaten Lampung Selatan</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/Gerbang.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Gerbang Depan</h5>
                                    <p>Sebagai simbol keamanan dan ketertiban, memastikan lingkungan yang aman bagi siswa
                                        dan pengunjung.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/Kantor.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Kantor</h5>
                                    <p>Sebagai tempat pusat administrasi dan layanan bagi siswa serta tenaga pengajar</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/Asrama1.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Asrama 1</h5>
                                    <p>Tempat tinggal yang nyaman dan bersih, menciptakan suasana kekeluargaan bagi siswa
                                        dalam menjalani kehidupan sehari-hari.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/Asrama2.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Asrama 2</h5>
                                    <p>Tempat tinggal yang nyaman dan bersih, menciptakan suasana kekeluargaan bagi siswa
                                        dalam menjalani kehidupan sehari-hari.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/aula.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Aula</h5>
                                    <p>Ruang serbaguna yang digunakan untuk berbagai kegiatan seperti seminar, pertemuan,
                                        dan acara keagamaan maupun kebudayaan.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/Lapangan.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Lapangan</h5>
                                    <p>Area terbuka untuk olahraga dan aktivitas fisik guna menunjang kesehatan dan
                                        kebugaran siswa.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/RuangBelajar.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Ruang Belajar</h5>
                                    <p>Didesain khusus untuk menciptakan lingkungan belajar yang kondusif, mendukung proses
                                        pendidikan yang efektif.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/Dapur.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Dapur</h5>
                                    <p>Tempat penyediaan makanan dengan standar kebersihan, memastikan kebutuhan gizi siswa
                                        terpenuhi.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/Garasi_Parkiran.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Garasi</h5>
                                    <p>Area penyimpanan kendaraan operasional untuk mendukung mobilitas dan kelancaran
                                        aktivitas harian.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/RumahDinas1.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Rumah Dinas</h5>
                                    <p>Hunian bagi staf dan tenaga pengajar, memastikan kenyamanan bagi mereka yang bertugas
                                        di lingkungan UPTD PSA Harapan Bangsa.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/profil/Musholla.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Mushola</h5>
                                    <p>Tempat ibadah yang nyaman dan bersih, mendukung pembinaan spiritual serta kegiatan
                                        keagamaan siswa.</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
