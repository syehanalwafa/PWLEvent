<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tiket Berhasil Dibeli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center">
            <h1 class="mb-4">Tiket Berhasil Dibeli!</h1>
            <p class="lead">Silakan tunjukkan QR Code ini saat menghadiri acara.</p>

            @if (session('qr_code'))
                <div class="mt-4">
                    <img src="data:image/png;base64,{{ session('qr_code') }}" alt="QR Code">
                </div>
            @else
                <div class="alert alert-warning mt-4">
                    QR Code tidak tersedia.
                </div>
            @endif

            <a href="/member/events" class="btn btn-primary mt-4">Kembali ke Daftar Event</a>
        </div>
    </div>
</body>
</html>
