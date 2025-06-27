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
            background-color: #1d3557;
        }

        .navbar-custom .navbar-nav .nav-link {
            color: white;
            font-weight: bold;
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            color: #ffc107;
        }

        .navbar-brand {
            font-weight: bold;
            color: white;
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

        .btn-logout {
            border: 1px solid white;
            color: white;
            font-weight: bold;
        }

        .btn-logout:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar with Logout -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Tiketin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form method="POST" action="/logout" class="d-flex">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-logout">Logout</button>
                        </form>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h1>Selamat Datang di Tiketin</h1>

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
                            <a href="{{ route('member.event.show', $event['event_id']) }}" class="btn btn-primary">Lihat Detail</a>
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
