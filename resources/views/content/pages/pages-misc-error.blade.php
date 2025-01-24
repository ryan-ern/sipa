@extends('layouts/blankLayout')

@section('title', 'Error - Pages')

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
@endsection


@section('content')
    <!-- Error -->
    <div class="misc-wrapper">
        <h1 class="mb-2 mx-2" style="font-size: 6rem;line-height: 6rem;">404</h1>
        <h4 class="mb-2">Halaman Tidak Ditemukan 🙄</h4>
        <p class="mb-10 mx-2">Kamu sepertinya berada di jalan yang salah</p>
        <div>
            <a href="{{ Auth::check() ? (Auth::user()->role == 'admin' ? url('/dashboard') : url('/pages/kondisi-anak')) : url('/') }}"
                class="btn btn-primary text-center mb-7">
                <i class="ri-home-4-line me-2"></i>Yuk kembali ke jalan yang benar
            </a>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="misc-tree"
                class="img-fluid misc-object d-none d-lg-inline-block">
            <img src="{{ asset('assets/img/illustrations/misc-mask-light.png') }}" alt="misc-error"
                class="misc-bg d-none d-lg-inline-block z-n1" height="172">
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('assets/img/illustrations/404.png') }}" alt="misc-error" class="misc-model img-fluid z-1"
                    width="780">
            </div>
        </div>
    </div>
    <!-- /Error -->
@endsection
