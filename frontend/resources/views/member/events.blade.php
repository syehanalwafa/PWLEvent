<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
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

        .container {
            margin-top: 50px;
        }

        .event-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 40px;
        }

        .event-img {
            max-width: 100%;
            border-radius: 12px;
        }

        .card-title {
            font-size: 2rem;
            font-weight: 700;
        }

        .btn {
            padding: 12px 24px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Tiketin</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="event-card">
            <div class="row">
                <div class="col-md-6">
                    @if ($event->poster_url)
                        <img src="{{ 'http://localhost:5000/uploads/' . $event->poster_url }}" class="event-img" alt="Event Poster">
                    @else
                        <img src="https://via.placeholder.com/600x400" class="event-img" alt="No Image Available">
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h1 class="card-title">{{ $event->name }}</h1>
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}</p>
                        <p><strong>Lokasi:</strong> {{ $event->location }}</p>
                        <p><strong>Jam:</strong> {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}</p>
                        <p><strong>Pembicara:</strong> {{ $event->speaker }}</p>
                        <p><strong>Biaya Pendaftaran:</strong> Rp {{ number_format($event->registration_fee, 0, ',', '.') }}</p>
                        <p><strong>Maks. Peserta:</strong> {{ $event->max_participants }}</p>

                        @if (Session::get('role') === 'Member')
                            <form action="{{ route('member.register', $event->event_id ?? $event->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success">Beli Tiket</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning">Login untuk Beli Tiket</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
