@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Persyaratan')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-body p-7">
                    <div id="quill-editor" style="height: 100%;">
                        {!! $data->isi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const quill = new Quill('#quill-editor', {
                readOnly: true,
            });
        });
    </script>
@endsection
