<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Data Reservasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🎱 ADMIN BILLIARD</a>
            <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">Daftar Riwayat Booking</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#ID</th>
                                <th>Tanggal Main</th>
                                <th>Nama Pemesan</th>
                                <th>Rincian Meja</th>
                                <th>Jam Main</th>
                                <th>Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataReservasi as $res)
                                <tr>
                                    <td>#{{ $res->id_reservasi }}</td>
                                    <td>
                                        {{ date('d M Y', strtotime($res->tanggal_reservasi)) }}
                                    </td>
                                    <td class="fw-bold">{{ $res->user->username ?? 'User Dihapus' }}</td>
                                    <td>
                                        @foreach($res->details as $detail)
                                            <div class="mb-1">
                                                <span class="fw-bold">
                                                    Meja {{ $detail->meja->nomor_meja ?? '?' }}
                                                </span>
                                                <br>
                                                <small class="badge bg-light text-secondary border">
                                                    {{ $detail->meja->kategori->nama_kategori ?? 'Umum' }}
                                                </small>
                                            </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach($res->details as $detail)
                                            {{ substr($detail->jam_mulai, 0, 5) }} - {{ substr($detail->jam_selesai, 0, 5) }}
                                        @endforeach
                                    </td>

                                    <td class="fw-bold text-success">
                                        Rp {{ number_format($res->total_bayar, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        Belum ada data reservasi masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>