@extends('layouts/blankLayout')

@section('title', 'Forgot Password Basic - Pages')

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6 mx-4">

                <!-- Logo -->
                <div class="card p-7">
                    <!-- Forgot Password -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="{{ url('/') }}" class="app-brand-link gap-3">
                            <span class="app-brand-logo demo">
                              <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo" width="100">
                            </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-1">
                        <h4 class="mb-1">Lupa Password? 🔒</h4>
                        <p class="mb-5 text-capitalize">masukkan username anda dan kami akan mengirimkan password baru untuk
                            anda</p>
                        <form id="formAuthentication" class="mb-5" action="{{ route('forgot.update') }}" method="POST">
                          @csrf
                          @method('PUT')
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Masukkan username terdaftar" autofocus>
                                <label>Username</label>
                            </div>
                            <button type="submit" class="btn btn-primary d-grid w-100 mb-5">Kirim</button>
                        </form>
                        <div class="text-center">
                            <a href="{{ url('auth/login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="ri-arrow-left-s-line ri-20px me-1_5"></i>
                                Kembali ke halaman login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
                <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree"
                    class="authentication-image-object-left d-none d-lg-block">
                <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block" height="172" alt="triangle-bg">
                <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree"
                    class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>
@endsection
