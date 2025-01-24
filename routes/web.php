<?php

use App\Http\Controllers\authentications\Forgot;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\authentications\Register;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\dashboard\Admin;
use App\Http\Controllers\dashboard\User;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\RiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\pages\DataAnak;
use App\Http\Controllers\pages\DataArtikel;
use App\Http\Controllers\pages\DataDonasi;
use App\Http\Controllers\pages\DataKegiatan;
use App\Http\Controllers\pages\DataPengguna;
use App\Http\Controllers\pages\DataSaran;
use App\Http\Controllers\pages\KondisiAnak;
use App\Http\Controllers\pages\Pendaftaran;
use App\Http\Controllers\pages\SyaratMasuk;
use App\Http\Controllers\tables\Basic as TablesBasic;
use Dflydev\DotAccessData\Data;

// Main Page Route

Route::fallback(function () {
  return redirect('/pages/not-found');
});

Route::get('/', [Blank::class, 'index'])->name('layouts-blank');

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
  Route::post('/pages/data-saran', [DataSaran::class, 'store'])->name('data-saran.store');
  Route::put('/pages/data-saran/{id}', [DataSaran::class, 'update'])->name('data-saran.update');
  Route::get('/pages/data-saran', [DataSaran::class, 'index'])->name('data-saran');
  Route::delete('/pages/data-saran/{id}', [DataSaran::class, 'destroy'])->name('data-saran.destroy');

  // syarat masuk
  Route::put('/pages/syarat-masuk/{id}', [SyaratMasuk::class, 'update'])->name('syarat-masuk.update');
  Route::get('/pages/syarat-masuk', [SyaratMasuk::class, 'index'])->name('syarat-masuk');

  // data kegiatan
  Route::post('/pages/data-kegiatan', [DataKegiatan::class, 'store'])->name('data-kegiatan.store');
  Route::get('/pages/data-kegiatan/events', [DataKegiatan::class, 'getEvents'])->name('data-kegiatan.events');
  Route::get('/pages/data-kegiatan', [DataKegiatan::class, 'index'])->name('data-kegiatan');
  Route::put('/pages/data-kegiatan/{id}', [DataKegiatan::class, 'update'])->name('data-kegiatan.update');
  Route::delete('/pages/data-kegiatan/{id}', [DataKegiatan::class, 'destroy'])->name('data-kegiatan.destroy');

  // data pendaftaran
  Route::get('/pages/data-pendaftaran', [Pendaftaran::class, 'index'])->name('data-pendaftaran');
  Route::put('/pendaftaran-anak/status/{id}', [Pendaftaran::class, 'store'])->name('pendaftaran-anak.status');

  // data anak
  Route::get('/pages/data-anak', [DataAnak::class, 'index'])->name('data-anak');
  Route::put('/data-anak/status/{id}', [DataAnak::class, 'store'])->name('data-anak.status');

  // data riwayat
  Route::post('/pages/data-riwayat', [DataAnak::class, 'riwayat'])->name('data-riwayat.store');
});

Route::group(['middleware' => ['auth', 'role:user']], function () {
  Route::get('/beranda', [User::class, 'index'])->name('beranda');

  Route::get('/pages/pendaftaran-anak', [Pendaftaran::class, 'indexUser'])->name('pendaftaran-anak');
  Route::post('/pendaftaran-anak', [Pendaftaran::class, 'store'])->name('pendaftaran-anak.store');
  Route::put('/pendaftaran-anak/{id}', [Pendaftaran::class, 'store'])->name('pendaftaran-anak.update');

  Route::get('/pages/kondisi-anak', [KondisiAnak::class, 'index'])->name('kondisi-anak');
  Route::post('/kondisi-anak', [KondisiAnak::class, 'index'])->name('kondisi-anak.get');
  Route::put('/pages/data-anak/{id}', [DataAnak::class, 'store'])->name('data-anak.update');
});

Route::group(['middleware' => ['guest']], function () {
  Route::get('/auth', function () {
    return redirect('/auth/login');
  });
  Route::get('/login', function () {
    return redirect('/auth/login');
  });
  Route::get('/auth/login', [Login::class, 'index'])->name('login');
  Route::post('/auth/login', [Login::class, 'store'])->name('login.store');
  Route::get('/auth/forgot', [Forgot::class, 'index'])->name('forgot');
  Route::get('/auth/register', [Register::class, 'index'])->name('register');
  Route::post('/auth/register', [Register::class, 'store'])->name('register.store');
});

Route::post('/auth/logout', [Login::class, 'logout'])->name('logout');

// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/not-found', [MiscError::class, 'index'])->name('not-found');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication


// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/icons-ri', [RiIcons::class, 'index'])->name('icons-ri');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
