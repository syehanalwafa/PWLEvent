<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Konfirmasi Registrasi Event</h2>

        <div class="alert alert-info">
            Anda akan melakukan registrasi untuk event: <strong>{{ $event->name }}</strong><br>
            Tanggal: {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}<br>
            Lokasi: {{ $event->location }}<br>
            Biaya: Rp {{ number_format($event->registration_fee, 0, ',', '.') }}
        </div>

        <form action="{{ route('member.register', $event->event_id ?? $event->id) }}" method="POST">
            @csrf

            <input type="hidden" name="confirm" value="yes">

            <button type="submit" class="btn btn-success">Ya, Daftar Sekarang</button>
            <a href="{{ route('member.home') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
