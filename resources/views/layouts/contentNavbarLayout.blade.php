@extends('layouts/commonMaster')

@php
    /* Display elements */
    $contentNavbar = true;
    $containerNav = $containerNav ?? 'container-xxl';
    $isNavbar = $isNavbar ?? true;
    $isMenu = $isMenu ?? true;
    $isFlex = $isFlex ?? false;
    $isFooter = $isFooter ?? true;

    /* HTML Classes */
    $navbarDetached = 'navbar-detached';

    /* Content classes */
    $container = $container ?? 'container-xxl';

@endphp

@section('layoutContent')
    <div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
        <div class="layout-container">

            @if ($isMenu)
                @include('layouts/sections/menu/verticalMenu')
            @endif


            <!-- Layout page -->
            <div class="layout-page">
                <!-- BEGIN: Navbar-->
                @if ($isNavbar && Auth::check())
                    @include('layouts/sections/navbar/navbar')
                @else
                    <nav class="navbar navbar-expand-lg bg-white">
                        <div class="container">
                            <!-- Brand -->
                                <a href="{{ url('/') }}" class="app-brand-link gap-3 me-10 p-2 rounded">
                                    <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 500, 'withbg' => 'fill: #fff;'])</span>
                                    <span
                                        class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
                                </a>

                            <!-- Toggler Button -->
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <!-- Navbar Links -->
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                              <ul class="navbar-nav mb-2 mb-lg-0">
                                  <li class="nav-item">
                                      <a class="nav-link me-2 px-3 {{ request()->routeIs('beranda-user') ? 'active btn btn-primary' : '' }}"
                                         href="{{ route('beranda-user') }}">Beranda</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link me-2 px-3 {{ request()->routeIs('kegiatan-user') ? 'active btn btn-primary' : '' }}"
                                         href="{{ route('kegiatan-user') }}">Kegiatan</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link me-2 px-3 {{ request()->routeIs('syarat-user') ? 'active btn btn-primary' : '' }}"
                                         href="{{ route('syarat-user') }}">Persyaratan</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link me-2 px-3 {{ request()->routeIs('artikel-user') ? 'active btn btn-primary' : '' }}"
                                         href="{{ route('artikel-user') }}">Artikel Informasi</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link me-2 px-3 {{ request()->routeIs('hubungi-user') ? 'active btn btn-primary' : '' }}"
                                         href="{{ route('hubungi-user') }}">Hubungi</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link me-2 px-3 {{ request()->routeIs('login') ? 'active btn btn-primary' : '' }}"
                                         href="{{ route('login') }}">Login</a>
                                  </li>
                              </ul>
                          </div>

                        </div>
                    </nav>
                @endif
                <!-- END: Navbar-->


                <!-- Content wrapper -->
                @if (Auth::check())
                <div class="content-wrapper">
                @else
                    <div class="content-wrapper-costume">
                @endif

                    <!-- Content -->
                    @if ($isFlex)
                        <div class="{{ $container }} d-flex align-items-stretch flex-grow-1 p-0">
                        @else
                            <div class="{{ $container }} flex-grow-1 container-p-y">
                    @endif

                    @yield('content')

                </div>
                <!-- / Content -->

                <!-- Footer -->
                @if ($isFooter)
                    @include('layouts/sections/footer/footer')
                @endif
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    @if ($isMenu)
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    @endif
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
@endsection
