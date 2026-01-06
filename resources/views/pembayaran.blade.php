<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #0a0e17; min-height: 100vh; font-family: sans-serif; }
        .glass-card { background: rgba(33,37,41,0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; }
        .qr-box { background: #fff; padding: 10px; border-radius: 10px; display: inline-block; }
        .list-group-item { background: transparent; border-color: rgba(255,255,255,0.1); color: #ccc; }
    </style>
</head>

<body>
    <nav class="navbar fixed-top bg-dark bg-opacity-75 border-bottom border-secondary">
        <div class="container">
            <span class="navbar-brand fw-bold"><i class="bi bi-wallet2 text-success me-2"></i>PEMBAYARAN</span>
            <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary rounded-pill d-lg-none"><i class="bi bi-arrow-left"></i></a>
        </div>
    </nav>

    <div class="container py-5" style="margin-top: 60px;">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card glass-card shadow">
                    <div class="card-body p-4 text-center">

                        <h5 class="fw-bold text-white">Scan QRIS</h5>
                        <div class="qr-box my-3">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=BayarBilliard" class="img-fluid rounded">
                        </div>

                        <div class="mb-4">
                            <small class="text-secondary text-uppercase">Total Tagihan</small>
                            <h2 class="fw-bold text-success display-5">Rp {{ number_format($totalHarga, 0, ',', '.') }}</h2>
                            <span class="badge bg-dark border border-secondary text-secondary rounded-pill">Rate: Rp {{ number_format($hargaPerJam) }}/jam</span>
                        </div>

                        <ul class="list-group list-group-flush text-start mb-4 rounded border border-secondary">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tipe</span> 
                                <span class="fw-bold {{ $warnaTeks }}">{{ $tipeRuangan }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Meja</span> <span class="fw-bold text-white">{{ sprintf('%02d', $meja) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tanggal</span> <span class="fw-bold text-white">{{ \Carbon\Carbon::parse($tanggal_reservasi)->translatedFormat('d M Y') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Jam</span> <span class="fw-bold text-white">{{ $jam_mulai }}.00 - {{ $jam_selesai }}.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Durasi</span> <span class="fw-bold text-white">{{ $durasi }} Jam</span>
                            </li>
                        </ul>

                        <form action="{{ route('pembayaran.konfirmasi') }}" method="POST">
                            @csrf
                            <input type="hidden" name="total_bayar" value="{{ $totalHarga }}">
                            <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2 mb-2">
                                <i class="bi bi-check-circle me-1"></i> SAYA SUDAH BAYAR
                            </button>
                            <a href="javascript:history.back()" class="btn btn-outline-secondary w-100 rounded-pill">Batal</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>