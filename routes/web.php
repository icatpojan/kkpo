<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $pelakuOlahragaCount = \App\PelakuOlahraga::count();
    $nakesCount = \App\NakesJaga::count();
    $kegiatanCount = \App\Kegiatan::count();
    $berita = \App\Berita::latest()->take(3)->get();
    $kegiatans = \App\Kegiatan::whereDate('tanggal', '>=', now())->orderBy('tanggal', 'asc')->take(5)->get();
    if($kegiatans->isEmpty()) {
        $kegiatans = \App\Kegiatan::orderBy('tanggal', 'desc')->take(5)->get();
    }
    $hero = \App\HeroSection::first();
    
    return view('welcome', compact('pelakuOlahragaCount', 'nakesCount', 'kegiatanCount', 'berita', 'kegiatans', 'hero'));
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    
    // Manajemen
    Route::get('/manajemen/tentang', 'TentangKkpoController@index')->name('tentang.index');
    Route::post('/manajemen/tentang', 'TentangKkpoController@store')->name('tentang.store');
    Route::put('/manajemen/tentang/{id}', 'TentangKkpoController@update')->name('tentang.update');
    Route::delete('/manajemen/tentang/{id}', 'TentangKkpoController@destroy')->name('tentang.destroy');
    
    Route::get('/manajemen/struktur', 'StrukturOrganisasiController@index')->name('struktur.index');
    Route::post('/manajemen/struktur', 'StrukturOrganisasiController@store')->name('struktur.store');
    Route::put('/manajemen/struktur/{id}', 'StrukturOrganisasiController@update')->name('struktur.update');
    Route::delete('/manajemen/struktur/{id}', 'StrukturOrganisasiController@destroy')->name('struktur.destroy');
    
    Route::get('/manajemen/kegiatan', 'KegiatanController@index')->name('kegiatan.index');
    Route::post('/manajemen/kegiatan', 'KegiatanController@store')->name('kegiatan.store');
    Route::put('/manajemen/kegiatan/{id}', 'KegiatanController@update')->name('kegiatan.update');
    Route::delete('/manajemen/kegiatan/{id}', 'KegiatanController@destroy')->name('kegiatan.destroy');
    Route::get('/manajemen/berita', 'BeritaController@index')->name('berita.index');
    Route::post('/manajemen/berita', 'BeritaController@store')->name('berita.store');
    Route::put('/manajemen/berita/{id}', 'BeritaController@update')->name('berita.update');
    Route::delete('/manajemen/berita/{id}', 'BeritaController@destroy')->name('berita.destroy');

    Route::get('/manajemen/hero', 'HeroSectionController@index')->name('hero.index');
    Route::put('/manajemen/hero', 'HeroSectionController@update')->name('hero.update');
    
    // Resource Controllers for Tables
    Route::resource('jadwal-pertandingan', 'JadwalPertandinganController');
    Route::resource('kkpo-sebanten', 'KkpoSebantenController');
    Route::resource('master-nakes', 'MasterNakesController');
    Route::resource('nakes-jaga', 'NakesJagaController');
    
    // Pelaku Olah Raga
    Route::get('/pelaku-olahraga/{kategori}', 'PelakuOlahragaController@index')->name('pelaku.index');
    Route::get('/pelaku-olahraga/create/{kategori}', 'PelakuOlahragaController@create')->name('pelaku.create');
    Route::post('/pelaku-olahraga', 'PelakuOlahragaController@store')->name('pelaku.store');
    Route::get('/pelaku-olahraga/edit/{id}', 'PelakuOlahragaController@edit')->name('pelaku.edit');
    Route::put('/pelaku-olahraga/{id}', 'PelakuOlahragaController@update')->name('pelaku.update');
    Route::delete('/pelaku-olahraga/{id}', 'PelakuOlahragaController@destroy')->name('pelaku.destroy');
    
    // Accident
    Route::get('/accident/cedera', 'DataCederaController@index')->name('accident.cedera');
    Route::get('/accident/rujukan', 'DataCederaController@rujukan')->name('accident.rujukan');
    Route::get('/accident/create', 'DataCederaController@create')->name('accident.create');
    Route::post('/accident/store', 'DataCederaController@store')->name('accident.store');
    Route::put('/accident/{id}/rujuk', 'DataCederaController@rujuk')->name('accident.rujuk');
    Route::put('/accident/{id}/sembuh', 'DataCederaController@sembuh')->name('accident.sembuh');
});

Auth::routes();

Route::post('/password/change', 'HomeController@changePassword')->name('password.change');

Route::get('/home', 'DashboardController@index')->name('home');
