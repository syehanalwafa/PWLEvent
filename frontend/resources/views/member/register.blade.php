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
        <h2>Konfirmasi Registrasi Event</h2>

        <div class="alert alert-info">
            Anda akan melakukan registrasi untuk event dengan ID: <strong>{{ $id }}</strong>
        </div>

        <form action="{{ route('member.register', $id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="confirm" class="form-label">Apakah Anda yakin ingin mendaftar event ini?</label>
                <input type="hidden" name="confirm" value="yes">
            </div>

            <button type="submit" class="btn btn-success">Ya, Daftar Sekarang</button>
            <a href="{{ route('member.home') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
