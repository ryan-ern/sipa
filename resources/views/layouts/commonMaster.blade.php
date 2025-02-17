<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{ url('/') }}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | SIPA - UPTD PSAA Harapan Bangsa </title>
    <meta name="description"
        content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
    <meta name="keywords"
        content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical SEO -->
    <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />


    <!-- Include Styles -->
    @include('layouts/sections/styles')

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('layouts/sections/scriptsIncludes')
</head>

<body>

    <!-- Layout Content -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container">
        @if ($message = Session::get('error'))
            <div class="toast align-items-center text-bg-danger border-0 fade" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="5000">
                <div class="toast-header">
                    <i class="ri-error-warning-fill text-danger me-2"></i>
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-capitalize">
                    {{ $message }}
                </div>
            </div>
        @endif

        @if ($message = Session::get('info'))
            <div class="toast align-items-center text-bg-info border-0 fade" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="5000">
                <div class="toast-header">
                    <i class="ri-information-fill text-info me-2"></i>
                    <strong class="me-auto">Info</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-capitalize">
                    {{ $message }}
                </div>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="toast align-items-center text-bg-success border-0 fade" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="5000">
                <div class="toast-header">
                    <i class="ri-checkbox-circle-fill text-success me-2"></i>
                    <strong class="me-auto">Sukses</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-capitalize">
                    {{ $message }}
                </div>
            </div>
        @endif
    </div>


    @yield('layoutContent')
    <!--/ Layout Content -->


    <!-- Include Scripts -->
    @include('layouts/sections/scripts')

</body>

</html>
