<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <title>Meja Reguler | Billiard Five Corner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: url('https://images.unsplash.com/photo-1542380482-3590d9845862?q=80&w=2000&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        body::before {
            content: "";
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: -1;
        }

        .card-meja {
            transition: transform 0.3s, box-shadow 0.3s;
            background: rgba(33, 37, 41, 0.8);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-meja:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
            border-color: #0d6efd;
        }

        .card-meja img {
            height: 160px;
            object-fit: cover;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: rgba(0,0,0,0.8); border-bottom: 1px solid #333;">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase tracking-wide" href="#">
                <i class="bi bi-circle-fill text-primary me-2"></i>Billiard Five Corner
            </a>
            <a href="/dashboard" class="btn btn-outline-light btn-sm rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </nav>

    <div class="container py-5 mt-5">

        <div class="text-center mb-5 pt-4">
            <h2 class="fw-bold text-white display-6">Zona Regular</h2>
            <p class="text-secondary">Pilih meja favoritmu dan mulai permainan!</p>
        </div>

        <div class="row g-4">
            @for ($i = 1; $i <= 12; $i++)
            <div class="col-md-3 col-6">
                <div class="card card-meja rounded-4 overflow-hidden h-100">
                    <div class="position-relative">
                        <img src="https://tse2.mm.bing.net/th/id/OIP.fsa0wESVXvDLNm9cFKx7xwHaE8?pid=Api" class="card-img-top w-100">
                        <span class="position-absolute top-0 end-0 badge bg-success m-2 shadow">Available</span>
                    </div>
                    
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="fw-bold text-white mb-1">Meja {{ sprintf('%02d', $i) }}</h5>
                        <p class="small text-secondary mb-3">Regular Table</p>
                        
                        <button class="btn btn-primary w-100 mt-auto rounded-pill fw-bold"
                            onclick="pilihMeja({{ $i }})">
                            <i class="bi bi-bookmark-check me-1"></i> Booking
                        </button>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <div class="card mt-5 rounded-4 glass-card d-none" id="bookingCard">
            <div class="card-body p-4 p-md-5">

                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
                    <h3 class="fw-bold text-white m-0">
                        <i class="bi bi-ticket-perforated text-warning me-2"></i>
                        Booking Meja <span id="mejaText" class="text-primary"></span>
                    </h3>
                    <button type="button" class="btn-close btn-close-white" onclick="document.getElementById('bookingCard').classList.add('d-none')"></button>
                </div>

                <form action="{{ route('pembayaran') }}" method="POST">
                    @csrf
                    <input type="hidden" name="meja" id="mejaInput">

                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label text-secondary small text-uppercase fw-bold">Tanggal Reservasi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" id="inputTanggal" name="tanggal_reservasi" class="form-control bg-dark border-secondary text-white focus-ring focus-ring-primary"
                                        required min="{{ now()->toDateString() }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small text-uppercase fw-bold">Jam Mulai</label>
                                    <select name="jam_mulai" id="startHour" class="form-select bg-dark border-secondary text-white" onchange="calculateTotal()">
                                        @for ($i = 12; $i <= 23; $i++)
                                            <option value="{{ $i }}">{{ $i }}:00 WIB</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small text-uppercase fw-bold">Jam Selesai</label>
                                    <select name="jam_selesai" id="endHour" class="form-select bg-dark border-secondary text-white" onchange="calculateTotal()">
                                        @for ($i = 13; $i <= 24; $i++)
                                            <option value="{{ $i }}">{{ $i == 24 ? '00:00' : $i.':00' }} WIB</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="bg-dark bg-opacity-50 p-4 rounded-4 border border-secondary h-100 d-flex flex-column justify-content-center text-center">
                                <label class="text-secondary small text-uppercase mb-2">Estimasi Total</label>
                                <input type="text" id="totalPrice" 
                                    class="form-control form-control-lg bg-transparent border-0 text-center fw-bold text-success display-6 p-0 mb-3" 
                                    style="font-size: 1.5rem;"
                                    readonly placeholder="Rp 0">
                                <hr class="border-secondary">
                                <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill fw-bold shadow-lg">
                                    Bayar Sekarang <i class="bi bi-credit-card ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <footer class="text-center py-4 text-secondary mt-5" style="border-top: 1px solid rgba(255,255,255,0.05);">
        <small>© {{ date('Y') }} <span class="text-white fw-bold">Billiard Five Corner</span>. All Rights Reserved.</small>
    </footer>

    <script>
    const hargaPerJam = 25000;
    
    const inputTanggal = document.getElementById('inputTanggal');
    const inputJamMulai = document.getElementById('startHour');
    const inputMeja = document.getElementById('mejaInput');

    function pilihMeja(no) {
        console.log('Meja dipilih:', no);

        const bookingCard = document.getElementById('bookingCard');
        bookingCard.classList.remove('d-none');
        
        let formattedNo = no.toString().padStart(2, '0');
        document.getElementById('mejaText').innerText = formattedNo; 
        
        inputMeja.value = no;

        bookingCard.scrollIntoView({ behavior: 'smooth', block: 'center' });

        calculateTotal();
    
        cekKetersediaan(); 
    }

    inputTanggal.addEventListener('change', cekKetersediaan);

    // Cek Jam Sibuk via AJAX
    function cekKetersediaan() {
        const tanggal = inputTanggal.value;
        const idMeja = inputMeja.value;

        // Reset dropdown 
        const opsiJam = inputJamMulai.querySelectorAll('option');
        opsiJam.forEach(opt => {
            opt.disabled = false;
            opt.innerText = opt.value + ":00 WIB";
            opt.style.color = ""; 
        });

        if (!tanggal || !idMeja) return;

        fetch(`/cek-ketersediaan?id_meja=${idMeja}&tanggal=${tanggal}`)
            .then(response => response.json())
            .then(jamSibuk => {
                console.log("Jam Terpakai:", jamSibuk);

                // Loop semua opsi jam di dropdown
                opsiJam.forEach(opt => {
                    const jam = parseInt(opt.value);

                    // Tampilan saat jam penuh
                    if (jamSibuk.includes(jam)) {
                        opt.disabled = true; 
                        opt.innerText = jam + ":00 (Penuh)"; 
                        opt.style.color = "#dc3545"; 
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Hitung Total Harga
    function calculateTotal() {
        let start = parseInt(document.getElementById('startHour').value);
        let end = parseInt(document.getElementById('endHour').value);
        let output = document.getElementById('totalPrice');

        // Validasi jam
        if (end <= start) {
            output.value = 'Jam Invalid';
            output.classList.remove('text-success');
            output.classList.add('text-danger');
            return;
        }

        let durasi = end - start;

        output.classList.remove('text-danger');
        output.classList.add('text-success');

        let total = durasi * hargaPerJam;
        output.value = 'Rp ' + total.toLocaleString('id-ID');
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>