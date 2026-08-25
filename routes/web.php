<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LandingPageController@index');
Route::get('/api/cabor-info', 'LandingPageController@caborInfo');

// Public Lapor Insiden
Route::get('/lapor-insiden', 'LaporInsidenController@index')->name('lapor.index');
Route::post('/lapor-insiden', 'LaporInsidenController@store')->name('lapor.store');
Route::get('/lapor-insiden/success', 'LaporInsidenController@success')->name('lapor.success');

// Helper route to clear cache on shared hosting
Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return "Cache, Config, Views, and Routes cleared successfully!";
});

// Route alternatif pengganti symlink()
Route::get('/storage/{path}', function ($path) {
    $basePath = storage_path('app/public');
    $filePath = $basePath . '/' . $path;
    
    // Validate path to prevent path traversal vulnerabilities
    $realBase = realpath($basePath);
    $realFile = realpath($filePath);
    
    if ($realFile === false || strpos($realFile, $realBase) !== 0 || !is_file($realFile)) {
        abort(404);
    }
    
    return response()->file($realFile);
})->where('path', '.*');

// Public Absensi Nakes
Route::post('/public/nakes-jaga/{id}/absen', 'NakesJagaController@storeAbsen')->name('public.nakes-jaga.absen.store');

Route::get('/jadwal-tanding/cetak', 'LandingPageController@cetakJadwalTanding')->name('jadwal-tanding.cetak');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    
    // Manajemen (Hanya Admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('/manajemen/tentang', 'TentangKkpoController@index')->name('tentang.index');
        Route::post('/manajemen/tentang', 'TentangKkpoController@store')->name('tentang.store');
        Route::put('/manajemen/tentang/{id}', 'TentangKkpoController@update')->name('tentang.update');
        Route::delete('/manajemen/tentang/{id}', 'TentangKkpoController@destroy')->name('tentang.destroy');
        
        Route::get('/manajemen/struktur', 'StrukturOrganisasiController@index')->name('struktur.index');
        Route::post('/manajemen/struktur', 'StrukturOrganisasiController@store')->name('struktur.store');
        Route::put('/manajemen/struktur/{id}', 'StrukturOrganisasiController@update')->name('struktur.update');
        Route::delete('/manajemen/struktur/{id}', 'StrukturOrganisasiController@destroy')->name('struktur.destroy');
        
        Route::get('/manajemen/berita', 'BeritaController@index')->name('berita.index');
        Route::post('/manajemen/berita', 'BeritaController@store')->name('berita.store');
        Route::put('/manajemen/berita/{id}', 'BeritaController@update')->name('berita.update');
        Route::delete('/manajemen/berita/{id}', 'BeritaController@destroy')->name('berita.destroy');

        Route::get('/manajemen/hero', 'HeroSectionController@index')->name('hero.index');
        Route::put('/manajemen/hero', 'HeroSectionController@update')->name('hero.update');
    });

    // Master Kegiatan & Nakes (Admin, Ketua Panitia, Kabid Kesehatan, KONI)
    // admin_cabor tidak bisa akses. nakes dan rs juga tidak bisa akses.
    Route::middleware('role:admin,ketua_panitia,kabid_kesehatan,koni')->group(function () {
        // Master Kegiatan
        Route::get('/manajemen/kegiatan', 'KegiatanController@index')->name('kegiatan.index');
        Route::post('/manajemen/kegiatan', 'KegiatanController@store')->name('kegiatan.store');
        Route::put('/manajemen/kegiatan/{id}', 'KegiatanController@update')->name('kegiatan.update');
        Route::delete('/manajemen/kegiatan/{id}', 'KegiatanController@destroy')->name('kegiatan.destroy');
        Route::resource('jadwal-pertandingan', 'JadwalPertandinganController');
        Route::resource('kkpo-sebanten', 'KkpoSebantenController');

        // Nakes
        Route::resource('master-nakes', 'MasterNakesController');
        Route::resource('nakes-jaga', 'NakesJagaController');
        Route::post('/nakes-jaga/{id}/absen', 'NakesJagaController@storeAbsen')->name('nakes-jaga.absen.store');
        Route::delete('/nakes-jaga/absen/{id}', 'NakesJagaController@destroyAbsen')->name('nakes-jaga.absen.destroy');
        Route::get('/nakes-absen', 'NakesAbsenController@index')->name('nakes-absen.index');
        Route::get('/nakes-absen-pdf', 'NakesAbsenController@exportPdf')->name('nakes-absen.pdf');
        Route::get('/nakes-absen-excel', 'NakesAbsenController@exportExcel')->name('nakes-absen.excel');
    });
    
    // Pelaku Olah Raga
    Route::get('/pelaku-olahraga/template/excel', 'PelakuOlahragaController@downloadTemplate')->name('pelaku.template');
    Route::post('/pelaku-olahraga/import/excel', 'PelakuOlahragaController@importExcel')->name('pelaku.import');
    Route::get('/pelaku-olahraga/{kategori}', 'PelakuOlahragaController@index')->name('pelaku.index');
    Route::get('/pelaku-olahraga/create/{kategori}', 'PelakuOlahragaController@create')->name('pelaku.create');
    Route::post('/pelaku-olahraga', 'PelakuOlahragaController@store')->name('pelaku.store');
    Route::get('/pelaku-olahraga/edit/{id}', 'PelakuOlahragaController@edit')->name('pelaku.edit');
    Route::get('/pelaku-olahraga/{id}/cetak-kartu', 'PelakuOlahragaController@cetakKartu')->name('pelaku.cetak_kartu');
    Route::put('/pelaku-olahraga/{id}', 'PelakuOlahragaController@update')->name('pelaku.update');
    Route::delete('/pelaku-olahraga/{id}', 'PelakuOlahragaController@destroy')->name('pelaku.destroy');
    Route::delete('/pelaku-olahraga/dokumen/{id}', 'PelakuOlahragaController@destroyDokumen')->name('dokumen.destroy');
    
    // Accident
    Route::get('/accident/cedera', 'DataCederaController@index')->name('accident.cedera');

    Route::get('/accident/create', 'DataCederaController@create')->name('accident.create');
    Route::post('/accident/store', 'DataCederaController@store')->name('accident.store');
    Route::put('/accident/{id}/rujuk', 'DataCederaController@rujuk')->name('accident.rujuk');
    Route::put('/accident/{id}/sembuh', 'DataCederaController@sembuh')->name('accident.sembuh');
    Route::post('/accident/{id}/perawatan', 'DataCederaController@storePerawatan')->name('accident.perawatan');
    
    // Print Forms BPJS
    Route::get('/accident/{id}/print-tahap-1', 'DataCederaController@printTahap1')->name('accident.print-tahap-1');
    Route::get('/accident/{id}/print-tahap-2', 'DataCederaController@printTahap2')->name('accident.print-tahap-2');
    Route::get('/accident/{id}/print-kronologis', 'DataCederaController@printKronologis')->name('accident.print-kronologis');
    Route::get('/accident/{id}/print-foto', 'DataCederaController@printFoto')->name('accident.print-foto');
});

Auth::routes();

Route::post('/password/change', 'HomeController@changePassword')->name('password.change');

Route::get('/home', 'DashboardController@index')->name('home');
