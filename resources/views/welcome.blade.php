<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KKPO - KONI Tangerang Selatan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-remove.png') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        .select2-container {
            width: 100% !important;
            display: block;
        }
        
        .select2-container .select2-selection--single {
            height: 45px !important;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding-left: 5px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 43px;
            color: #334155;
            font-size: 0.9rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }
        
        /* FullCalendar Overrides */
        .fc-theme-standard .fc-scrollgrid { border: none !important; }
        .fc-theme-standard td, .fc-theme-standard th { border: none !important; }
        .fc-theme-standard .fc-day-today { background-color: transparent !important; }
        .fc-daygrid-day-events, .fc-daygrid-day-bottom { display: none !important; }
        
        .fc .fc-daygrid-day-frame { 
            border-radius: 12px !important; margin: 8px !important; border: 1px solid var(--cell-border, #e2e8f0) !important; cursor: pointer !important; transition: 0.2s !important; 
            aspect-ratio: 1 / 1 !important; 
            background-color: var(--cell-bg, transparent) !important;
            display: flex !important; flex-direction: column !important; justify-content: center !important; align-items: center !important; 
            min-height: 0 !important; height: auto !important;
        }
        .fc .fc-daygrid-day-frame:hover { transform: scale(1.05); box-shadow: 0 4px 12px rgba(0,0,0,0.05); z-index: 5; position: relative; }
        .fc .fc-daygrid-day-top { width: 100% !important; height: 100% !important; display: flex !important; flex-direction: column !important; justify-content: center !important; align-items: center !important; }
        .fc-day-other .fc-daygrid-day-frame { visibility: hidden !important; border: none !important; }
        .fc-daygrid-day-number { width: 100% !important; height: 100% !important; display: flex !important; flex-direction: column !important; justify-content: center !important; align-items: center !important; text-decoration: none !important; padding: 0 !important; }
        .fc-col-header-cell-cushion { background: #f8fafc !important; border-radius: 8px !important; margin: 8px !important; padding: 10px 0 !important; width: calc(100% - 16px) !important; display: block !important; text-decoration: none !important; color: #475569 !important; font-weight: 600 !important; font-size: 0.9rem !important; }
        
        .cal-day-num { font-size: 1.1rem; font-weight: 700; text-align: center; line-height: 1.2; }
        .cal-day-text { font-size: 0.65rem; font-weight: 600; text-align: center; margin-top: 2px; }

        @media (max-width: 767.98px) {
            .fc .fc-daygrid-day-frame { border-radius: 8px !important; margin: 3px !important; }
            .cal-day-num { font-size: 0.85rem !important; margin-bottom: 2px !important; }
            .cal-day-text { font-size: 0.45rem !important; margin-top: 0 !important; letter-spacing: -0.5px !important; white-space: nowrap !important; line-height: 1 !important; transform: scale(0.8); transform-origin: top center; }
            .fc .fc-toolbar-title { font-size: 1.1rem !important; }
            .fc .fc-button { padding: 4px 8px !important; font-size: 0.8rem !important; }
            .fc-col-header-cell-cushion { padding: 4px 0 !important; font-size: 0.7rem !important; margin: 2px !important; width: calc(100% - 4px) !important; border-radius: 6px !important; }
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
        /* .footer-logo img { filter: brightness(0) invert(1); opacity: 0.8; mix-blend-mode: screen; } */

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
            .hero-btn { width: 100%; max-width: 250px; }
        }
        @media (max-width: 767.98px) {
            .hero-btn { width: 100%; max-width: none; flex: 1; font-size: 0.8rem !important; padding: 10px 10px !important; white-space: normal; display: flex; align-items: center; justify-content: center; text-align: center; line-height: 1.2; }
            .hero-btn i { font-size: 0.9rem; margin-right: 4px !important; }
            .hero-title { font-size: 2.25rem; margin-bottom: 15px; }
            .hero-subtitle { font-size: 1rem; margin-bottom: 25px; }
            .hero-banner { min-height: auto; padding-top: 100px; padding-bottom: 50px; }
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
            .news-scroll-mobile > div:first-child { margin-left: 7.5%; }
            .news-scroll-mobile > div:last-child { margin-right: 7.5%; }

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
    
    @if(session('success_lapor'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999999">
        <div class="toast align-items-center text-bg-success border-0 show shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success_lapor') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="position-fixed top-0 end-0 p-3 mt-5" style="z-index: 9999999">
        <div class="toast align-items-center text-bg-primary border-0 show shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div style="background: white; padding: 6px; border-radius: 12px; display: flex; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-right: 15px;">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 32px; height: 32px; border-radius: 6px; object-fit: contain;">
                </div>
                <div>
                    <span class="navbar-brand-text">KKPO</span>
                    <span class="navbar-brand-sub"><b>BANTEN</b></span>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars text-dark" id="navIcon" style="font-size: 1.5rem;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
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
                        <div class="mt-4 d-flex flex-row justify-content-center justify-content-lg-start gap-2">
                            @auth
                            <button type="button" class="btn btn-danger px-4 py-2 rounded-pill shadow fw-bold hero-btn" data-bs-toggle="modal" data-bs-target="#laporInsidenModal" style="transition: 0.3s; font-size: 0.95rem;">
                                <i class="fas fa-ambulance me-2"></i> Lapor Insiden
                            </button>
                            <button type="button" class="btn btn-primary px-4 py-2 rounded-pill shadow fw-bold hero-btn" data-bs-toggle="modal" data-bs-target="#absenLandingModal" style="transition: 0.3s; background-color: var(--primary-dark); border: none; font-size: 0.95rem;">
                                <i class="fas fa-user-check me-2"></i> Absensi Nakes Jaga
                            </button>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="{{ $hero && $hero->gambar ? asset($hero->gambar) : asset('images/hero-medical.png') }}" alt="Medical Team">
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
    <section id="layanan" class="py-3 py-md-5 bg-white">
        <div class="container py-1 py-md-3">
            <h2 class="section-title">Peran dan Fungsi KKPO</h2>
            <p class="section-subtitle">Mengelola kesehatan dan kesejahteraan pelaku olahraga dalam berbagai event pertandingan dengan sistem terintegrasi.</p>
            
            <div class="row row-cols-1 row-cols-md-5 g-3 mt-4 justify-content-start justify-content-md-center news-scroll-mobile">
                <!-- PREVENT -->
                <div class="col">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card d-flex flex-column align-items-center" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.3s ease;">
                        <div class="icon-wrapper mb-3" style="background: #ccfbf1; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shield-alt" style="font-size: 1.8rem; color: #0d9488;"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2" style="color: #0d9488; letter-spacing: 0.5px;">PREVENT</h4>
                        <p class="text-secondary small mb-0" style="font-size: 0.85rem; line-height: 1.5;">Melakukan pemetaan potensi risiko cedera dan memastikan standar kesiapan medis di setiap venue.</p>
                    </div>
                </div>
                <!-- READY -->
                <div class="col">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card d-flex flex-column align-items-center" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.3s ease;">
                        <div class="icon-wrapper mb-3" style="background: #cffafe; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-medkit" style="font-size: 1.8rem; color: #06b6d4;"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2" style="color: #06b6d4; letter-spacing: 0.5px;">READY</h4>
                        <p class="text-secondary small mb-0" style="font-size: 0.85rem; line-height: 1.5;">Menyiagakan tenaga kesehatan terlatih, alat medis, obat-obatan, dan armada ambulans darurat.</p>
                    </div>
                </div>
                <!-- RESPOND -->
                <div class="col">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card d-flex flex-column align-items-center" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.3s ease;">
                        <div class="icon-wrapper mb-3" style="background: #fef3c7; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-md" style="font-size: 1.8rem; color: #f59e0b;"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2" style="color: #f59e0b; letter-spacing: 0.5px;">RESPOND</h4>
                        <p class="text-secondary small mb-0" style="font-size: 0.85rem; line-height: 1.5;">Memberikan penilaian cepat (assessment) dan tindakan pertolongan medis awal yang akurat.</p>
                    </div>
                </div>
                <!-- REFER -->
                <div class="col">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card d-flex flex-column align-items-center" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.3s ease;">
                        <div class="icon-wrapper mb-3" style="background: #fee2e2; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-ambulance" style="font-size: 1.8rem; color: #ef4444;"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2" style="color: #ef4444; letter-spacing: 0.5px;">REFER</h4>
                        <p class="text-secondary small mb-0" style="font-size: 0.85rem; line-height: 1.5;">Sistem rujukan terpadu dan cepat ke fasilitas kesehatan berdasarkan tingkat kegawatdaruratan.</p>
                    </div>
                </div>
                <!-- REPORT -->
                <div class="col">
                    <div class="text-center p-4 h-100 shadow-sm fitur-card d-flex flex-column align-items-center" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; transition: transform 0.3s ease;">
                        <div class="icon-wrapper mb-3" style="background: #d1fae5; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-medical-alt" style="font-size: 1.8rem; color: #10b981;"></i>
                        </div>
                        <h4 class="fw-bold fs-5 mb-2" style="color: #10b981; letter-spacing: 0.5px;">REPORT</h4>
                        <p class="text-secondary small mb-0" style="font-size: 0.85rem; line-height: 1.5;">Pencatatan rekam medis yang terintegrasi, serta monitoring dan evaluasi penanganan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section id="berita" class="py-5" style="background-color: var(--bg-light);">
        <div class="container">
            <h2 class="section-title">Berita & Informasi Terkini</h2>
            <p class="section-subtitle">Pantau terus perkembangan persiapan tim medis KKPO dalam menyambut Porprov VII Banten 2026.</p>
            
            <div class="row g-4 news-scroll-mobile">
                @forelse($berita as $item)
                <div class="col-md-4">
                    <div class="news-card">
                        <div class="news-img-wrap">
                            @if($item->gambar)
                                <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}">
                            @else
                                <img src="{{ asset('images/news-placeholder.png') }}" alt="{{ $item->judul }}">
                            @endif
                        </div>
                        <div class="news-body">
                            <div class="news-meta">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                            <h3 class="news-title">{{ $item->judul }}</h3>
                            <p class="news-text">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                            <a href="javascript:void(0)" class="btn-readmore" data-bs-toggle="modal" data-bs-target="#beritaModal{{ $item->id }}">Selengkapnya <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Berita Modal -->
                <div class="modal fade" id="beritaModal{{ $item->id }}" tabindex="-1" aria-labelledby="beritaModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                            <div class="modal-header border-0 pb-0 pe-4 pt-4">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-4 px-md-5 pb-5 pt-2">
                                <div class="text-center mb-4">
                                    <div class="news-meta mb-2" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                                    <h3 class="fw-bold" style="color: #0f172a; line-height: 1.4;">{{ $item->judul }}</h3>
                                </div>
                                
                                @if($item->gambar)
                                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="img-fluid rounded mb-4 w-100" style="max-height: 400px; object-fit: cover;">
                                @endif
                                
                                <div class="berita-content" style="color: #334155; line-height: 1.8; font-size: 1.05rem;">
                                    {!! $item->konten !!}
                                </div>
                                
                                <div class="mt-5 text-center">
                                    <button class="btn btn-outline-primary" style="border-radius: 8px; padding: 10px 24px; font-weight: 600; transition: all 0.3s ease;" onclick="copyBeritaLink({{ $item->id }}, this)">
                                        <i class="fas fa-share-alt me-2"></i> Bagikan Berita
                                    </button>
                                </div>
                            </div>
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
    <section id="kegiatan" class="py-5" style="background-color: var(--bg-light);">
        <div class="container">
            <h2 class="section-title">Daftar Jadwal Tanding</h2>
            <p class="section-subtitle">Informasi jadwal pertandingan yang didukung oleh tim medis KKPO.</p>
            
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-body p-3 p-md-4">
                    <form action="{{ url('/#kegiatan') }}" method="GET">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-3 col-md-6 mb-3">
                                <input type="text" name="filter_kegiatan" class="form-control form-control-lg" placeholder="Cari Kegiatan..." value="{{ request('filter_kegiatan') }}" style="font-size: 0.95rem;">
                            </div>
                            <div class="col-12 col-lg-2 col-md-6 mb-3">
                                <select name="filter_kelompok_cabor" id="filter_kelompok_cabor" class="form-select form-select-lg" style="font-size: 0.95rem;">
                                    <option value="" data-kode="">Semua Kelompok...</option>
                                    @foreach($kelompokCabors as $kc)
                                        <option value="{{ $kc->nama }}" data-kode="{{ $kc->kode }}" {{ request('filter_kelompok_cabor') == $kc->nama ? 'selected' : '' }}>{{ $kc->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-2 col-md-6 mb-3">
                                <select name="filter_cabor" id="filter_cabor" class="form-select form-select-lg" style="font-size: 0.95rem;">
                                    <option value="" data-kelompok="">Semua Cabor...</option>
                                    @foreach($cabors as $c)
                                        <option value="{{ $c->nama }}" data-kelompok="{{ $c->kelompok_kode }}" {{ request('filter_cabor') == $c->nama ? 'selected' : '' }}>{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-2 col-md-6 mb-3">
                                <input type="date" name="filter_tanggal" class="form-control form-control-lg" value="{{ request('filter_tanggal') }}" style="font-size: 0.95rem;" placeholder="Pilih Tanggal">
                            </div>
                            <div class="col-12 col-lg-3 col-md-12 mb-3">
                                <div class="d-flex flex-wrap gap-2" style="gap: 0.5rem;">
                                    <button type="submit" class="btn btn-primary btn-lg flex-fill text-nowrap px-2" style="font-size: 0.9rem;"><i class="fas fa-search me-1"></i> Filter</button>
                                    @if(request('filter_kegiatan') || request('filter_cabor') || request('filter_kelompok_cabor') || request('filter_tanggal'))
                                        <a href="{{ url('/#kegiatan') }}" class="btn btn-outline-secondary btn-lg flex-fill text-nowrap px-2" style="font-size: 0.9rem;"><i class="fas fa-undo me-1"></i> Reset</a>
                                    @endif
                                    <a href="{{ route('jadwal-tanding.cetak', request()->query()) }}" target="_blank" class="btn btn-danger btn-lg flex-fill text-nowrap px-2" style="font-size: 0.9rem;"><i class="fas fa-file-pdf me-1"></i> Cetak</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive bg-white shadow-sm mobile-table-wrapper" style="border-radius: 16px; overflow: hidden; border: 1px solid rgba(130,168,199,0.2);">
                <table class="table table-hover align-middle mb-0 mobile-table" style="margin: 0; border: none;">
                    <thead style="background: linear-gradient(135deg, var(--primary-teal), var(--primary-dark)); color: white;">
                        <tr>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 15%;">Tanggal</th>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 25%;">Kegiatan</th>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 20%;">Cabor</th>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 20%;">Venue</th>
                            <th scope="col" class="py-3 px-4 border-0" style="font-weight: 600; width: 20%;">Instansi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal_pertandingans as $item)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td class="py-3 px-4 border-0">
                                <div style="display: inline-flex; align-items: center; background: rgba(130, 168, 199, 0.1); color: var(--primary-dark); padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; white-space: nowrap;">
                                    <i class="fas fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                </div>
                            </td>
                            <td class="py-3 px-4 border-0 fw-bold" style="color: #0f172a;">{{ $item->kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                            <td class="py-3 px-4 border-0" style="color: #475569;">
                                {{ $item->jenis_cabor }} {{ $item->kel_cabor ? '('.$item->kel_cabor.')' : '' }}
                            </td>
                            <td class="py-3 px-4 border-0 text-muted" style="font-size: 0.9rem;">
                                <div><i class="fas fa-map-marker-alt me-2" style="color: #ef4444;"></i>{{ $item->venue }}</div>
                                @if($item->alamat)
                                    <div class="mt-1" style="font-size: 0.8rem; color: #64748b;"><i class="fas fa-building me-2 text-muted"></i>{{ $item->alamat }}</div>
                                @endif
                                @if($item->link_google_map)
                                    <div class="mt-1"><a href="{{ $item->link_google_map }}" target="_blank" class="text-decoration-none" style="font-size: 0.75rem; color: #3b82f6;"><i class="fas fa-map-marked-alt me-1"></i> Google Map</a></div>
                                @endif
                            </td>
                            <td class="py-3 px-4 border-0 text-muted">
                                @if($item->nakesJagas && $item->nakesJagas->count() > 0)
                                    <ul class="list-unstyled mb-0" style="font-size: 0.8rem;">
                                    @foreach($item->nakesJagas->unique('nakes.instansi') as $nj)
                                        <li class="mb-1"><i class="fas fa-hospital me-1 text-success"></i> {{ $nj->nakes->instansi ?? '-' }}</li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span class="text-secondary fst-italic" style="font-size: 0.8rem;">Belum ada instansi</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 border-0 text-muted">
                                <i class="fas fa-folder-open mb-3" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                                <p class="mb-0">Belum ada jadwal tanding.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4" style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $jadwal_pertandingans->appends(request()->query())->fragment('kegiatan')->links('partials.custom-pagination') }}
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section id="kalender" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Kalender Event</h2>
            <p class="section-subtitle">Jadwal kegiatan dan kompetisi olahraga</p>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </section>

    <!-- Cabang Olahraga Section -->
    <section class="py-5 bg-white" style="border-top: 1px solid rgba(0,0,0,0.05);">
        <div class="container position-relative">
            <style>
                .cabor-title-wrapper { border-left: none; padding-left: 0; }
                @media (min-width: 768px) {
                    .cabor-title-wrapper { border-left: 4px solid var(--primary-teal); padding-left: 15px; }
                }
            </style>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                <div class="text-center text-md-start cabor-title-wrapper">
                    <h3 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 1px; font-size: 1.5rem; color: #0f172a;">Cabang Olahraga</h3>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Cabang Olahraga KONI Tangerang Selatan</p>
                </div>
                <div class="d-none d-md-flex gap-2 mt-3 mt-md-0">
                    <button class="btn btn-outline-dark btn-sm rounded-0 border-secondary" onclick="scrollCabor('left')" style="width: 35px; height: 35px;"><i class="fas fa-chevron-left"></i></button>
                    <button class="btn btn-outline-dark btn-sm rounded-0 border-secondary" onclick="scrollCabor('right')" style="width: 35px; height: 35px;"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>

            <style>
                #caborScroll::-webkit-scrollbar { display: none; }
                @media (max-width: 767.98px) {
                    .cabor-scroll-mobile { scroll-snap-type: x mandatory; }
                    .cabor-scroll-mobile > .card { scroll-snap-align: center; min-width: 70% !important; }
                    .cabor-scroll-mobile > .card:first-child { margin-left: 15% !important; }
                    .cabor-scroll-mobile > .card:last-child { margin-right: 15% !important; }
                }
                .cabor-card {
                    min-width: 220px; flex-shrink: 0; background-color: transparent; border-radius: 4px; border: 1px solid rgba(0,0,0,0.05) !important; cursor: pointer; transition: all 0.3s ease;
                }
                .cabor-card:hover {
                    transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
                }
                .cabor-bg {
                    width: 60px; height: 60px; background-color: #cbd5e1; border-radius: 50%; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                }
                .cabor-card:hover .cabor-bg {
                    transform: scale(8); background-color: var(--primary-dark);
                }
                .cabor-icon {
                    font-size: 3rem; color: var(--primary-dark); z-index: 2; transition: all 0.3s ease;
                }
                .cabor-card:hover .cabor-icon {
                    color: #ffffff; transform: scale(1.1);
                }
            </style>
            <div id="caborScroll" class="d-flex gap-3 overflow-auto pb-2 cabor-scroll-mobile" style="scroll-behavior: smooth; scrollbar-width: none; -ms-overflow-style: none; padding-top: 10px; padding-bottom: 20px;">
                @foreach($cabors as $c)
                @php
                    $n = strtolower($c->nama);
                    if (str_contains($n, 'bola') && !str_contains($n, 'basket') && !str_contains($n, 'voli')) $icon = 'fa-futbol';
                    elseif (str_contains($n, 'futsal')) $icon = 'fa-futbol';
                    elseif (str_contains($n, 'renang') || str_contains($n, 'selam') || str_contains($n, 'air')) $icon = 'fa-swimmer';
                    elseif (str_contains($n, 'basket')) $icon = 'fa-basketball-ball';
                    elseif (str_contains($n, 'tangkis')) $icon = 'fa-table-tennis'; // Since FA free lacks shuttlecock
                    elseif (str_contains($n, 'atletik') || str_contains($n, 'lari')) $icon = 'fa-running';
                    elseif (str_contains($n, 'karate') || str_contains($n, 'tarung') || str_contains($n, 'silat') || str_contains($n, 'taekwondo') || str_contains($n, 'judo') || str_contains($n, 'wushu') || str_contains($n, 'mma') || str_contains($n, 'kempo') || str_contains($n, 'kurash') || str_contains($n, 'sambo') || str_contains($n, 'jujitsu')) $icon = 'fa-user-ninja';
                    elseif (str_contains($n, 'tinju')) $icon = 'fa-hand-rock';
                    elseif (str_contains($n, 'panah')) $icon = 'fa-bullseye';
                    elseif (str_contains($n, 'voli')) $icon = 'fa-volleyball-ball';
                    elseif (str_contains($n, 'sepeda') || str_contains($n, 'balap') || str_contains($n, 'motor')) $icon = 'fa-motorcycle';
                    elseif (str_contains($n, 'catur')) $icon = 'fa-chess';
                    elseif (str_contains($n, 'tenis') || str_contains($n, 'pingpong') || str_contains($n, 'pickleball')) $icon = 'fa-table-tennis';
                    elseif (str_contains($n, 'angkat') || str_contains($n, 'bina raga')) $icon = 'fa-dumbbell';
                    elseif (str_contains($n, 'anggar')) $icon = 'fa-khanda';
                    elseif (str_contains($n, 'arum jeram') || str_contains($n, 'dayung')) $icon = 'fa-water';
                    elseif (str_contains($n, 'gymnastic') || str_contains($n, 'senam')) $icon = 'fa-child';
                    elseif (str_contains($n, 'biliard') || str_contains($n, 'bowling')) $icon = 'fa-bowling-ball';
                    elseif (str_contains($n, 'golf') || str_contains($n, 'woodball') || str_contains($n, 'gateball')) $icon = 'fa-golf-ball';
                    elseif (str_contains($n, 'menembak')) $icon = 'fa-crosshairs';
                    elseif (str_contains($n, 'drum')) $icon = 'fa-drum';
                    elseif (str_contains($n, 'esport')) $icon = 'fa-gamepad';
                    elseif (str_contains($n, 'dance')) $icon = 'fa-music';
                    elseif (str_contains($n, 'barongsai')) $icon = 'fa-dragon';
                    elseif (str_contains($n, 'petanque')) $icon = 'fa-dot-circle';
                    elseif (str_contains($n, 'cricket') || str_contains($n, 'softball') || str_contains($n, 'kasti')) $icon = 'fa-baseball-ball';
                    elseif (str_contains($n, 'selancar')) $icon = 'fa-water';
                    else {
                        $fallbacks = ['fa-trophy', 'fa-award', 'fa-star', 'fa-fire', 'fa-bolt', 'fa-flag-checkered', 'fa-shield-alt'];
                        $idx = abs(crc32($n)) % count($fallbacks);
                        $icon = $fallbacks[$idx];
                    }
                @endphp
                <div class="card shadow-sm cabor-card" onclick="showCaborModal('{{ $c->nama }}')">
                    <div class="bg-white d-flex align-items-center justify-content-center position-relative" style="height: 130px; border-radius: 4px 4px 0 0; overflow: hidden;">
                        <!-- Circle behind icon -->
                        <div class="position-absolute cabor-bg" style="z-index: 1;"></div>
                        <!-- Icon -->
                        <i class="fas {{ $icon }} position-relative cabor-icon"></i>
                    </div>
                    <div class="text-center py-2 position-relative" style="background-color: #e2e8f0; border-top: 1px solid #94a3b8; z-index: 3;">
                        <span class="fw-bold text-uppercase" style="font-size: 0.9rem; letter-spacing: 0.5px; color: var(--text-main);">{{ $c->nama }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <script>
            function scrollCabor(direction) {
                const container = document.getElementById('caborScroll');
                const scrollAmount = 240; 
                if(direction === 'left') {
                    container.scrollLeft -= scrollAmount;
                } else {
                    container.scrollLeft += scrollAmount;
                }
            }
        </script>
    </section>

    <!-- Event Detail Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-0 px-4 pt-4 pb-0">
                    <h5 class="modal-title fw-bold d-flex align-items-center" id="eventModalLabel" style="color: #1e293b; font-size: 1.15rem;">
                        <div class="d-flex justify-content-center align-items-center me-3" style="width: 36px; height: 36px; background-color: #f1f5f9; border-radius: 10px; color: #64748b;">
                            <i class="fas fa-calendar-day" style="font-size: 1rem;"></i>
                        </div>
                        Detail Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.5;"></button>
                </div>
                <div class="modal-body px-4 py-4" id="eventModalBody">
                    <!-- Event Details will be injected here -->
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn w-100 fw-bold" data-bs-dismiss="modal" style="background-color: #f8fafc; color: #475569; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 0; transition: 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9';" onmouseout="this.style.backgroundColor='#f8fafc';">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cabor Info Modal -->
    <div class="modal fade" id="caborModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="modal-title fw-bold text-uppercase" id="caborModalTitle" style="color: var(--primary-dark); letter-spacing: 1px;">Info Cabor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.5;"></button>
                </div>
                <div class="modal-body px-4 py-4" id="caborModalBody">
                    <div class="text-center py-5" id="caborLoading">
                        <div class="spinner-border" style="color: var(--primary-teal);" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="caborContent" style="display: none;">
                        <div class="row g-3 mb-4">
                            <!-- Stats Cards -->
                            <div class="col-md-4">
                                <div class="p-4 rounded-4 text-center h-100 shadow-sm" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0;">
                                    <i class="fas fa-running mb-2" style="font-size: 2rem; color: #16a34a;"></i>
                                    <h3 class="fw-bold mb-0" style="color: #166534; font-size: 2.2rem;" id="caborAtlitCount">0</h3>
                                    <span class="text-uppercase" style="font-size: 0.85rem; color: #15803d; font-weight: 700; letter-spacing: 0.5px;">Atlit</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-4 rounded-4 text-center h-100 shadow-sm" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe;">
                                    <i class="fas fa-user-tie mb-2" style="font-size: 2rem; color: #2563eb;"></i>
                                    <h3 class="fw-bold mb-0" style="color: #1e40af; font-size: 2.2rem;" id="caborPelatihCount">0</h3>
                                    <span class="text-uppercase" style="font-size: 0.85rem; color: #1d4ed8; font-weight: 700; letter-spacing: 0.5px;">Pelatih</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-4 rounded-4 text-center h-100 shadow-sm" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a;">
                                    <i class="fas fa-users-cog mb-2" style="font-size: 2rem; color: #d97706;"></i>
                                    <h3 class="fw-bold mb-0" style="color: #92400e; font-size: 2.2rem;" id="caborKoniCount">0</h3>
                                    <span class="text-uppercase" style="font-size: 0.85rem; color: #b45309; font-weight: 700; letter-spacing: 0.5px;">Pengurus / KONI</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-4 shadow-sm" style="border: 1px solid #f1f5f9;">
                            <div class="d-flex justify-content-between align-items-center mb-3" style="border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                                <h5 class="fw-bold mb-0 d-flex align-items-center" style="color: #334155; font-size: 1.15rem;">
                                    <div class="d-flex justify-content-center align-items-center me-3" style="width: 32px; height: 32px; background-color: #f1f5f9; border-radius: 8px; color: #64748b;">
                                        <i class="fas fa-calendar-check" style="font-size: 0.9rem;"></i>
                                    </div>
                                    Jadwal Tanding
                                </h5>
                                <a href="#" id="caborCetakPdfBtn" target="_blank" class="btn btn-danger btn-sm" style="display: none; border-radius: 6px;"><i class="fas fa-file-pdf me-1"></i> Cetak PDF</a>
                            </div>
                            <div id="caborJadwalContainer" style="max-height: 250px; overflow-y: auto;">
                                <!-- Jadwal list injected here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showCaborModal(caborName) {
            let modalEl = document.getElementById('caborModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }
            document.getElementById('caborModalTitle').innerText = caborName;
            document.getElementById('caborLoading').style.display = 'block';
            document.getElementById('caborContent').style.display = 'none';
            modal.show();

            fetch(`/api/cabor-info?cabor=${encodeURIComponent(caborName)}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('caborAtlitCount').innerText = data.atlit;
                    document.getElementById('caborPelatihCount').innerText = data.pelatih;
                    document.getElementById('caborKoniCount').innerText = data.koni;
                    
                    let jadwalHtml = '';
                    if(data.jadwals && data.jadwals.length > 0) {
                        jadwalHtml = '<div class="list-group list-group-flush">';
                        data.jadwals.forEach((j, jIndex) => {
                            jadwalHtml += `
                                <div class="list-group-item bg-white p-3 border-bottom" style="border-color: #f1f5f9;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="pe-3 flex-grow-1">
                                            <div class="fw-bold mb-1" style="font-size:0.95rem; color: #1e293b;">${j.kegiatan}</div>
                                            <div class="d-flex align-items-center mt-1" style="font-size:0.75rem; color: #64748b;">
                                                <i class="fas fa-calendar-alt me-2" style="color: #cbd5e1;"></i><span>${j.tanggal}${j.waktu ? ' - ' + j.waktu : ''}</span>
                                            </div>
                                            ${j.venue ? `
                                            <div class="d-flex align-items-center mt-1" style="font-size:0.75rem; color: #64748b;">
                                                <i class="fas fa-map-marker-alt me-2" style="color: #cbd5e1;"></i><span>${j.venue}</span>
                                            </div>` : ''}
                                            ${j.alamat ? `
                                            <div class="d-flex align-items-start mt-1" style="font-size:0.75rem; color: #64748b;">
                                                <i class="fas fa-building me-2 mt-1" style="color: #cbd5e1;"></i><span>${j.alamat}</span>
                                            </div>` : ''}
                                        </div>
                                        <div class="text-end d-flex flex-column align-items-end justify-content-start">
                                            ${j.link_google_map ? `
                                            <div class="mb-2">
                                                <a href="${j.link_google_map}" target="_blank" class="text-decoration-none" style="font-size: 0.7rem; color: #3b82f6;">
                                                    <i class="fas fa-map-marked-alt me-1"></i> Google Map
                                                </a>
                                            </div>` : ''}
                                            ${j.nakes_jagas && j.nakes_jagas.length > 0 ? `
                                            <div class="mt-2 text-end">
                                                <a href="#collapseCaborNakes-${jIndex}" data-bs-toggle="collapse" class="text-decoration-none" style="font-size: 0.7rem; font-weight: 600; color: #82a8c7; transition: 0.2s;">
                                                    <i class="fas fa-user-md me-1"></i> Tim Medis <i class="fas fa-chevron-down ms-1" style="font-size:0.6rem;"></i>
                                                </a>
                                            </div>` : ''}
                                        </div>
                                    </div>
                                    ${j.nakes_jagas && j.nakes_jagas.length > 0 ? `
                                    <div class="collapse mt-2 pt-2 border-top" id="collapseCaborNakes-${jIndex}" style="border-color: #f1f5f9 !important;">
                                        ${j.nakes_jagas.map(nj => {
                                            var spekHtml = (nj.spesialisasi && nj.spesialisasi.toLowerCase() !== 'dokter umum') ? ' <span style="color: #94a3b8;">(' + nj.spesialisasi + ')</span>' : '';
                                            return '<div class="d-inline-block rounded px-2 py-1 me-1 mb-1" style="background-color: #f8fafc; font-size: 0.75rem; border: 1px solid #e2e8f0;">' + 
                                                '<span class="fw-bold" style="color: #334155;">' + (nj.instansi || '-') + '</span>' + spekHtml + 
                                            '</div>';
                                        }).join('')}
                                    </div>` : ''}
                                </div>
                            `;
                        });
                        jadwalHtml += '</div>';
                        
                        document.getElementById('caborCetakPdfBtn').href = "{{ route('jadwal-tanding.cetak') }}?filter_cabor=" + encodeURIComponent(caborName);
                        document.getElementById('caborCetakPdfBtn').style.display = 'inline-block';
                    } else {
                        document.getElementById('caborCetakPdfBtn').style.display = 'none';
                        jadwalHtml = `
                            <div class="text-center py-4 rounded-3 mt-2" style="background-color: #f8fafc; border: 1px dashed #cbd5e1;">
                                <i class="fas fa-box-open mb-2" style="font-size: 2rem; color: #cbd5e1;"></i>
                                <p class="text-muted mb-0 fw-medium">Belum ada jadwal tanding untuk cabor ini.</p>
                            </div>
                        `;
                    }
                    
                    document.getElementById('caborJadwalContainer').innerHTML = jadwalHtml;
                    document.getElementById('caborLoading').style.display = 'none';
                    document.getElementById('caborContent').style.display = 'block';
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('caborJadwalContainer').innerHTML = '<p class="text-danger text-center py-3 fw-medium">Terjadi kesalahan saat memuat data. Silakan coba lagi.</p>';
                    document.getElementById('caborLoading').style.display = 'none';
                    document.getElementById('caborContent').style.display = 'block';
                });
        }
    </script>

    <!-- Lapor Insiden Modal -->
    <div class="modal fade" id="laporInsidenModal" tabindex="-1" aria-labelledby="laporInsidenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-bottom px-4 pt-4 pb-3" style="border-color: #f1f5f9 !important;">
                    <h5 class="modal-title fw-bold d-flex align-items-center" id="laporInsidenModalLabel" style="color: #1e293b; font-size: 1.25rem;">
                        <div class="d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px; background-color: #fef2f2; border-radius: 12px; color: #ef4444;">
                            <i class="fas fa-briefcase-medical" style="font-size: 1.1rem;"></i>
                        </div>
                        Lapor Insiden Cedera
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.5;"></button>
                </div>
                <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 p-md-5 bg-white">
                        <p class="text-muted mb-4" style="font-size: 0.9rem;">Mohon isi formulir di bawah ini dengan lengkap untuk pelaporan cepat kejadian cedera atlet di lapangan.</p>
                        
                        <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Nama Atlet <span class="text-danger">*</span></label>
                                    <select name="pelaku_olahraga_id" class="form-select select2-lapor w-100" required>
                                        <option value="">-- Cari dan Pilih Atlet --</option>
                                        @foreach($atlits as $atlit)
                                            <option value="{{ $atlit->id }}">{{ $atlit->nama }} ({{ $atlit->cabor }} - {{ $atlit->kontingen }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Waktu Kejadian <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="waktu_kejadian" class="form-control" value="{{ date('Y-m-d\TH:i') }}" style="border-radius: 8px; padding: 10px 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155; height: 45px;" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Kegiatan (Jadwal Pertandingan) <span class="text-danger">*</span></label>
                                    <select name="jadwal_pertandingan_id" class="form-select select2-jadwal-lapor w-100" required>
                                        <option value="">-- Pilih Jadwal --</option>
                                        @foreach(\App\JadwalPertandingan::whereDate('tanggal', \Carbon\Carbon::today())->orderBy('waktu', 'asc')->get() as $jadwal)
                                            <option value="{{ $jadwal->id }}">
                                                {{ $jadwal->jenis_cabor }} - {{ $jadwal->waktu }} - {{ $jadwal->venue }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Bagian yang Cedera <span class="text-danger">*</span></label>
                                    <input type="text" name="bagian_cedera" class="form-control" placeholder="Misal: Pergelangan Kaki Kanan" style="border-radius: 8px; padding: 10px 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155; height: 45px;" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Penanganan Pertama</label>
                                    <input type="text" name="penanganan" class="form-control" placeholder="Contoh: Kompres Es & Perban" style="border-radius: 8px; padding: 10px 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155; height: 45px;">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Kronologis Kejadian <span class="text-danger">*</span></label>
                                    <textarea name="kronologis" class="form-control" rows="4" placeholder="Ceritakan secara singkat bagaimana cedera terjadi..." style="border-radius: 8px; padding: 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155;" required></textarea>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Keterangan Tambahan</label>
                                    <textarea name="keterangan" class="form-control" rows="4" placeholder="Informasi lain yang diperlukan..." style="border-radius: 8px; padding: 15px; border-color: #cbd5e1; font-size: 0.9rem; color: #334155;"></textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Ambil Foto Bukti/Kondisi</label>
                                    <div class="card border border-2 border-dashed shadow-sm">
                                        <div class="card-body text-center bg-light rounded" style="position: relative; min-height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                            <video id="webcamLapor" autoplay playsinline style="width: 100%; max-width: 400px; border-radius: 8px; display: none;"></video>
                                            <canvas id="canvasLapor" style="width: 100%; max-width: 400px; border-radius: 8px; display: none;"></canvas>
                                            
                                            <div id="webcamPlaceholderLapor" class="my-3">
                                                <i class="fas fa-camera fa-3x text-muted mb-2"></i>
                                                <p class="text-muted mb-0 small">Kamera akan aktif saat tombol ditekan</p>
                                            </div>

                                            <input type="hidden" name="foto_base64" id="fotoBase64Lapor">

                                            <div class="mt-3">
                                                <button type="button" class="btn btn-outline-primary rounded-pill fw-bold" id="btnStartCameraLapor">
                                                    <i class="fas fa-video me-1"></i> Buka Kamera
                                                </button>
                                                <button type="button" class="btn btn-primary rounded-pill fw-bold" id="btnSnapLapor" style="display: none;">
                                                    <i class="fas fa-camera me-1"></i> Ambil Foto
                                                </button>
                                                <button type="button" class="btn btn-warning rounded-pill fw-bold" id="btnRetakeLapor" style="display: none;">
                                                    <i class="fas fa-redo me-1"></i> Ulangi
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer border-top px-4 py-3" style="border-color: #f1f5f9 !important; background-color: #ffffff;">
                        <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 10px; color: #64748b; background-color: #f8fafc; border: 1px solid #e2e8f0; height: 45px; transition: 0.2s;" onmouseover="this.style.backgroundColor='#e2e8f0';" onmouseout="this.style.backgroundColor='#f8fafc';">Batal</button>
                        <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 10px; background-color: #ef4444; border: none; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2); transition: 0.2s; height: 45px;" onmouseover="this.style.transform='translateY(-1px)';" onmouseout="this.style.transform='translateY(0)';">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Absen Landing Modal -->
    <div class="modal fade" id="absenLandingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background-color: var(--primary-teal); color: white; border-bottom: none;">
                    <h5 class="modal-title fw-bold"><i class="fas fa-user-check me-2"></i> Absensi Nakes Jaga</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="absenLandingForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-white">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Pilih Jadwal Jaga <span class="text-danger">*</span></label>
                                <select id="nakesJagaSelect" class="form-select select2-absen w-100" required onchange="updateAbsenAction(this.value)">
                                    <option value="">-- Cari Jadwal & Venue --</option>
                                    @foreach($nakes_jaga_list as $nj)
                                        @php
                                            $displayCabor = $nj->jadwalPertandingan ? $nj->jadwalPertandingan->jenis_cabor : $nj->cabor;
                                            $displayVenue = $nj->jadwalPertandingan ? $nj->jadwalPertandingan->venue : $nj->venue;
                                        @endphp
                                        <option value="{{ $nj->id }}">{{ \Carbon\Carbon::parse($nj->tanggal)->format('d M') }} - {{ $displayCabor }} ({{ $displayVenue }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama Anda">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Instansi / Tim</label>
                                <input type="text" name="instansi" class="form-control" placeholder="Contoh: Puskesmas Pamulang">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Nama Bank</label>
                                <input type="text" name="bank" class="form-control" placeholder="Contoh: BCA, BNI, Mandiri">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">No. Rekening</label>
                                <input type="text" name="norek" class="form-control" placeholder="Nomor Rekening Anda">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan opsional..."></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Tanda Tangan (Wajib)</label>
                                <div class="border rounded bg-light" style="position: relative;">
                                    <canvas id="signatureCanvas" style="width: 100%; height: 150px; cursor: crosshair; touch-action: none;"></canvas>
                                </div>
                                <div class="mt-2 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="btnClearSignature"><i class="fas fa-eraser me-1"></i> Bersihkan</button>
                                </div>
                                <input type="hidden" name="tanda_tangan_base64" id="tandaTanganBase64" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary" style="font-size: 0.85rem;">Ambil Foto Kehadiran (Wajib)</label>
                                <div class="camera-wrapper rounded bg-dark position-relative overflow-hidden mb-2" style="height: 250px; display: flex; align-items: center; justify-content: center;">
                                    <video id="webcam" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
                                    <canvas id="canvas" style="display: none; width: 100%; height: 100%; object-fit: cover;"></canvas>
                                </div>
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button" id="btnSnap" class="btn btn-sm btn-primary rounded-pill px-3"><i class="fas fa-camera me-1"></i> Ambil Foto</button>
                                    <button type="button" id="btnRetake" class="btn btn-sm btn-warning rounded-pill px-3" style="display: none;"><i class="fas fa-redo me-1"></i> Ulangi</button>
                                </div>
                                <input type="hidden" name="foto_base64" id="fotoBase64" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light" style="border-top: 1px solid #e2e8f0;">
                        <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold" style="background-color: var(--primary-teal); border: none;">Simpan Absen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function updateAbsenAction(id) {
            var form = document.getElementById('absenLandingForm');
            if(id) {
                form.action = "{{ url('/public/nakes-jaga') }}/" + id + "/absen";
            } else {
                form.action = "";
            }
        }

        // Webcam Logic
        let webcamStream;
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const btnSnap = document.getElementById('btnSnap');
        const btnRetake = document.getElementById('btnRetake');
        const fotoBase64 = document.getElementById('fotoBase64');
        const absenModal = document.getElementById('absenLandingModal');

        absenModal.addEventListener('shown.bs.modal', function () {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } })
                .then(function (stream) {
                    webcamStream = stream;
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function (error) {
                    console.error("Camera access denied!", error);
                    alert("Akses kamera tidak diizinkan atau tidak didukung di perangkat ini.");
                });
            }
        });

        absenModal.addEventListener('hidden.bs.modal', function () {
            if (webcamStream) {
                webcamStream.getTracks().forEach(track => track.stop());
            }
            video.style.display = 'block';
            canvas.style.display = 'none';
            btnSnap.style.display = 'inline-block';
            btnRetake.style.display = 'none';
            fotoBase64.value = '';
        });

        btnSnap.addEventListener('click', function() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Add Timestamp Watermark
            const now = new Date();
            const timestamp = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const fontSize = Math.max(14, Math.floor(canvas.width * 0.035));
            context.font = "bold " + fontSize + "px Arial";
            const textWidth = context.measureText(timestamp).width;
            
            // Background
            context.fillStyle = "rgba(0, 0, 0, 0.6)";
            context.fillRect(10, canvas.height - (fontSize + 20), textWidth + 20, fontSize + 12);
            
            // Text
            context.fillStyle = "#FFEB3B";
            context.fillText(timestamp, 20, canvas.height - 15);
            
            const imageData = canvas.toDataURL('image/jpeg');
            fotoBase64.value = imageData;

            video.style.display = 'none';
            canvas.style.display = 'block';
            btnSnap.style.display = 'none';
            btnRetake.style.display = 'inline-block';
        });

        btnRetake.addEventListener('click', function() {
            video.style.display = 'block';
            canvas.style.display = 'none';
            btnSnap.style.display = 'inline-block';
            btnRetake.style.display = 'none';
            fotoBase64.value = '';
        });

        // Signature Pad Logic
        const sigCanvas = document.getElementById('signatureCanvas');
        const sigCtx = sigCanvas.getContext('2d');
        const btnClearSig = document.getElementById('btnClearSignature');
        const tandaTanganBase64 = document.getElementById('tandaTanganBase64');
        let isDrawing = false;

        function resizeCanvas() {
            const ratio =  Math.max(window.devicePixelRatio || 1, 1);
            sigCanvas.width = sigCanvas.offsetWidth * ratio;
            sigCanvas.height = sigCanvas.offsetHeight * ratio;
            sigCtx.scale(ratio, ratio);
        }
        
        absenModal.addEventListener('shown.bs.modal', function () {
            resizeCanvas();
        });

        function getMousePos(canvasDom, mouseEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: mouseEvent.clientX - rect.left,
                y: mouseEvent.clientY - rect.top
            };
        }

        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }

        function renderCanvas() {
            if (isDrawing) {
                sigCtx.stroke();
            }
        }

        sigCanvas.addEventListener("mousedown", function (e) {
            isDrawing = true;
            var mousePos = getMousePos(sigCanvas, e);
            sigCtx.beginPath();
            sigCtx.moveTo(mousePos.x, mousePos.y);
            e.preventDefault();
        }, false);
        sigCanvas.addEventListener("mouseup", function (e) { isDrawing = false; saveSignature(); }, false);
        sigCanvas.addEventListener("mousemove", function (e) {
            if (isDrawing) {
                var mousePos = getMousePos(sigCanvas, e);
                sigCtx.lineTo(mousePos.x, mousePos.y);
                sigCtx.stroke();
            }
            e.preventDefault();
        }, false);
        
        sigCanvas.addEventListener("touchstart", function (e) {
            isDrawing = true;
            var touchPos = getTouchPos(sigCanvas, e);
            sigCtx.beginPath();
            sigCtx.moveTo(touchPos.x, touchPos.y);
            e.preventDefault();
        }, false);
        sigCanvas.addEventListener("touchend", function (e) { isDrawing = false; saveSignature(); }, false);
        sigCanvas.addEventListener("touchmove", function (e) {
            if (isDrawing) {
                var touchPos = getTouchPos(sigCanvas, e);
                sigCtx.lineTo(touchPos.x, touchPos.y);
                sigCtx.stroke();
            }
            e.preventDefault();
        }, false);

        btnClearSig.addEventListener('click', function() {
            sigCtx.clearRect(0, 0, sigCanvas.width, sigCanvas.height);
            tandaTanganBase64.value = '';
        });

        function saveSignature() {
            tandaTanganBase64.value = sigCanvas.toDataURL('image/png');
        }

        document.getElementById('absenLandingForm').addEventListener('submit', function(e) {
            if (!tandaTanganBase64.value) {
                e.preventDefault();
                alert('Tanda tangan wajib diisi!');
            }
        });


        // Webcam Logic for Lapor Insiden
        let webcamStreamLapor;
        const videoLapor = document.getElementById('webcamLapor');
        const canvasLapor = document.getElementById('canvasLapor');
        const btnStartCameraLapor = document.getElementById('btnStartCameraLapor');
        const btnSnapLapor = document.getElementById('btnSnapLapor');
        const btnRetakeLapor = document.getElementById('btnRetakeLapor');
        const fotoBase64Lapor = document.getElementById('fotoBase64Lapor');
        const placeholderLapor = document.getElementById('webcamPlaceholderLapor');
        const laporModal = document.getElementById('laporInsidenModal');

        btnStartCameraLapor.addEventListener('click', function() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then(function (stream) {
                    webcamStreamLapor = stream;
                    videoLapor.srcObject = stream;
                    videoLapor.play();
                    
                    videoLapor.style.display = 'block';
                    placeholderLapor.style.display = 'none';
                    btnStartCameraLapor.style.display = 'none';
                    btnSnapLapor.style.display = 'inline-block';
                })
                .catch(function (error) {
                    console.error("Camera access denied!", error);
                    alert("Akses kamera tidak diizinkan atau tidak didukung di perangkat ini.");
                });
            }
        });

        btnSnapLapor.addEventListener('click', function() {
            canvasLapor.width = videoLapor.videoWidth;
            canvasLapor.height = videoLapor.videoHeight;
            const contextLapor = canvasLapor.getContext('2d');
            contextLapor.drawImage(videoLapor, 0, 0, canvasLapor.width, canvasLapor.height);

            // Add Timestamp Watermark
            const nowLapor = new Date();
            const timestampLapor = nowLapor.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' ' + nowLapor.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const fontSizeLapor = Math.max(14, Math.floor(canvasLapor.width * 0.035));
            contextLapor.font = "bold " + fontSizeLapor + "px Arial";
            const textWidthLapor = contextLapor.measureText(timestampLapor).width;
            
            // Background
            contextLapor.fillStyle = "rgba(0, 0, 0, 0.6)";
            contextLapor.fillRect(10, canvasLapor.height - (fontSizeLapor + 20), textWidthLapor + 20, fontSizeLapor + 12);
            
            // Text
            contextLapor.fillStyle = "#FFEB3B";
            contextLapor.fillText(timestampLapor, 20, canvasLapor.height - 15);
            
            const imageDataLapor = canvasLapor.toDataURL('image/jpeg');
            fotoBase64Lapor.value = imageDataLapor;

            videoLapor.style.display = 'none';
            canvasLapor.style.display = 'block';
            btnSnapLapor.style.display = 'none';
            btnRetakeLapor.style.display = 'inline-block';
        });

        btnRetakeLapor.addEventListener('click', function() {
            videoLapor.style.display = 'block';
            canvasLapor.style.display = 'none';
            btnSnapLapor.style.display = 'inline-block';
            btnRetakeLapor.style.display = 'none';
            fotoBase64Lapor.value = '';
        });

        laporModal.addEventListener('hidden.bs.modal', function () {
            if (webcamStreamLapor) {
                webcamStreamLapor.getTracks().forEach(track => track.stop());
            }
            videoLapor.style.display = 'none';
            canvasLapor.style.display = 'none';
            placeholderLapor.style.display = 'block';
            btnStartCameraLapor.style.display = 'inline-block';
            btnSnapLapor.style.display = 'none';
            btnRetakeLapor.style.display = 'none';
            fotoBase64Lapor.value = '';
        });
    </script>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <div class="footer-logo mb-4">
                <img class="mb-2" src="{{ asset('img/logo-remove.png') }}" alt="Logo" style="width: 48px; height: 48px; object-fit: contain;">
                <h4 class="text-white fw-bold">KKPO Banten</h4>
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
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        // Select2 for Lapor Insiden Modal
        $(document).ready(function() {
            $('.select2-lapor').select2({
                dropdownParent: $('#laporInsidenModal'),
                placeholder: "-- Cari dan Pilih Atlet --",
                allowClear: true
            });
            
            $('.select2-jadwal-lapor').select2({
                dropdownParent: $('#laporInsidenModal'),
                placeholder: "-- Pilih Jadwal --",
                allowClear: true
            });
            
            // Select2 for Absen Landing Modal
            $('.select2-absen').select2({
                dropdownParent: $('#absenLandingModal'),
                placeholder: "-- Cari Jadwal & Venue --",
                allowClear: true
            });
        });

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

        // FullCalendar Initialization
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            if(calendarEl) {
                var rawEvents = @json($calendarEvents ?? []);
                
                // Group by Date for Heat-map
                var eventCounts = {};
                var jadwalCounts = {};
                var eventsByDate = {};
                var khususDates = {};
                
                rawEvents.forEach(function(ev) {
                    var startDate = new Date(ev.start);
                    var endDate = ev.end ? new Date(ev.end) : new Date(startDate.getTime() + 24 * 60 * 60 * 1000); // end is exclusive

                    for (var d = new Date(startDate); d < endDate; d.setDate(d.getDate() + 1)) {
                        var dateString = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
                        if(!eventCounts[dateString]) {
                            eventCounts[dateString] = 0;
                            jadwalCounts[dateString] = 0;
                            eventsByDate[dateString] = [];
                            khususDates[dateString] = false;
                        }
                        if (ev.is_khusus) {
                            khususDates[dateString] = true;
                        }
                        eventCounts[dateString]++;
                        
                        // Count matches only if they fall on this day
                        var matchesToday = 0;
                        if (ev.jadwals) {
                            ev.jadwals.forEach(function(j) {
                                if (j.tanggal === dateString) {
                                    matchesToday++;
                                }
                            });
                        }
                        jadwalCounts[dateString] += matchesToday;
                        eventsByDate[dateString].push(ev);
                    }
                });
                
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'id',
                    initialView: 'dayGridMonth',
                    initialDate: '2026-11-01',
                    contentHeight: 'auto', // Mencegah kalender memiliki scrollbar internal
                    headerToolbar: {
                        left: 'prev',
                        center: 'title',
                        right: 'next'
                    },
                    dayMaxEvents: true,
                    eventDisplay: 'none', // Hide default event dots/blocks
                    dayCellDidMount: function(arg) {
                        if (arg.isOther) return; 
                        
                        var d = arg.date;
                        var dateString = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
                        var eCount = eventCounts[dateString] || 0;
                        var jCount = jadwalCounts[dateString] || 0;
                        
                        var bgColor = '';
                        var borderColor = '';
                        
                        var colorCount = jCount > 0 ? jCount : (eCount > 0 ? 1 : 0);

                        if (khususDates[dateString]) {
                            bgColor = '#f97316'; // Orange for khusus
                            borderColor = '#ea580c';
                        } else {
                            if(colorCount == 1) { bgColor = 'rgba(130, 168, 199, 0.2)'; }
                            else if(colorCount == 2) { bgColor = 'rgba(130, 168, 199, 0.4)'; }
                            else if(colorCount == 3) { bgColor = 'rgba(130, 168, 199, 0.6)'; }
                            else if(colorCount == 4) { bgColor = 'rgba(130, 168, 199, 0.8)'; }
                            else if(colorCount >= 5) { bgColor = '#82a8c7'; }
                        }

                        if(arg.isToday) {
                            if(eCount > 0) {
                                bgColor = '#1e3a8a';
                                borderColor = '#1e3a8a';
                            } else {
                                bgColor = 'transparent';
                                borderColor = '#1e3a8a';
                            }
                        }

                        if(bgColor || borderColor) {
                            arg.el.style.setProperty('--cell-bg', bgColor || 'transparent');
                            arg.el.style.setProperty('--cell-border', borderColor || bgColor || '#e2e8f0');
                        }
                    },
                    dayCellContent: function(arg) {
                        if (arg.isOther) {
                            return { html: '<div class="cal-day-num" style="color: #cbd5e1;">' + arg.dayNumberText.replace('日', '') + '</div>' };
                        }

                        var d = arg.date;
                        var dateString = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
                        var eCount = eventCounts[dateString] || 0;
                        var jCount = jadwalCounts[dateString] || 0;
                        var colorCount = jCount > 0 ? jCount : (eCount > 0 ? 1 : 0);
                        
                        var textColor = colorCount >= 5 ? '#ffffff' : (colorCount > 0 ? '#1e293b' : '#0f172a');
                        if (khususDates[dateString]) {
                            textColor = '#ffffff'; // White text on orange bg
                        }
                        
                        if (arg.isToday) { 
                            textColor = eCount > 0 ? '#ffffff' : '#1e3a8a'; 
                        }
                        
                        var html = '<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; height:100%;">';
                        html += '<div class="cal-day-num" style="color: '+textColor+';">' + arg.dayNumberText.replace('日', '') + '</div>';
                        if(jCount > 0) {
                            html += '<div class="cal-day-text" style="color: '+textColor+';">' + jCount + ' lomba</div>';
                        }
                        html += '</div>';
                        return { html: html };
                    },
                    dateClick: function(info) {
                        var dateString = info.dateStr;
                        var events = eventsByDate[dateString];
                        
                        if(events && events.length > 0) {
                            var hasKhusus = events.some(function(e) { return e.is_khusus; });
                            var eventsToShow = events.filter(function(ev) {
                                if (hasKhusus && !ev.is_khusus) {
                                    var jadwalsToday = ev.jadwals ? ev.jadwals.filter(function(j) { return j.tanggal === dateString; }) : [];
                                    return jadwalsToday.length > 0;
                                }
                                return true;
                            });
                            
                            if (eventsToShow.length === 0) eventsToShow = events;

                            var modalBody = '';
                            eventsToShow.forEach(function(ev, evIndex) {
                                var isLastEvent = evIndex === eventsToShow.length - 1;
                                modalBody += '<div class="' + (isLastEvent ? '' : 'mb-4 border-bottom pb-4') + '">';
                                modalBody += '<h5 class="fw-bold mb-2" style="color: #0f172a; font-size: 1.25rem;">' + ev.title + '</h5>';
                                if (ev.lokasi && ev.lokasi !== '-') {
                                    modalBody += '<div class="d-flex align-items-center mb-1"><i class="fas fa-map-marker-alt me-2" style="width: 15px; color: #64748b;"></i><span style="color: #475569; font-size: 0.85rem;">' + ev.lokasi + '</span></div>';
                                }

                                
                                let tmp = document.createElement("DIV");
                                tmp.innerHTML = ev.deskripsi || 'Tidak ada deskripsi.';
                                modalBody += '<div class="mt-3 p-3 rounded-3 mb-4" style="background-color: #f8fafc; border: 1px solid #f1f5f9; color: #475569; font-size: 0.85rem; line-height: 1.5;">' + (tmp.textContent || tmp.innerText) + '</div>';
                                
                                // Daftar Jadwal Pertandingan
                                if (ev.jadwals && ev.jadwals.length > 0) {
                                    var jadwalsToday = ev.jadwals.filter(function(j) {
                                        return j.tanggal === dateString;
                                    });
                                    if (jadwalsToday.length > 0) {
                                        modalBody += '<div class="d-flex align-items-center mb-3"><h6 class="fw-bold mb-0 text-uppercase" style="font-size:0.7rem; letter-spacing:1px; color:#94a3b8;"><i class="fas fa-list-ul me-2"></i>Jadwal Pertandingan</h6></div>';
                                        modalBody += '<ul class="list-group list-group-flush border overflow-hidden shadow-sm mb-2" style="border-radius: 12px; border-color: #e2e8f0 !important;">';
                                        jadwalsToday.forEach(function(jadwal, jIndex) {
                                            var isLastJadwal = jIndex === jadwalsToday.length - 1;
                                            var waktu = jadwal.waktu ? jadwal.waktu : 'TBA';
                                        var cabor = jadwal.jenis_cabor ? jadwal.jenis_cabor : 'Cabang Olahraga';
                                        
                                        var venueHTML = jadwal.venue ? 
                                            '<div class="d-flex align-items-center mt-1" style="font-size:0.75rem; color: #64748b;"><i class="fas fa-map-pin me-2" style="color: #cbd5e1;"></i><span>' + jadwal.venue + '</span></div>' : '';
                                            
                                        if (jadwal.alamat) {
                                            venueHTML += '<div class="d-flex align-items-start mt-1" style="font-size:0.75rem; color: #64748b;"><i class="fas fa-building me-2 mt-1" style="color: #cbd5e1;"></i><span>' + jadwal.alamat + '</span></div>';
                                        }
                                        
                                        var mapHTML = '';
                                        if (jadwal.link_google_map) {
                                            mapHTML = '<div class="mb-2"><a href="' + jadwal.link_google_map + '" target="_blank" class="text-decoration-none" style="font-size: 0.7rem; color: #3b82f6;"><i class="fas fa-map-marked-alt me-1"></i> Google Map</a></div>';
                                        }
                                        
                                        var nakesToggle = '';
                                        var nakesContent = '';
                                        if (jadwal.nakes_jagas && jadwal.nakes_jagas.length > 0) {
                                            var collapseId = 'collapseNakes-' + evIndex + '-' + jIndex;
                                            
                                            nakesToggle = '<div class="mt-2 text-end"><a href="#' + collapseId + '" data-bs-toggle="collapse" class="text-decoration-none" style="font-size: 0.7rem; font-weight: 600; color: #82a8c7; transition: 0.2s;"><i class="fas fa-user-md me-1"></i> Tim Medis <i class="fas fa-chevron-down ms-1" style="font-size:0.6rem;"></i></a></div>';
                                            
                                            nakesContent += '<div class="collapse mt-2 pt-2 border-top" id="' + collapseId + '" style="border-color: #f1f5f9 !important;">';
                                            jadwal.nakes_jagas.forEach(function(nj) {
                                                nakesContent += '<div class="d-inline-block rounded px-2 py-1 me-1 mb-1" style="background-color: #f8fafc; font-size: 0.75rem; border: 1px solid #e2e8f0;">';
                                                var spekHtml = (nj.spesialisasi && nj.spesialisasi.toLowerCase() !== 'dokter umum') ? ' <span style="color: #94a3b8;">(' + nj.spesialisasi + ')</span>' : '';
                                                nakesContent += '<span class="fw-bold" style="color: #334155;">' + nj.instansi + '</span>' + spekHtml;
                                                nakesContent += '</div>';
                                            });
                                            nakesContent += '</div>';
                                        }
                                        
                                        modalBody += '<li class="list-group-item bg-white p-3 ' + (isLastJadwal ? 'border-bottom-0' : '') + '" style="border-color: #f1f5f9;">';
                                        modalBody += '<div class="d-flex justify-content-between align-items-start">';
                                        modalBody += '<div class="pe-3 flex-grow-1">';
                                        modalBody += '<div class="fw-bold mb-1" style="font-size:0.95rem; color: #1e293b;">' + cabor + '</div>';
                                        modalBody += venueHTML;
                                        modalBody += '</div>';
                                        modalBody += '<div class="text-end d-flex flex-column align-items-end justify-content-start">';
                                        modalBody += mapHTML;
                                        modalBody += nakesToggle;
                                        modalBody += '</div>';
                                        modalBody += '</div>';
                                        modalBody += nakesContent;
                                        modalBody += '</li>';
                                    });
                                    modalBody += '</ul>';
                                    }
                                }
                                
                                modalBody += '</div>';
                            });
                            
                            document.getElementById('eventModalBody').innerHTML = modalBody;
                            
                            var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                            myModal.show();
                        }
                    }
                });
                calendar.render();
            }
        });
    </script>
    <script>
        function copyBeritaLink(id, btn) {
            const link = window.location.origin + window.location.pathname + '?berita=' + id;
            navigator.clipboard.writeText(link).then(function() {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check me-2"></i> Tersalin!';
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-success', 'text-white');
                
                setTimeout(function() {
                    btn.innerHTML = originalHtml;
                    btn.classList.remove('btn-success', 'text-white');
                    btn.classList.add('btn-outline-primary');
                }, 2000);
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            });
        }

        // Auto-open modal if ?berita=id is in URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const beritaId = urlParams.get('berita');
            if (beritaId) {
                const modalId = 'beritaModal' + beritaId;
                const modalElement = document.getElementById(modalId);
                if (modalElement) {
                    const myModal = new bootstrap.Modal(modalElement);
                    myModal.show();
                    // Optional: remove query param from URL without refreshing
                    // window.history.replaceState({}, document.title, window.location.pathname);
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var kelompokSelect = document.getElementById('filter_kelompok_cabor');
            var caborSelect = document.getElementById('filter_cabor');
            
            if (kelompokSelect && caborSelect) {
                var caborOptions = Array.from(caborSelect.options);
                
                function filterCabor() {
                    var selectedKelompokOption = kelompokSelect.options[kelompokSelect.selectedIndex];
                    var selectedKode = selectedKelompokOption.getAttribute('data-kode');
                    
                    var currentSelectedValue = caborSelect.value;
                    var valueStillAvailable = false;
                    
                    caborSelect.innerHTML = '';
                    
                    caborOptions.forEach(function(option) {
                        if (option.value === "") {
                            caborSelect.appendChild(option.cloneNode(true));
                        } else if (!selectedKode || option.getAttribute('data-kelompok') === selectedKode) {
                            var newOption = option.cloneNode(true);
                            if (newOption.value === currentSelectedValue) {
                                newOption.selected = true;
                                valueStillAvailable = true;
                            }
                            caborSelect.appendChild(newOption);
                        }
                    });
                    
                    if (!valueStillAvailable) {
                        caborSelect.value = "";
                    }
                }
                
                kelompokSelect.addEventListener('change', filterCabor);
                
                // Initialize on load
                filterCabor();
            }
        });
    </script>
</body>
</html>
