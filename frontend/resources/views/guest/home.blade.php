<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Guest</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            color: #333;
        }

        .navbar-custom {
            background-color: #1d3557; /* Dark blue background */
        }

        .navbar-custom .navbar-nav .nav-link {
            color: white;
            font-weight: bold;
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            color: #ffc107; /* Yellow hover color */
        }

        .container {
            margin-top: 70px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1d3557;
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
        }

        .card-img-top {
            border-radius: 15px 15px 0 0;
        }

        .card-title {
            font-size: 1.6rem;
            font-weight: bold;
            color: #1d3557;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #1d3557;
            border-color: #1d3557;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #457b9d;
            border-color: #457b9d;
        }

        .btn-warning {
            background-color: #f1c40f;
            border-color: #f1c40f;
            font-weight: bold;
        }

        .btn-warning:hover {
            background-color: #f39c12;
            border-color: #f39c12;
        }

        .btn-success {
            background-color: #2ecc71;
            border-color: #2ecc71;
            font-weight: bold;
        }

        .btn-success:hover {
            background-color: #27ae60;
            border-color: #27ae60;
        }

        .intro-section {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .intro-section h2 {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .intro-section p {
            font-size: 1.2rem;
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
            <div class="collapse navbar-collapse ms-auto" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="intro-section text-center">
            <h2>Selamat datang di Tiketin – Platform untuk Menemukan dan Mengikuti Event Terbaik!</h2>
            <p>Temukan berbagai acara yang menambah wawasan dan pengalaman Anda! Tiketin adalah tempat yang tepat untuk menemukan acara yang menarik, dari seminar hingga konser, dan mempermudah Anda untuk membeli tiket secara langsung.</p>
        </div>

        <!-- Cards Section -->
        <div class="row g-3 mt-5">
            @foreach ($events as $event)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $event['poster_url'] ? 'http://localhost:5000/uploads/' . $event['poster_url'] : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="Event Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event['name'] }}</h5>
                            <p class="card-text">{{ \Carbon\Carbon::parse($event['date'])->format('d-m-Y') }}</p>
                            <p class="card-text">{{ $event['location'] }}</p>
                            
                            <!-- Check if user is authenticated -->
                            @auth
                                <!-- If authenticated (as a member) -->
                                <a href="{{ route('event.show', $event['event_id']) }}" class="btn btn-primary">Lihat Detail</a>
                                <a href="{{ route('buy-ticket', $event['event_id']) }}" class="btn btn-success">Beli Tiket</a>
                            @else
                                <!-- If not authenticated (guest) -->
                                <!-- Jika belum login (guest), gunakan tombol warna kuning -->
                                <a href="{{ route('guest.event.show', $event['event_id']) }}" class="btn btn-warning">Lihat Detail</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
