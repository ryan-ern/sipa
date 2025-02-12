@php
    $isMenu = false;
    $navbarHideToggle = false;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Artikel Informasi')

@section('content')
<div class="row gy-6">
  <div class="col-md-12 col-lg-12 mb-4">
      <div class="container mt-4">
          <div class="row">
            @if($data->count() == 0)
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body text-center">
                    <h5 class="card-title">Data Artikel Informasi Tidak Ditemukan</h5>
                  </div>
                </div>
              </div>
            @endif
              @foreach($data as $artikel)
              <div class="col-md-4 mb-4">
                  <div class="card h-100 d-flex flex-column" onclick="window.location.href='{{ route('artikel-user.detail', $artikel->id) }}'">
                      <img src="{{ asset('storage/' . $artikel->fp_cover) }}"
                           class="card-img-top img-fluid"
                           style="height: 200px; object-fit: cover;"
                           alt="{{ $artikel->judul }}">
                      <div class="card-body d-flex flex-column">
                          <h5 class="card-title">{{ $artikel->judul }}</h5>
                          <p class="card-text flex-grow-1">
                              {{ Str::limit(strip_tags($artikel->isi), 100, '...') }}
                              <a href="{{ route('artikel-user.detail', $artikel->id) }}">Baca Selengkapnya</a>
                          </p>
                      </div>
                  </div>
              </div>
              @endforeach
          </div>

          <div class="d-flex justify-content-end mt-4">
              {{ $data->links('vendor.pagination.bootstrap-5') }}
          </div>
      </div>
  </div>
</div>
@endsection
