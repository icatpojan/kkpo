<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Insiden Cedera - KKPO KONI Tangsel</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-remove.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 for searchable dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-teal: #82a8c7; 
            --primary-dark: #638ab0;
            --bg-light: #f8fafc;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
        }
        .navbar-brand img {
            height: 40px;
        }
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            padding: 30px;
            margin-top: 40px;
            margin-bottom: 60px;
            border: 1px solid #e2e8f0;
        }
        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
        }
        .btn-primary {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .btn-primary:hover {
            background-color: #4f7396;
            border-color: #4f7396;
        }
        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            color: #212529;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('img/logo-remove.png') }}" alt="Logo" class="me-2">
                <span class="fw-bold" style="color: var(--primary-dark); letter-spacing: -0.5px;">KKPO Banten</span>
            </a>
            <div class="ms-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Login Petugas</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-briefcase-medical fa-2x"></i>
                        </div>
                        <h2 class="fw-bold mb-1">Lapor Insiden Cedera</h2>
                        <p class="text-muted">Formulir pelaporan cepat kejadian cedera atlet di lapangan.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Nama Atlet <span class="text-danger">*</span></label>
                                <select name="pelaku_olahraga_id" class="form-select select2" required>
                                    <option value="">-- Cari dan Pilih Atlet --</option>
                                    @foreach($atlits as $atlit)
                                        <option value="{{ $atlit->id }}">{{ $atlit->nama }} ({{ $atlit->cabor }} - {{ $atlit->kontingen }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Waktu Kejadian <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="waktu_kejadian" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Bagian yang Cedera <span class="text-danger">*</span></label>
                                <input type="text" name="bagian_cedera" class="form-control" placeholder="Misal: Pergelangan Kaki Kanan" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Kronologis Kejadian <span class="text-danger">*</span></label>
                                <textarea name="kronologis" class="form-control" rows="3" placeholder="Ceritakan bagaimana cedera terjadi..." required></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Upload Foto Bukti/Kondisi (Bisa lebih dari 1)</label>
                                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                <small class="text-muted">Format: JPG, PNG. Maksimal 5MB per foto.</small>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Laporan Insiden
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Cari dan Pilih Atlet --",
                allowClear: true
            });
        });
    </script>
</body>
</html>
