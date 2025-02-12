<?php

use App\Http\Controllers\authentications\Forgot;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\authentications\Register;
use App\Http\Controllers\pages\Admin;
use App\Http\Controllers\pages\DataAnak;
use App\Http\Controllers\pages\DataArtikel;
use App\Http\Controllers\pages\DataDonasi;
use App\Http\Controllers\pages\DataKegiatan;
use App\Http\Controllers\pages\DataPengguna;
use App\Http\Controllers\pages\DataSaran;
use App\Http\Controllers\pages\KondisiAnak;
use App\Http\Controllers\pages\Pendaftaran;
use App\Http\Controllers\pages\SyaratMasuk;
use App\Http\Controllers\pages\Visitor;

// Main Page Route

Route::fallback(function () {
  return redirect('/pages/not-found');
});

Route::get('/pages/not-found', [MiscError::class, 'index'])->name('not-found');
Route::post('/auth/logout', [Login::class, 'logout'])->name('logout');


// ADMIN
Route::group(['middleware' => ['auth', 'role:admin']], function () {
  Route::get('/dashboard', [Admin::class, 'index'])->name('dashboard');

  // data pengguna
  Route::post('/pages/data-pengguna', [DataPengguna::class, 'store'])->name('data-pengguna.store');
  Route::get('/pages/data-pengguna', [DataPengguna::class, 'index'])->name('data-pengguna');
  Route::put('/pages/data-pengguna/{id}', [DataPengguna::class, 'update'])->name('data-pengguna.update');
  Route::delete('/pages/data-pengguna/{id}', [DataPengguna::class, 'destroy'])->name('data-pengguna.destroy');

  // data donasi
  Route::post('/pages/data-donasi', [DataDonasi::class, 'store'])->name('data-donasi.store');
  Route::get('/pages/data-donasi', [DataDonasi::class, 'index'])->name('data-donasi');
  Route::put('/pages/data-donasi/{id}', [DataDonasi::class, 'update'])->name('data-donasi.update');
  Route::delete('/pages/data-donasi/{id}', [DataDonasi::class, 'destroy'])->name('data-donasi.destroy');

  // data informasi
  Route::post('/pages/data-informasi', [DataArtikel::class, 'store'])->name('data-informasi.store');
  Route::get('/pages/data-informasi', [DataArtikel::class, 'index'])->name('data-informasi');
  Route::put('/pages/data-informasi/{id}', [DataArtikel::class, 'update'])->name('data-informasi.update');
  Route::delete('/pages/data-informasi/{id}', [DataArtikel::class, 'destroy'])->name('data-informasi.destroy');

  // data saran
  Route::put('/pages/data-saran/{id}', [DataSaran::class, 'update'])->name('data-saran.update');
  Route::get('/pages/data-saran', [DataSaran::class, 'index'])->name('data-saran');
  Route::delete('/pages/data-saran/{id}', [DataSaran::class, 'destroy'])->name('data-saran.destroy');

  // syarat masuk
  Route::put('/pages/syarat-masuk/{id}', [SyaratMasuk::class, 'update'])->name('syarat-masuk.update');
  Route::get('pages/persyaratan', [SyaratMasuk::class, 'index'])->name('syarat-masuk');

  // data kegiatan
  Route::post('/pages/data-kegiatan', [DataKegiatan::class, 'store'])->name('data-kegiatan.store');
  Route::get('/pages/data-kegiatan/events', [DataKegiatan::class, 'getEvents'])->name('data-kegiatan.events');
  Route::get('/pages/data-kegiatan', [DataKegiatan::class, 'index'])->name('data-kegiatan');
  Route::put('/pages/data-kegiatan/{id}', [DataKegiatan::class, 'update'])->name('data-kegiatan.update');
  Route::delete('/pages/data-kegiatan/{id}', [DataKegiatan::class, 'destroy'])->name('data-kegiatan.destroy');

  // data pendaftaran
  Route::get('/pages/data-pendaftaran', [Pendaftaran::class, 'index'])->name('data-pendaftaran');
  Route::put('/pendaftaran-anak/status/{id}', [Pendaftaran::class, 'store'])->name('pendaftaran-anak.status');
  Route::delete('/pages/pendaftaran-anak/delete/{id}', [Pendaftaran::class, 'destroy'])->name('pendaftaran-anak.destroy');

  // data anak
  Route::get('/pages/data-anak', [DataAnak::class, 'index'])->name('data-anak');
  Route::post('/pages/data-anak', [DataAnak::class, 'store'])->name('data-anak.store');
  Route::put('/data-anak/status/{id}', [DataAnak::class, 'store'])->name('data-anak.status');
  Route::delete('/data-anak/hapus/{id}', [DataAnak::class, 'destroy'])->name('data-anak.destroy');
  Route::get('/pages/data-anak-detail/{id}', [DataAnak::class, 'detail'])->name('data-anak.detail');
  Route::put('/pages/data-anak-detail/update/{id}', [DataAnak::class, 'store'])->name('data-anak.detail.update');
  Route::delete('/pages/data-anak/delete-fie/{id}', [KondisiAnak::class, 'destroy'])->name('data-anak.delete-file');


  // data riwayat
  Route::post('/pages/data-riwayat', [DataAnak::class, 'riwayat'])->name('data-riwayat.store');
});

