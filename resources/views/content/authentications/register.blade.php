@extends('layouts/blankLayout')

@section('title', 'Register')

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
            <!-- Register Card -->
            <div class="card p-5">
                <!-- Logo -->
                <div class="app-brand justify-content-center">
                    <a href="{{ url('/') }}" class="app-brand-link gap-3">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo" width="100">
                        </span>
                    </a>
                </div>
                <!-- /Logo -->
                <div class="card-body mt-2">
                    <h4 class="mb-3 text-center">Buat Akun Baru</h4>
                    <form id="formAuthentication" action="{{ route('register.store') }}" method="POST">
                        @csrf
                        <!-- Username -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="Isi Username anda untuk login"
                                value="{{ old('username') }}" autofocus>
                            <label for="username">Username</label>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- nik --}}
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="number" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" placeholder="Isi NIK untuk kepemilikan akun" value="{{ old('nik') }}"
                                autofocus>
                            <label for="nik">NIK</label>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap"
                                value="{{ old('nama_lengkap') }}">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="tel" class="form-control @error('no_tel') is-invalid @enderror" id="no_tel"
                                name="no_tel" placeholder="Nomor Telepon" value="{{ old('no_tel') }}" required>
                            <label for="no_tel">Nomor Telepon</label>
                            @error('no_tel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Jenis Kelamin -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                name="jenis_kelamin">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select @error('sebagai') is-invalid @enderror" id="sebagai"
                                name="sebagai">
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="ortu" {{ old('sebagai') == 'ortu' ? 'selected' : '' }}>Orang Tua</option>
                                <option value="wali" {{ old('sebagai') == 'wali' ? 'selected' : '' }}>Wali</option>
                            </select>
                            <label for="sebagai">Status</label>
                            @error('sebagai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="form-floating form-floating-outline mb-4">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                placeholder="Alamat Anda">{{ old('alamat') }}</textarea>
                            <label for="alamat">Alamat</label>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Password">
                            <label for="password">Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <button class="btn btn-primary d-grid w-100" type="submit">Daftar</button>
                    </form>

                    <p class="text-center mt-3">
                        Sudah punya akun? <a href="{{ url('auth/login') }}">Login disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
