<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
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

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #1d3557;
            border-color: #1d3557;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            padding: 12px 24px;
            font-size: 16px;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 12px 24px;
            font-size: 16px;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
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
        <div class="event-card">
            <div class="row">
                <!-- Poster Image -->
                <div class="col-md-6">
                    @if ($event->poster_url)
                        <img src="{{ 'http://localhost:5000/uploads/' . $event->poster_url }}" class="event-img" alt="Event Poster">
                    @else
                        <img src="https://via.placeholder.com/600x400" class="event-img" alt="No Image Available">
                    @endif
                </div>

                <!-- Event Details -->
                <div class="col-md-6">
                    <div class="card-body">
                        <h1 class="card-title">{{ $event->name }}</h1>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}</p>
                        <p><strong>Location:</strong> {{ $event->location }}</p>
                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}</p>
                        <p><strong>Speaker:</strong> {{ $event->speaker }}</p>
                        <p><strong>Registration Fee:</strong> Rp {{ number_format($event->registration_fee, 0, ',', '.') }}</p>
                        <p><strong>Max Participants:</strong> {{ $event->max_participants }}</p>

                        <!-- Check if user is authenticated -->
                        @auth
                            <!-- If authenticated (as a member) -->
                            <form action="{{ route('member.register', $event->event_id ?? $event->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success">Beli Tiket</button>
                            </form>
                        @else
                            <!-- If not authenticated (guest) -->
                            <a href="{{ route('login') }}" class="btn btn-warning">Login untuk Beli Tiket</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
