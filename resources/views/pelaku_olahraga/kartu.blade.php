<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Anggota - {{ $pelaku->nama }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #555;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px;
            margin: 0;
            gap: 30px;
        }
        .card-container {
            /* Standar id card 85.6mm x 54mm */
            width: 85.6mm;
            height: 54mm;
            background: #fff;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            box-sizing: border-box;
            background: linear-gradient(135deg, #eef2ff 0%, #ffffff 40%);
        }
        /* Bagian Belakang Kartu */
        .back-card {
            text-align: center;
        }
        .back-card .logo-center {
            margin-top: 15mm;
            position: relative;
            z-index: 10;
        }
        .back-card .logo-center img {
            width: 18mm;
            height: auto;
            margin-bottom: 2mm;
        }
        .back-card .koni-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 10;
        }
        .back-card .wave-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60%;
            z-index: 1;
        }
        .back-card .wave-bottom svg {
            position: absolute;
            bottom: -2px;
            left: -2px;
            width: calc(100% + 4px);
            height: 100%;
        }

        /* Bagian Depan Kartu */
        .front-card .wave-left {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 75%;
            height: 100%;
            z-index: 1;
        }
        .front-card .wave-left svg {
            position: absolute;
            left: -2px;
            bottom: -2px;
            width: 100%;
            height: calc(100% + 4px);
        }
        .front-card .logo-area {
            position: absolute;
            bottom: 6mm;
            left: 6mm;
            text-align: center;
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            z-index: 10;
            width: 25mm;
        }
        .front-card .logo-area img {
            width: 12mm;
            height: auto;
            margin-bottom: 1mm;
        }
        .front-card .logo-area .koni-text {
            font-size: 7px;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: 0.2px;
        }
        
        .front-card .photo-area {
            position: absolute;
            top: 7mm;
            right: 6mm;
            width: 20mm;
            height: 27mm;
            background-color: #ef4444;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            z-index: 10;
        }
        .front-card .photo-area img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .front-card .info-area {
            position: absolute;
            top: 35mm;
            right: 6mm;
            text-align: right;
            z-index: 10;
            max-width: 48mm;
        }
        .front-card .info-area .name {
            font-size: 13px;
            font-weight: 800;
            color: #111;
            margin: 0 0 2px 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1.1;
        }
        .front-card .info-area .id-text {
            font-size: 8px;
            color: #000;
            margin: 0;
            font-weight: 600;
        }
        .front-card .tiny-info {
            position: absolute;
            bottom: 12mm;
            right: 28mm;
            font-size: 5px;
            color: #305496;
            text-align: right;
            font-weight: 700;
            z-index: 10;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }
        .print-btn, .back-btn {
            padding: 10px 25px;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .print-btn {
            background: #2563eb;
        }
        .back-btn {
            background: #64748b;
        }

        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }
            body {
                background: none;
                padding: 0;
                align-items: flex-start;
                gap: 10mm;
            }
            .card-container {
                box-shadow: none;
                border: 1px dashed #ccc;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .action-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi -->
    <div class="action-buttons">
        <button class="back-btn" onclick="window.close()">Kembali / Tutup</button>
        <button class="print-btn" onclick="window.print()">Cetak Kartu</button>
    </div>

    <!-- Bagian Depan Kartu -->
    <div class="card-container front-card">
        <div class="wave-left">
            <svg viewBox="0 0 300 400" preserveAspectRatio="none">
                <!-- Light Blue -->
                <path d="M0,0 C120,80 280,250 120,400 L0,400 Z" fill="#a5c4e4" opacity="0.6"/>
                <!-- Medium Blue -->
                <path d="M0,60 C100,140 220,300 80,400 L0,400 Z" fill="#5b80b7" opacity="0.8"/>
                <!-- Dark Blue -->
                <path d="M0,130 C80,200 160,330 40,400 L0,400 Z" fill="#305496"/>
            </svg>
        </div>
        
        <div class="logo-area">
            <img src="{{ asset('img/logo-remove.png') }}" alt="Logo">
            <div class="koni-text">KONI {{ strtoupper($pelaku->kontingen ?? 'TANGSEL') }}</div>
        </div>

        <div class="photo-area">
            @if($pelaku->foto)
                <img src="{{ asset($pelaku->foto) }}" alt="Foto {{ $pelaku->nama }}">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($pelaku->nama) }}&background=ef4444&color=fff&size=200" alt="Foto">
            @endif
        </div>
        <div class="info-area">
            <h2 class="name">{{ $pelaku->nama }}</h2>
            <p class="id-text">{{ $pelaku->nomor_anggota ?? 'BELUM ADA' }}</p>
        </div>
    </div>

    <!-- Bagian Belakang Kartu -->
    <div class="card-container back-card">
        <div class="logo-center">
            <img src="{{ asset('img/logo-remove.png') }}" alt="Logo">
        </div>
        <div class="koni-title" style="color: #1e3a8a; text-shadow: 1px 1px 0px #fff;">KONI {{ strtoupper($pelaku->kontingen ?? 'TANGERANG SELATAN') }}</div>
        
        <div class="wave-bottom">
            <svg viewBox="0 0 500 200" preserveAspectRatio="none">
                <!-- Light Blue -->
                <path d="M0,60 C150,140 350,10 500,80 L500,200 L0,200 Z" fill="#a5c4e4" opacity="0.6"/>
                <!-- Medium Blue -->
                <path d="M0,100 C200,180 300,50 500,110 L500,200 L0,200 Z" fill="#5b80b7" opacity="0.8"/>
                <!-- Dark Blue -->
                <path d="M0,150 C250,210 350,100 500,150 L500,200 L0,200 Z" fill="#305496"/>
            </svg>
        </div>
    </div>

</body>
</html>
