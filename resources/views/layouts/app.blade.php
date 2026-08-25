<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KKPO - KONI Tangerang Selatan</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-remove.png') }}?v={{ time() }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
    
    <style>
        :root {
            --primary-teal: #82a8c7; /* Soft Blue */
            --primary-dark: #375773;
            --bg-body: #446b8a;      /* Darker Soft Blue */
            --text-light: #fff;
            --sidebar-width: 260px;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: #334155;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-body);
            color: var(--text-light);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: none;
        }
        .sidebar-scrollable {
            flex: 1;
            overflow-y: auto;
        }
        .sidebar-scrollable::-webkit-scrollbar { display: none; }
        .sidebar-scrollable { -ms-overflow-style: none; scrollbar-width: none; }
        
        .sidebar-bottom {
            padding: 20px 25px;
        }
        
        .sidebar .brand {
            display: flex;
            align-items: center;
            padding: 0 25px;
            margin-bottom: 30px;
            font-weight: 800;
            color: #ffffff;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        .sidebar .brand i { 
            margin-right: 12px; 
            font-size: 1.8rem;
        }

        .accordion-item { border: none; background: transparent; }
        .accordion-button {
            background: transparent !important;
            color: #ffffff !important;
            box-shadow: none !important;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 25px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
        }
        .accordion-button i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
        }
        .accordion-button:not(.collapsed) {
            color: #ffffff !important;
        }
        .accordion-button::after {
            filter: invert(1) brightness(100);
            background-size: 1rem;
        }
        .accordion-body {
            padding: 0 0 10px 0;
        }

        .sidebar a.menu-item {
            color: #f8fafc;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 25px 12px 40px;
            transition: 0.2s;
            font-size: 0.95rem;
            font-weight: 500;
            border-left: 3px solid transparent;
        }
        .sidebar a.menu-item i { 
            width: 24px; 
            font-size: 1.1rem; 
            color: #e2e8f0; 
            margin-right: 12px;
            transition: 0.2s;
        }
        .sidebar a.menu-item:hover, .sidebar a.menu-item.active {
            background: rgba(0,0,0,0.08);
            color: #ffffff;
            border-left-color: #ffffff;
        }
        .sidebar a.menu-item:hover i, .sidebar a.menu-item.active i {
            color: #ffffff;
        }

        /* Topbar in Teal */
        .topbar {
            height: 80px;
            background: rgba(68, 107, 138, 0.95); /* var(--bg-body) with slight transparency */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: none; /* Removed border bottom so it blends with background */
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Scrolled Pill Topbar */
        .topbar.scrolled {
            top: 20px;
            left: calc(var(--sidebar-width) + 40px);
            right: 40px;
            height: 65px;
            background: rgba(68, 107, 138, 0.95); /* Sidebar color with slight transparency */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 50px;
            border-bottom: none;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2); /* Enhanced shadow for floating pill */
            color: white;
            padding: 0 30px;
        }
        .topbar-nav {
            display: flex;
            gap: 30px;
            text-transform: uppercase;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .topbar-nav a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }
        .topbar-nav a:hover, .topbar-nav a.active {
            color: #ffffff;
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .avatar-group {
            display: flex;
            align-items: center;
        }
        .avatar-group img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid var(--primary-teal);
            margin-left: -10px;
            background: #fff;
        }
        .avatar-group img:first-child { margin-left: 0; }
        .member-count {
            font-size: 0.85rem;
            margin-left: 10px;
            font-weight: 500;
        }

        /* Main Content Wrapper (White Card) */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            margin-top: 80px;
            padding: 0 20px 20px 0; /* Space on right and bottom for the teal to show */
            min-height: calc(100vh - 80px);
        }
        .content-card-bg {
            background-color: #f8fafc;
            background-image: 
                linear-gradient(rgba(248, 250, 252, 0.85), rgba(248, 250, 252, 0.85)),
                url('{{ asset("images/bg-pattern.png") }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            border-radius: 40px;
            min-height: calc(100vh - 100px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 40px;
        }

        /* Override inside content */
        .card {
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        /* SaaS Styling Overrides */
        
        /* Buttons */
        .btn { 
            border-radius: 4px !important; 
            font-weight: 600; 
            font-size: 0.85rem; 
            letter-spacing: 0.3px; 
            padding: 10px 20px; 
            box-shadow: none !important;
        }
        .btn-primary { background: #0056b3 !important; color: white !important; border: none !important; }
        .btn-primary:hover { background: #004494 !important; }
        .btn-light { border: 1px solid #e2e8f0 !important; background: #ffffff !important; color: #334155 !important; }
        .btn-light:hover { background: #f8fafc !important; }
        
        /* Table Styles */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border: none !important;
            margin-bottom: 0;
        }
        .table thead th {
            background-color: transparent !important;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            padding: 15px;
        }
        .table tbody td {
            vertical-align: middle;
            font-size: 0.9rem;
            color: #334155;
            font-weight: 500;
            border-bottom: 1px solid #f1f5f9 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            padding: 15px;
        }
        .table tbody tr:nth-child(odd) { background-color: #f8fafc; }
        .table tbody tr:nth-child(even) { background-color: #ffffff; }
        .table tbody tr:hover { background-color: #f1f5f9; }
        
        /* Badges for status */
        .badge { padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; }
        .badge-danger, .badge.bg-danger { background: #fee2e2 !important; color: #ef4444 !important; border: 1px solid #fca5a5; }
        .badge-success, .badge.bg-success { background: #dcfce7 !important; color: #22c55e !important; border: 1px solid #86efac; }
        .badge-info, .badge.bg-info { background: #e0f2fe !important; color: #0ea5e9 !important; border: 1px solid #7dd3fc; }
        .badge-warning, .badge.bg-warning { background: #fef9c3 !important; color: #eab308 !important; border: 1px solid #fde047; }
        
        /* Card container overrides - EXACT MATCH */
        .card {
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            box-shadow: none !important;
            background: #ffffff !important;
            margin-bottom: 25px;
        }
        
        /* Table Styles - EXACT MATCH */
        .table {
            margin-bottom: 0 !important;
            width: 100%;
        }
        .table thead th {
            background-color: #ffffff !important;
            color: #64748b !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 24px !important;
            border-bottom: 1px solid #e2e8f0 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            vertical-align: middle;
        }
        .table tbody td {
            vertical-align: middle;
            font-size: 0.9rem !important;
            color: #475569 !important;
            border-bottom: 1px solid #e2e8f0 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            padding: 18px 24px !important;
        }
        .table tbody tr:last-child td { border-bottom: none !important; }
        
        /* Zebra Striping Exact Match (Odd rows #f8fafc, Even rows white) */
        .table tbody tr:nth-child(odd) td { background-color: #f8fafc !important; }
        .table tbody tr:nth-child(even) td { background-color: #ffffff !important; }
        .table tbody tr:hover td { background-color: #f1f5f9 !important; }

        /* Table Action Buttons */
        .table td .btn.action-btn {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            font-size: 1.1rem !important;
            padding: 6px 10px !important;
            border-radius: 6px !important;
            transition: all 0.2s;
            margin: 0 !important;
        }
        .table td .btn.action-btn i { color: #64748b !important; } /* Default gray icon */
        .table td .btn-outline-primary.action-btn i { color: #3b82f6 !important; } /* Blue */
        .table td .btn-outline-info.action-btn i { color: #0ea5e9 !important; } /* Light Blue */
        .table td .btn-outline-success.action-btn i { color: #22c55e !important; } /* Green */
        .table td .btn-outline-danger.action-btn i { color: #ef4444 !important; } /* Red */

        /* Form Styles */
        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            color: #334155;
            background-color: #ffffff;
            box-shadow: none !important;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            outline: none;
        }
        label {
            font-weight: 500;
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        /* Modal Customization (Vertical Center & SaaS look) */
        .modal-dialog {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }
        @media (min-width: 576px) {
            .modal-dialog { min-height: calc(100% - 3.5rem); }
        }
        .modal-content {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        }
        .modal-header {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.5rem 1.75rem 1rem !important;
        }
        .modal-header .modal-title {
            font-weight: 700;
            color: #0f172a;
            font-size: 1.25rem;
        }
        .modal-body {
            padding: 1.5rem 1.75rem !important;
        }
        .modal-footer {
            border-top: 1px solid #f1f5f9 !important;
            padding: 1rem 1.75rem !important;
            background-color: #f8fafc;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }
        .modal-footer .btn {
            border-radius: 6px;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
        }

        /* Card container overrides */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: none !important;
            background: #ffffff;
        }
        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 20px;
            font-weight: 700;
            color: #1e293b;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; z-index: 1050; }
            .sidebar.active { transform: translateX(0); box-shadow: 5px 0 25px rgba(0,0,0,0.5); }
            .main-wrapper { margin-left: 0; padding: 0 10px 10px 10px; }
            .topbar { left: 0; padding: 0 20px; }
            .topbar.scrolled { left: 10px; right: 10px; top: 10px; padding: 0 20px; }
            .content-card-bg { border-radius: 20px; padding: 20px; }
        }
        
        /* Mobile Sidebar Backdrop */
        #sidebar-backdrop {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        #sidebar-backdrop.active {
            opacity: 1;
            visibility: visible;
        }
        /* Preloader Styles */
        .preloader-container {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            z-index: 999999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.6s cubic-bezier(0.8, 0, 0.2, 1), visibility 0.6s ease;
        }
        .preloader-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .preloader-logo {
            width: 140px;
            height: auto;
            margin-bottom: 15px;
            animation: float-logo 3s ease-in-out infinite;
            mix-blend-mode: multiply; /* Removes white background from image */
        }
        .preloader-bar-container {
            width: 140px;
            height: 4px;
            background: rgba(130, 168, 199, 0.2);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        .preloader-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 50%;
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
        .preloader-hidden {
            opacity: 0;
            visibility: hidden;
        }
        /* Pagination Styling */
        .pagination {
            gap: 5px;
            margin-bottom: 0;
        }
        .pagination .page-item .page-link {
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            color: #475569;
            font-weight: 500;
            background-color: transparent;
            transition: all 0.2s ease;
        }
        .pagination .page-item:not(.active) .page-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            color: #fff;
            box-shadow: 0 4px 6px -1px rgba(13, 110, 253, 0.2);
        }
        .pagination .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: transparent;
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

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop" class="d-md-none" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Close button for mobile -->
        <div class="d-md-none d-flex justify-content-end w-100" style="padding: 15px 15px 0 0;">
            <button class="btn btn-link text-white p-0" style="text-decoration: none;" onclick="toggleSidebar()">
                <i class="fas fa-times fs-4"></i>
            </button>
        </div>
        <div class="sidebar-scrollable">
            <a href="{{ url('/') }}" class="brand d-md-flex pt-3 pt-md-4" style="padding-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 15px; text-decoration: none;">
                <div style="background: white; padding: 6px; border-radius: 12px; display: flex; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 32px; height: 32px; border-radius: 6px; object-fit: contain;">
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-start; line-height: 1.1;">
                    <span style="font-weight: 900; font-size: 1.5rem; letter-spacing: 1px; color: #ffffff;">KKPO</span>
                    <span style="font-weight: 700; font-size: 0.7rem; letter-spacing: 2px; color: #cbd5e1; text-transform: uppercase;">Tangsel</span>
                </div>
            </a>
            <a class="mt-4" href="{{ route('home') }}" style="text-decoration:none; color: #ffffff; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 25px; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); display: flex; align-items: center; transition: 0.2s; {{ request()->routeIs('home') ? 'background: rgba(0,0,0,0.08);' : '' }}" onmouseover="this.style.background='rgba(0,0,0,0.08)'" onmouseout="this.style.background='{{ request()->routeIs('home') ? 'rgba(0,0,0,0.08)' : 'transparent' }}'">
                <i class="fas fa-home" style="width: 24px; font-size: 1.1rem; margin-right: 12px;"></i> Dashboard
            </a>
            <div class="accordion accordion-flush" id="sidebarAccordion">
                <!-- Manajemen Web -->
                @if(auth()->user()->role === 'admin')
                @php $isManajemen = request()->routeIs('hero.*', 'tentang.*', 'struktur.*', 'berita.*', 'hasil-pertandingan.*'); @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingManajemen">
                        <button class="accordion-button {{ $isManajemen ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseManajemen" aria-expanded="{{ $isManajemen ? 'true' : 'false' }}" aria-controls="collapseManajemen">
                            <i class="fas fa-folder"></i> Manajemen Web
                        </button>
                    </h2>
                    <div id="collapseManajemen" class="accordion-collapse collapse {{ $isManajemen ? 'show' : '' }}" aria-labelledby="headingManajemen" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <a href="{{ route('hero.index') }}" class="menu-item {{ request()->routeIs('hero.*') ? 'active' : '' }}">Pengaturan Web</a>
                            <a href="{{ route('hasil-pertandingan.index') }}" class="menu-item {{ request()->routeIs('hasil-pertandingan.*') ? 'active' : '' }}">Hasil & Medali</a>
                            <a href="{{ route('tentang.index') }}" class="menu-item {{ request()->routeIs('tentang.*') ? 'active' : '' }}">Tentang KKPO</a>
                            <a href="{{ route('struktur.index') }}" class="menu-item {{ request()->routeIs('struktur.*') ? 'active' : '' }}">Struktur</a>
                            <a href="{{ route('berita.index') }}" class="menu-item {{ request()->routeIs('berita.*') ? 'active' : '' }}">Berita</a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Master Kegiatan -->
                @if(in_array(auth()->user()->role, ['admin', 'ketua_panitia', 'kabid_kesehatan', 'koni']))
                @php $isKegiatan = request()->routeIs('kegiatan.*', 'jadwal-pertandingan.*', 'kkpo-sebanten.*'); @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingKegiatan">
                        <button class="accordion-button {{ $isKegiatan ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKegiatan" aria-expanded="{{ $isKegiatan ? 'true' : 'false' }}" aria-controls="collapseKegiatan">
                            <i class="fas fa-calendar-alt"></i> Master Kegiatan
                        </button>
                    </h2>
                    <div id="collapseKegiatan" class="accordion-collapse collapse {{ $isKegiatan ? 'show' : '' }}" aria-labelledby="headingKegiatan" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <a href="{{ route('kegiatan.index') }}" class="menu-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">Kegiatan</a>
                            <a href="{{ route('jadwal-pertandingan.index') }}" class="menu-item {{ request()->routeIs('jadwal-pertandingan.*') ? 'active' : '' }}">Jadwal Tanding</a>
                            <a href="{{ route('kkpo-sebanten.index') }}" class="menu-item {{ request()->routeIs('kkpo-sebanten.*') ? 'active' : '' }}">KKPO Se-Banten</a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Pelaku Olahraga -->
                @php $isPelaku = request()->routeIs('pelaku.*'); @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPelaku">
                        <button class="accordion-button {{ $isPelaku ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePelaku" aria-expanded="{{ $isPelaku ? 'true' : 'false' }}" aria-controls="collapsePelaku">
                            <i class="fas fa-users"></i> Pelaku Olahraga
                        </button>
                    </h2>
                    <div id="collapsePelaku" class="accordion-collapse collapse {{ $isPelaku ? 'show' : '' }}" aria-labelledby="headingPelaku" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <a href="{{ route('pelaku.index', 'atlit') }}" class="menu-item {{ request()->is('pelaku-olahraga/atlit*') ? 'active' : '' }}">Atlit</a>
                            <a href="{{ route('pelaku.index', 'pelatih') }}" class="menu-item {{ request()->is('pelaku-olahraga/pelatih*') ? 'active' : '' }}">Pelatih</a>
                            <a href="{{ route('pelaku.index', 'official') }}" class="menu-item {{ request()->is('pelaku-olahraga/official*') ? 'active' : '' }}">Official</a>
                            <a href="{{ route('pelaku.index', 'koni') }}" class="menu-item {{ request()->is('pelaku-olahraga/koni*') ? 'active' : '' }}">KONI</a>
                        </div>
                    </div>
                </div>

                <!-- Accident -->
                <a href="{{ route('accident.cedera') }}" style="text-decoration:none; color: #ffffff; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 25px; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); display: flex; align-items: center; transition: 0.2s; {{ request()->routeIs('accident.*') ? 'background: rgba(0,0,0,0.08);' : '' }}" onmouseover="this.style.background='rgba(0,0,0,0.08)'" onmouseout="this.style.background='{{ request()->routeIs('accident.*') ? 'rgba(0,0,0,0.08)' : 'transparent' }}'">
                    <i class="fas fa-briefcase-medical" style="width: 24px; font-size: 1.1rem; margin-right: 12px;"></i> Data Cedera
                </a>

                <!-- Nakes -->
                @if(in_array(auth()->user()->role, ['admin', 'ketua_panitia', 'kabid_kesehatan', 'koni']))
                @php $isNakes = request()->routeIs('nakes-jaga.*', 'master-nakes.*', 'nakes-absen.*'); @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNakes">
                        <button class="accordion-button {{ $isNakes ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNakes" aria-expanded="{{ $isNakes ? 'true' : 'false' }}" aria-controls="collapseNakes">
                            <i class="fas fa-user-md"></i> Nakes
                        </button>
                    </h2>
                    <div id="collapseNakes" class="accordion-collapse collapse {{ $isNakes ? 'show' : '' }}" aria-labelledby="headingNakes" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <a href="{{ route('master-nakes.index') }}" class="menu-item {{ request()->routeIs('master-nakes.*') ? 'active' : '' }}">Koordinator Nakes</a>
                            <a href="{{ route('nakes-jaga.index') }}" class="menu-item {{ request()->routeIs('nakes-jaga.*') ? 'active' : '' }}">Jadwal Jaga</a>
                            <a href="{{ route('nakes-absen.index') }}" class="menu-item {{ request()->routeIs('nakes-absen.*') ? 'active' : '' }}">Absensi</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-light d-md-none me-3" style="border:none;" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-none d-md-flex align-items-center text-white" style="cursor:pointer; opacity:0.8;" onclick="window.history.back();">
                <i class="fas fa-chevron-left me-2" style="font-size:0.8rem;"></i> Back
            </div>
        </div>
        

        <div class="topbar-right d-flex align-items-center">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: inherit;">
                    <div class="user-avatar" style="width:35px; height:35px; border-radius:50%; background:#fff; display:flex; align-items:center; justify-content:center; color:var(--primary-teal); font-weight:bold; font-size:1rem; margin-right:12px; transition: 0.3s; border: 1px solid transparent;">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="me-2 d-none d-md-block">
                        <div class="user-name" style="font-weight:600; font-size:0.85rem; color:#fff; transition: 0.3s; text-align: left;">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="user-role" style="font-size:0.7rem; color:#e2e8f0; transition: 0.3s; text-align: left;">Administrator</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-3" aria-labelledby="dropdownUser" style="border-radius: 12px; padding: 10px 0; min-width: 220px;">
                    <li><a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="font-weight: 500; font-size: 0.9rem;"><i class="fas fa-key me-2 text-muted"></i> Ganti Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-weight: 500; font-size: 0.9rem;">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <div class="content-card-bg">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius:15px;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius:15px;">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Modal Ganti Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="changePasswordModalLabel" style="color: #0f172a;"><i class="fas fa-lock me-2 text-primary"></i> Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('password.change') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Password Saat Ini</label>
                            <input type="password" class="form-control" name="current_password" required style="border-radius: 8px; padding: 10px 15px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" required style="border-radius: 8px; padding: 10px 15px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: #475569;">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="new_password_confirmation" required style="border-radius: 8px; padding: 10px 15px;">
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 8px 20px;">Batal</button>
                        <button type="submit" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; background: var(--primary-teal); border: none;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preloader Logic
        window.addEventListener('load', function() {
            setTimeout(function() {
                const preloader = document.getElementById('preloader');
                if(preloader) {
                    preloader.classList.add('preloader-hidden');
                }
            }, 400); // 400ms delay to ensure smooth transition
        });

        // Topbar scroll effect
        window.addEventListener('scroll', function() {
            const topbar = document.querySelector('.topbar');
            if (window.scrollY > 20) {
                topbar.classList.add('scrolled');
            } else {
                topbar.classList.remove('scrolled');
            }
        });

        // Mobile Sidebar Toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebar-backdrop').classList.toggle('active');
        }
    </script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('scripts')
</body>
</html>
