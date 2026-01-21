<!doctype html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Billiard Five Corner</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
      body {
    background: url("{{ asset('image/dashboard.jpg') }}") no-repeat center center fixed;
    background-size: 100% 100%;
    }
        body::before {
            content: ""; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6); z-index: -1;
        }
        .card-img-top { height: 200px; object-fit: cover; }

        .card-hover {
            /* Membuat transisi halus */
            transition: all 0.3s ease-in-out;
        }
        .card-hover:hover {
            /* Mengangkat kartu ke atas */
            transform: translateY(-10px);
            border-color: var(--bs-primary) !important;  
        }

    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-circle-fill text-primary me-2"></i>FIVE CORNER
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <span class="text-light me-3 d-none d-lg-inline">Halo, Player!</span>
                    </li>
                    <li class="nav-item">
                        <a href="/logout" class="btn btn-outline-danger btn-sm rounded-pill px-4">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5 mt-5">
        
        <div class="text-center mb-5 pt-4 text-white">
            <h2 class="display-6 fw-bold">Pilih Area Bermain</h2>
            <p class="text-secondary">Nikmati pengalaman bermain billiard terbaik dengan fasilitas premium</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4 justify-content-center">

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-secondary shadow card-hover">
                    <div class="position-relative">
                        <img src="https://tse4.mm.bing.net/th/id/OIP.Lu_Q1GvIfmnz7PsKGxoBMwHaDt?pid=Api&h=220&P=0" class="card-img-top">
                        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-primary">Rp40k /jam</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold card-title"><i class="bi bi-fire me-2 text-warning"></i>VIP Smoking</h5>
                        <ul class="list-unstyled text-secondary small mb-4">
                            <li class="mb-2"><i class="bi bi-wind text-primary me-2"></i> Air Purifier & AC Dingin</li>
                            <li class="mb-2"><i class="bi bi-couch-fill text-primary me-2"></i> Sofa Premium Exclusive</li>
                            <li><i class="bi bi-music-note-beamed text-primary me-2"></i> Private Audio</li>
                        </ul>
                        <div class="mt-auto d-grid">
                            <a href="{{ route('vip.smoking') }}" class="btn btn-outline-primary rounded-pill">
                                Booking Sekarang <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-secondary shadow card-hover">
                    <div class="position-relative">
                        <img src="https://tse3.mm.bing.net/th/id/OIP.HGw4wTbLjDg1iMdoGCaa_QHaHa?pid=Api&h=220&P=0" class="card-img-top">
                        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-primary">Rp40k /jam</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold card-title"><i class="bi bi-snow2 me-2 text-info"></i>VIP Non-Smoking</h5>
                        <ul class="list-unstyled text-secondary small mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle text-primary me-2"></i> Bebas Asap Rokok</li>
                            <li class="mb-2"><i class="bi bi-wifi text-primary me-2"></i> High Speed WiFi</li>
                            <li><i class="bi bi-tv text-primary me-2"></i> Smart TV 50 Inch</li>
                        </ul>
                        <div class="mt-auto d-grid">
                            <a href="{{ route('vip.non.smoking') }}" class="btn btn-outline-primary rounded-pill">
                                Booking Sekarang <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-secondary shadow card-hover">
                    <div class="position-relative">
                        <img src="https://tse2.mm.bing.net/th/id/OIP.fsa0wESVXvDLNm9cFKx7xwHaE8?pid=Api&h=220&P=0" class="card-img-top">
                        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-primary">Rp25k /jam</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold card-title"><i class="bi bi-joystick me-2 text-success"></i>Reguler Area</h5>
                        <ul class="list-unstyled text-secondary small mb-4">
                            <li class="mb-2"><i class="bi bi-people-fill text-primary me-2"></i> Suasana Ramai & Seru</li>
                            <li class="mb-2"><i class="bi bi-shop text-primary me-2"></i> Dekat Mini Bar</li>
                            <li><i class="bi bi-hdd-stack text-primary me-2"></i> Meja Standard Internasional</li>
                        </ul>
                        <div class="mt-auto d-grid">
                            <a href="{{ route('reguler') }}" class="btn btn-outline-primary rounded-pill">
                                Booking Sekarang <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="text-center py-4 mt-auto bg-dark border-top border-secondary text-secondary">
        <div class="container">
            <small>
                &copy; {{ date('Y') }} <span class="text-white fw-bold">Billiard Five Corner</span>. Play Hard, Win Big.
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>