<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KKPO - KONI Tangerang Selatan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-teal: #82a8c7; 
            --primary-dark: #638ab0;
            --accent: #facc15; 
            --bg-light: #f8fafc;
            --text-main: #334155;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            margin: 0;
            overflow-x: hidden;
        }

        /* Preloader Styles */
        .preloader-container {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            z-index: 999999;
            display: flex; justify-content: center; align-items: center;
            transition: opacity 0.6s cubic-bezier(0.8, 0, 0.2, 1), visibility 0.6s ease;
        }
        .preloader-content { display: flex; flex-direction: column; align-items: center; }
        .preloader-logo {
            width: 140px; height: auto; margin-bottom: 15px;
            animation: float-logo 3s ease-in-out infinite;
            mix-blend-mode: multiply;
        }
        .preloader-bar-container {
            width: 140px; height: 4px; background: rgba(130, 168, 199, 0.2);
            border-radius: 4px; overflow: hidden; position: relative;
        }
        .preloader-bar {
            position: absolute; top: 0; left: 0; height: 100%; width: 50%;
            background: linear-gradient(90deg, var(--primary-teal), #0ea5e9);
            border-radius: 4px;
            animation: loading-bar 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }
        @keyframes float-logo {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }
        @keyframes loading-bar {
            0% { left: -50%; width: 50%; }
            50% { width: 80%; }
            100% { left: 100%; width: 50%; }
        }
        .preloader-hidden { opacity: 0; visibility: hidden; }

        /* Navbar */
        .navbar-custom {
            position: fixed;
            top: 0; left: 0; right: 0;
            padding: 20px 0;
            z-index: 1000;
            transition: all 0.4s ease;
            background: transparent;
        }
        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 12px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .navbar-brand-text {
            font-weight: 900; font-size: 1.5rem; letter-spacing: 1px; color: var(--primary-dark); transition: 0.4s;
        }
        .navbar-custom.scrolled .navbar-brand-text { color: var(--primary-dark); }
        
        .navbar-brand-sub {
            font-weight: 700; font-size: 0.7rem; letter-spacing: 2px; color: #64748b; text-transform: uppercase; transition: 0.4s; display: block; line-height: 1;
        }
        .navbar-custom.scrolled .navbar-brand-sub { color: #64748b; }

        .nav-link {
            color: #475569 !important;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 8px 16px !important;
            margin: 0 5px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .navbar-custom.scrolled .nav-link { color: #475569 !important; }
        .nav-link:hover { background: rgba(130, 168, 199, 0.1); color: var(--primary-dark) !important; }
        .navbar-custom.scrolled .nav-link:hover { background: rgba(130, 168, 199, 0.1); color: var(--primary-dark) !important; }
        
        .btn-login {
            background: var(--primary-teal); color: #ffffff; font-weight: 700; border-radius: 50px; padding: 10px 25px; transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-decoration: none; display: inline-flex; align-items: center; justify-content: center; border: none;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); color: #ffffff; background: var(--primary-dark); }
        
        .navbar-custom.scrolled .btn-login {
            background: var(--primary-teal); color: #ffffff;
        }
        .navbar-custom.scrolled .btn-login:hover { background: var(--primary-dark); color: #ffffff; }

        /* Hero Banner */
        .hero-banner {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        .hero-banner::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('{{ asset("images/bg-pattern.png") }}');
            background-size: cover; background-position: center; opacity: 0.15; z-index: 0;
        }
        
        .hero-shape {
            position: absolute; top: -10%; right: -5%; width: 50%; height: 120%;
            background: var(--primary-teal);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            z-index: 0; opacity: 0.9;
            box-shadow: 0 0 100px rgba(130, 168, 199, 0.5);
            animation: morph 8s ease-in-out infinite;
        }
        @keyframes morph {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            50% { border-radius: 50% 50% 30% 70% / 50% 70% 30% 50%; }
            100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        }

        .hero-content {
            position: relative; z-index: 2; padding-right: 50px;
        }
        .hero-title {
            font-size: 3.2rem; font-weight: 900; line-height: 1.2; margin-bottom: 25px; color: #0f172a;
            letter-spacing: -1px;
        }
        .hero-title span { color: var(--primary-teal); }
        .hero-subtitle {
            font-size: 1.25rem; color: #475569; margin-bottom: 40px; line-height: 1.6; font-weight: 400; max-width: 600px;
        }
        
        .hero-image {
            position: relative; z-index: 2; text-align: center;
        }
        .hero-image img {
            width: 100%; max-height: 450px; object-fit: cover; border-radius: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            animation: float-img 6s ease-in-out infinite;
        }
        @keyframes float-img {
            0% { transform: translateY(0); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0); }
        }

        /* Glassmorphism Stats Cards */
        .stats-container { margin-top: -60px; position: relative; z-index: 10; margin-bottom: 80px; }
        .stat-card {
            background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.5); border-radius: 20px; padding: 30px 20px;
            text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.05); transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-10px); }
        .stat-icon {
            width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-teal), var(--primary-dark));
            color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin: 0 auto 15px auto; box-shadow: 0 10px 20px rgba(130, 168, 199, 0.3);
        }
        .stat-value { font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 5px; line-height: 1; }
        .stat-label { font-size: 0.9rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }

        /* Content Section */
        .section-title { font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 15px; text-align: center; }
        .section-subtitle { text-align: center; color: #64748b; font-size: 1.1rem; margin-bottom: 50px; }
        
        .news-card {
            background: #ffffff; border-radius: 24px; overflow: hidden; border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: 0.3s; height: 100%; display: flex; flex-direction: column;
        }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.08); }
        .news-img-wrap { width: 100%; height: 240px; overflow: hidden; }
        .news-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .news-card:hover .news-img-wrap img { transform: scale(1.05); }
        .news-body { padding: 30px; flex: 1; display: flex; flex-direction: column; }
        .news-meta { color: var(--primary-teal); font-size: 0.85rem; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
        .news-title { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 15px; line-height: 1.4; }
        .news-text { color: #64748b; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px; flex: 1; }
        .btn-readmore { font-weight: 700; color: var(--primary-dark); text-decoration: none; display: inline-flex; align-items: center; transition: 0.2s; }
        .btn-readmore i { transition: 0.2s; }
        .btn-readmore:hover { color: var(--primary-teal); }
        .btn-readmore:hover i { transform: translateX(5px); }

        /* Footer */
        footer {
            background: #0f172a; padding: 60px 0 30px 0; color: #94a3b8;
        }
        .footer-logo img { filter: brightness(0) invert(1); opacity: 0.8; mix-blend-mode: screen; }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                padding: 15px;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                margin-top: 15px;
            }
            .navbar-nav .nav-link {
                padding: 10px 15px !important;
                margin: 5px 0;
                text-align: center;
            }
            .navbar-collapse .btn-login {
                width: 100%;
                margin-top: 10px;
            }
            .hero-title { font-size: 3rem; }
            .hero-content { padding-right: 0; text-align: center; }
            .hero-subtitle { margin-left: auto; margin-right: auto; }
            .hero-banner { text-align: center; }
        }
        @media (max-width: 767.98px) {
            .hero-title { font-size: 2.25rem; margin-bottom: 15px; }
            .hero-subtitle { font-size: 1rem; margin-bottom: 25px; }
            .hero-banner { min-height: auto; padding-top: 140px; padding-bottom: 50px; }
            .hero-image img { max-height: 250px; }
            .stats-container { margin-top: 0; margin-bottom: 40px; }
            .stat-card { padding: 15px 5px; border-radius: 12px; }
            .stat-icon { width: 35px; height: 35px; font-size: 1rem; margin-bottom: 8px; }
            .stat-value { font-size: 1.5rem; }
            .stat-label { font-size: 0.65rem; letter-spacing: 0; line-height: 1.2; }
            .section-title { font-size: 1.8rem; }
            .section-subtitle { font-size: 1rem; margin-bottom: 30px; }
            
            /* Mobile News Carousel */
            .news-scroll-mobile {
                flex-wrap: nowrap; overflow-x: auto; scroll-snap-type: x mandatory;
                padding-bottom: 20px; scrollbar-width: none; -webkit-overflow-scrolling: touch;
            }
            .news-scroll-mobile::-webkit-scrollbar { display: none; }
            .news-scroll-mobile > div {
                flex: 0 0 85%; max-width: 85%; scroll-snap-align: center;
            }

            /* Layanan / Fitur Card */
            .fitur-card { padding: 15px 10px !important; border-radius: 12px !important; }
            .fitur-icon { font-size: 1.5rem !important; margin-bottom: 10px !important; }
            .fitur-title { font-size: 0.85rem !important; margin-bottom: 5px !important; line-height: 1.3; }
            .fitur-desc { font-size: 0.7rem !important; line-height: 1.4; }

            /* Mobile Event Table */
            .mobile-table-wrapper { overflow-x: auto !important; }
            .mobile-table th, .mobile-table td { font-size: 0.85rem !important; padding: 12px 10px !important; }
            .mobile-table .fas { font-size: 0.85rem; }
            .mobile-table th:nth-child(1), .mobile-table td:nth-child(1) { min-width: 130px; } /* Tanggal */
            .mobile-table th:nth-child(2), .mobile-table td:nth-child(2) { min-width: 160px; } /* Kegiatan */
            .mobile-table th:nth-child(3), .mobile-table td:nth-child(3) { min-width: 130px; } /* Lokasi */
            .mobile-table th:nth-child(4), .mobile-table td:nth-child(4) { min-width: 200px; } /* Deskripsi */
        }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div id="preloader" class="preloader-container">
        <div class="preloader-content">
            <img src="{{ asset('img/logo.png') }}" alt="KKPO Logo" class="preloader-logo">
            <div class="preloader-bar-container">
                <div class="preloader-bar"></div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div style="background: white; padding: 6px; border-radius: 12px; display: flex; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-right: 15px;">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 32px; height: 32px; border-radius: 6px; object-fit: contain;">
                </div>
                <div>
                    <span class="navbar-brand-text">KKPO</span>
                    <span class="navbar-brand-sub">Tangsel</span>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars text-dark" id="navIcon" style="font-size: 1.5rem;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kegiatan">Kegiatan</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-login"> Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="hero-shape"></div>
        <div class="container relative z-10">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="hero-content">
                        <!-- <span class="d-inline-block py-1 px-3 rounded-pill bg-white shadow-sm mb-4" style="color: var(--primary-dark); font-weight: 700; font-size: 0.85rem; border: 1px solid rgba(130,168,199,0.2);">
                            <i class="fas fa-heartbeat me-2"></i> Sistem Informasi Manajemen KKPO
                        </span> -->
                        <h1 class="hero-title">{!! $hero ? $hero->judul : 'Kesehatan <span>Kesejahteraan</span> Pelaku Olah Raga' !!}</h1>
                        <p class="hero-subtitle">{{ $hero ? $hero->sub_judul : 'KONI Tangerang Selatan hadir mengawal kesehatan, mencegah cedera, dan memastikan kesejahteraan setiap atlet, pelatih, maupun official di setiap ajang kompetisi olahraga.' }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="{{ $hero && $hero->gambar ? Storage::url($hero->gambar) : asset('images/hero-medical.png') }}" alt="Medical Team">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div id="tentang" class="container stats-container">
        <div class="row g-2 g-md-4 mt-2">
            <div class="col-4 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-value">{{ $pelakuOlahragaCount }}</div>
                    <div class="stat-label">Atlet Dibina</div>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-user-md"></i></div>
                    <div class="stat-value">{{ $nakesCount }}</div>
                    <div class="stat-label">Tenaga Medis</div>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                    <div class="stat-value">{{ $kegiatanCount }}</div>
                    <div class="stat-label">Event Dikawal</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan / Fitur Section -->
    <section id="layanan" class="py-5 bg-white">
        <div class="container py-3">
            <h2 class="section-title">Peran dan Fungsi KKPO</h2>
            <p class="section-subtitle">Mengelola kesehatan dan kesejahteraan pelaku olahraga dalam berbagai event pertandingan dengan sistem terintegrasi.</p>
            
            <div class="row g-2 g-md-4 mt-2">
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card" style="background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0;">
                        <i class="fas fa-user-injured mb-3 fitur-icon" style="font-size: 2.5rem; color: var(--primary-teal);"></i>
                        <h4 class="fw-bold fs-5 mb-3 fitur-title" style="color: #0f172a;">Pemantauan Cedera</h4>
                        <p class="text-muted small mb-0 fitur-desc">Pencatatan real-time terkait riwayat cedera atlet, kronologis, hingga penanganan pertama (kompres, obat, dll).</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card" style="background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0;">
                        <i class="fas fa-file-medical mb-3 fitur-icon" style="font-size: 2.5rem; color: var(--primary-teal);"></i>
                        <h4 class="fw-bold fs-5 mb-3 fitur-title" style="color: #0f172a;">Rekam Medis Atlet</h4>
                        <p class="text-muted small mb-0 fitur-desc">Menyimpan riwayat kesehatan pelaku olahraga (Atlit, Pelatih, Official) secara komprehensif.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card" style="background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0;">
                        <i class="fas fa-calendar-check mb-3 fitur-icon" style="font-size: 2.5rem; color: var(--primary-teal);"></i>
                        <h4 class="fw-bold fs-5 mb-3 fitur-title" style="color: #0f172a;">Jadwal Nakes Siaga</h4>
                        <p class="text-muted small mb-0 fitur-desc">Penjadwalan tenaga kesehatan (Puskesmas, RS, Klinik) di seluruh venue dan event cabang olahraga secara terpusat.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card" style="background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0;">
                        <i class="fas fa-ambulance mb-3 fitur-icon" style="font-size: 2.5rem; color: var(--primary-teal);"></i>
                        <h4 class="fw-bold fs-5 mb-3 fitur-title" style="color: #0f172a;">Manajemen Rujukan</h4>
                        <p class="text-muted small mb-0 fitur-desc">Sistem terstruktur untuk memberikan surat rujukan dan memfasilitasi penanganan serius ke rumah sakit jejaring KKPO.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section id="berita" class="py-4 py-md-5" style="background-color: var(--bg-light);">
        <div class="container py-2 py-md-5">
            <h2 class="section-title">Berita & Informasi Terkini</h2>
            <p class="section-subtitle">Pantau terus perkembangan persiapan tim medis KKPO dalam menyambut Porprov VII Banten 2026.</p>
            
            <div class="row g-4 news-scroll-mobile">
                @forelse($berita as $item)
                <div class="col-md-4">
                    <div class="news-card">
                        <div class="news-img-wrap">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
                            @else
                                <img src="{{ asset('images/news-placeholder.png') }}" alt="{{ $item->judul }}">
                            @endif
                        </div>
                        <div class="news-body">
                            <div class="news-meta">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                            <h3 class="news-title">{{ $item->judul }}</h3>
                            <p class="news-text">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                            <a href="#" class="btn-readmore">Selengkapnya <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center text-muted">
                    <p>Belum ada berita yang dipublikasikan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Kegiatan Section -->
    <section id="kegiatan" class="py-4 py-md-5" style="background-color: var(--bg-light);">
        <div class="container py-2 py-md-5">
            <h2 class="section-title">Event & Kegiatan</h2>
            <p class="section-subtitle">Informasi kegiatan dan event yang didukung oleh tim medis KKPO.</p>
            
            <div class="table-responsive bg-white shadow-sm mobile-table-wrapper" style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(130,168,199,0.2);">
                <table class="table table-hover align-middle mb-0 mobile-table" style="margin: 0; border: none;">
                    <thead style="background: linear-gradient(135deg, var(--primary-teal), var(--primary-dark)); color: white;">
                        <tr>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 15%;">Tanggal</th>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 30%;">Kegiatan</th>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 25%;">Lokasi</th>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 30%;">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatans as $item)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td class="py-3 px-4 border-0">
                                <div style="display: inline-flex; align-items: center; background: rgba(130, 168, 199, 0.1); color: var(--primary-dark); padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; white-space: nowrap;">
                                    <i class="fas fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                </div>
                            </td>
                            <td class="py-3 px-4 border-0 fw-bold" style="color: #0f172a;">{{ $item->nama_kegiatan }}</td>
                            <td class="py-3 px-4 border-0" style="color: #475569;">
                                <i class="fas fa-map-marker-alt me-2" style="color: #ef4444;"></i>{{ $item->lokasi }}
                            </td>
                            <td class="py-3 px-4 border-0 text-muted" style="font-size: 0.9rem;">
                                {{ Str::limit(strip_tags($item->deskripsi), 80) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 border-0 text-muted">
                                <i class="fas fa-folder-open mb-3" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                                <p class="mb-0">Belum ada kegiatan yang dijadwalkan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <div class="footer-logo mb-4">
                <div style="background: rgba(255,255,255,0.1); padding: 10px; border-radius: 16px; display: inline-flex; margin-bottom: 20px;">
                    <!-- <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 48px; height: 48px; object-fit: contain;"> -->
                </div>
                <h4 class="text-white fw-bold">KKPO Tangsel</h4>
                <p>Klinik Kesehatan Pelaku Olahraga<br>KONI Tangerang Selatan</p>
            </div>
            <div class="border-top border-secondary pt-4 mt-4">
                <p class="mb-0 small">© 2026 KKPO KONI Tangerang Selatan. All rights reserved. <br>Designed for Banten.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preloader Logic
        window.addEventListener('load', function() {
            setTimeout(function() {
                const preloader = document.getElementById('preloader');
                if(preloader) { preloader.classList.add('preloader-hidden'); }
            }, 400);
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
