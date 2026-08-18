<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Terkirim - KKPO KONI Tangsel</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-remove.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .check-icon {
            width: 80px;
            height: 80px;
            background-color: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="check-icon">
            <i class="fas fa-check"></i>
        </div>
        <h2 class="fw-bold mb-3">Laporan Berhasil Terkirim!</h2>
        <p class="text-muted mb-4">Terima kasih atas laporan Anda. Tim Nakes kami akan segera menindaklanjuti informasi insiden ini.</p>
        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('lapor.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Lapor Lagi</a>
            <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4" style="background-color: #638ab0; border-color: #638ab0;">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
