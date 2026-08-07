<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenController extends Controller
{
    public function tentang()
    {
        return view('manajemen.tentang');
    }

    public function struktur()
    {
        return view('manajemen.struktur');
    }

    public function kegiatan()
    {
        return view('manajemen.kegiatan');
    }

    public function berita()
    {
        return view('manajemen.berita');
    }
}
