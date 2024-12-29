@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';

@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-6">
        <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20])</span>
            <span class="app-brand-text demo menu-text fw-semibold ms-1">{{ config('variables.templateName') }}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="ri-close-fill align-middle"></i>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="ri-menu-fill ri-24px"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    {{-- <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="ri-search-line ri-22px me-1_5"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search..."
                aria-label="Search...">
        </div>
    </div>
    <!-- /Search --> --}}
    <ul class="navbar-nav flex-row align-items-center ms-auto">

        <!-- Place this tag where you want the button to render. -->
        <li class="nav-item lh-1" id="greeting">
            <!-- Greeting text will be updated dynamically -->
        </li>
        {{-- <li class="nav-item lh-1 me-4">
            <a href="javascript:void(0);" class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-notification-4-line ri-22px"></i>
                <span class="badge bg-danger rounded-pill ms-1 small">4</span>
            </a>
        </li> --}}

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown btn btn-primary ms-3 ">
            <a class="nav-link dropdown-toggle show-arrow p-0 text-white" href="javascript:void(0);"
                data-bs-toggle="dropdown">
                {{ Auth::user()->nama_lengkap }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <i class="ri-user-3-line ri-22px me-2"></i>
                        <span class="align-middle">Profil Saya</span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.submit();">
                        @csrf
                        <a class="dropdown-item text-danger" href="javascript:void(0);">
                            <i class="ri-logout-box-r-line me-2 ri-22px"></i>
                            <span class="align-middle">Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
