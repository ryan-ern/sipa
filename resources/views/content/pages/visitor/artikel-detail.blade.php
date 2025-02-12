@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Artikel Detail')

@section('content')
    <div class="row gy-6">
        <div class="col-md-12 col-lg-12 mb-4">
          <div class="card">
            <img src="{{ asset('storage/' . $artikel->fp_cover) }}"
                 class="card-img-top img-fluid"
                 style="max-height: 400px; object-fit: cover;"
                 alt="{{ $artikel->judul }}">

            <div class="card-body">
                <h2 class="card-title text-center">{{ $artikel->judul }}</h2>
                <p class="text-muted">Kategori: {{ $artikel->jenis }}</p>
                <p class="card-text">
                  <div id="quill-editor">
                  {!! $artikel->isi !!}
               </div>
              </p>
            </div>

            <div class="card-footer d-flex justify-content-between">
                @if ($prevArtikel)
                    <a href="{{ route('artikel-user.detail', $prevArtikel->id) }}" class="btn btn-outline-primary">
                        ← {{ Str::limit($prevArtikel->judul, 30) }}
                    </a>
                @endif

                <a href="{{ route('artikel-user') }}" class="btn btn-primary">Kembali ke Daftar Artikel</a>

                @if ($nextArtikel)
                    <a href="{{ route('artikel-user.detail', $nextArtikel->id) }}" class="btn btn-outline-primary">
                        {{ Str::limit($nextArtikel->judul, 30) }} →
                    </a>
                @endif
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
