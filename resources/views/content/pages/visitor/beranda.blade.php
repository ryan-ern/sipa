@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Beranda')

@section('page-style')
    <style>
        .carousel-item {
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            animation: pan-image 25s linear infinite;
            border-radius: 10px;
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            bottom: 20%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            max-width: 600px;
        }

        .carousel-caption h2 {
            font-size: 30px;
            font-weight: bold;
        }

        .carousel-caption p {
            font-size: 20px;
        }



        @media screen and (max-width: 768px) {
            .carousel-item {
                height: 150vh;
            }

            .carousel-item img {
                width: auto !important;
            }

            .carousel-caption {
                display: block !important;
                bottom: 10%;
                width: 90%;
            }

            .carousel-caption h2 {
                font-size: 25px;
            }

            .carousel-caption p {
                font-size: 25px;
            }

            @keyframes pan-image {
                0% {
                    transform: translateX(-30%);
                }

                100% {
                    transform: translateX(-100%);
                }
            }
        }
    </style>
@endsection

@section('content')
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-indicators">
            @for ($i = 0; $i < 12; $i++)
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $i }}"
                    class="{{ $i === 0 ? 'active' : '' }}" aria-label="Slide {{ $i + 1 }}"></button>
            @endfor
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/assets/profil/anak.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Selamat Datang di UPTD PSSA Harapan Bangsa Dinas Sosial Provinsi Lampung
                    </h2>
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
                    <h2>Gerbang Depan</h2>
                    <p>Sebagai simbol keamanan dan ketertiban, memastikan lingkungan yang aman bagi siswa
                        dan pengunjung.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/Kantor.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Kantor</h2>
                    <p>Sebagai tempat pusat administrasi dan layanan bagi siswa serta tenaga pengajar</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/Asrama1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Asrama 1</h2>
                    <p>Tempat tinggal yang nyaman dan bersih, menciptakan suasana kekeluargaan bagi siswa
                        dalam menjalani kehidupan sehari-hari.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/Asrama2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Asrama 2</h2>
                    <p>Tempat tinggal yang nyaman dan bersih, menciptakan suasana kekeluargaan bagi siswa
                        dalam menjalani kehidupan sehari-hari.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/aula.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Aula</h2>
                    <p>Ruang serbaguna yang digunakan untuk berbagai kegiatan seperti seminar, pertemuan,
                        dan acara keagamaan maupun kebudayaan.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/Lapangan.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Lapangan</h2>
                    <p>Area terbuka untuk olahraga dan aktivitas fisik guna menunjang kesehatan dan
                        kebugaran siswa.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/RuangBelajar.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Ruang Belajar</h2>
                    <p>Didesain khusus untuk menciptakan lingkungan belajar yang kondusif, mendukung proses
                        pendidikan yang efektif.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/Dapur.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Dapur</h2>
                    <p>Tempat penyediaan makanan dengan standar kebersihan, memastikan kebutuhan gizi siswa
                        terpenuhi.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/Garasi_Parkiran.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Garasi</h2>
                    <p>Area penyimpanan kendaraan operasional untuk mendukung mobilitas dan kelancaran
                        aktivitas harian.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/RumahDinas1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Rumah Dinas</h2>
                    <p>Hunian bagi staf dan tenaga pengajar, memastikan kenyamanan bagi mereka yang bertugas
                        di lingkungan UPTD PSA Harapan Bangsa.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/assets/profil/Musholla.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Mushola</h2>
                    <p>Tempat ibadah yang nyaman dan bersih, mendukung pembinaan spiritual serta kegiatan
                        keagamaan siswa.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@endsection
