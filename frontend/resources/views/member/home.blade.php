<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Member</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }

        .navbar-custom {
            background-color: #007bff;
        }

        .navbar-custom .navbar-nav .nav-link {
            color: white;
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            color: #ffc107;
        }

        .card-body {
            background-color: #f9f9f9;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Tiketin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1>Selamat Datang di Sistem Event</h1>
        <p>Anda sedang mengakses sebagai <strong>{{ session('role') }}</strong>.</p>

        <!-- Cards Section -->
        <div class="row">
            @foreach ($events as $event)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $event['poster_url'] ? 'http://localhost:5000/uploads/' . $event['poster_url'] : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="Event Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event['name'] }}</h5>
                            <p class="card-text">{{ \Carbon\Carbon::parse($event['date'])->format('d-m-Y') }}</p>
                            <p class="card-text">{{ $event['location'] }}</p>

                            <!-- Aksi Member -->
<form method="POST" action="/member/events/{{ $event['event_id'] }}/register">
    @csrf
    <button class="btn btn-primary w-100 mb-2">Beli Tiket</button>
</form>
                            <a href="/member/payment/{{ $event['event_id'] }}" class="btn btn-warning w-100">Upload Bukti Pembayaran</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Logout -->
    <form method="POST" action="/logout" class="mt-4 text-center">
        @csrf
        <button class="btn btn-danger">Logout</button>
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
