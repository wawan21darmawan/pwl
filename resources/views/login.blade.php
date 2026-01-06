<!doctype html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Billiard Five Corner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            /* GANTI LINK GAMBAR DI SINI */
            background-image: url("https://png.pngtree.com/thumb_back/fh260/background/20230705/pngtree-d-render-of-snooker-table-billiards-ball-and-player-under-dim-image_3821892.jpg");
            
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            background-attachment: fixed;
            background-color: #0f172a; /* Warna cadangan jika gambar gagal */
        }

        /* Lapisan hitam transparan supaya tulisan jelas */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.6); /* Semakin besar angkanya (0.6), semakin gelap */
            z-index: -1;
        }

        .card {
            background-color: rgba(33, 37, 41, 0.85); /* Transparan dikit */
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body p-4">
                        
                        <div class="text-center mb-4 mt-2">
                            <h3 class="fw-bold text-white">FIVE CORNER</h3>
                            <p class="text-white-50 small">Member Login</p>
                        </div>

                        <form method="POST" action="/login">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" required>
                                <label for="nama">Nama Lengkap</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="text" name="no_telp" class="form-control" id="notelp" placeholder="No Telp" required>
                                <label for="notelp">No. Telepon</label>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">MASUK</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>