// USER
Route::group(['middleware' => ['auth', 'role:user']], function () {

  Route::get('/pages/pendaftaran-anak', [Pendaftaran::class, 'indexUser'])->name('pendaftaran-anak');
  Route::post('/pendaftaran-anak', [Pendaftaran::class, 'store'])->name('pendaftaran-anak.store');
  Route::put('/pendaftaran-anak/{id}', [Pendaftaran::class, 'store'])->name('pendaftaran-anak.update');

  Route::get('/pages/kondisi-anak', [KondisiAnak::class, 'index'])->name('kondisi-anak');
  Route::post('/kondisi-anak', [KondisiAnak::class, 'index'])->name('kondisi-anak.get');
  Route::put('/pages/data-anak/{id}', [DataAnak::class, 'store'])->name('data-anak.update');

  Route::delete('delete-fie/{id}', [KondisiAnak::class, 'destroy'])->name('delete-file');
});

// VISITOR
Route::group(['middleware' => ['guest']], function () {
  // index
  Route::get('/', [Visitor::class, 'BerandaUser'])->name('beranda-user');
  Route::get('/kegiatan', [Visitor::class, 'Kegiatan'])->name('kegiatan-user');
  Route::get('/persyaratan', [Visitor::class, 'Persyaratan'])->name('syarat-user');
  Route::get('/artikel-informasi', [Visitor::class, 'Artikel'])->name('artikel-user');
  Route::get('/artikel-informasi/{id}', [Visitor::class, 'ArtikelDetail'])->name('artikel-user.detail');
  Route::get('/hubungi', [Visitor::class, 'Hubungi'])->name('hubungi-user');
  Route::get('/data-kegiatan/events', [DataKegiatan::class, 'getEvents'])->name('data-kegiatan.events.user');
  Route::post('/pages/data-saran', [DataSaran::class, 'store'])->name('data-saran.store');
  // auth
  Route::get('/auth', function () {
    return redirect('/auth/login');
  });
  Route::get('/login', function () {
    return redirect('/auth/login');
  });
  Route::get('/auth/login', [Login::class, 'index'])->name('login');
  Route::post('/auth/login', [Login::class, 'store'])->name('login.store');
  Route::get('/auth/forgot', [Forgot::class, 'index'])->name('forgot');
  Route::put('/auth/forgot-password', [Forgot::class, 'update'])->name('forgot.update');
  Route::get('/auth/register', [Register::class, 'index'])->name('register');
  Route::post('/auth/register', [Register::class, 'store'])->name('register.store');
});
