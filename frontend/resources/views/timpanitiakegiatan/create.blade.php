@extends('layouts.index')
@extends('timpanitiakegiatan.sidebar')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Create Event</h1>

        <!-- Form untuk membuat event -->
        <form action="{{ url('/panitia-kegiatan/events') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card shadow-lg p-4">
                <h4 class="mb-4">Event Information</h4>

                <!-- Event Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Event Name</label>
                    <input type="text" class="form-control" name="name" required placeholder="Enter Event Name">
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label for="date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" name="date" required>
                </div>

                <!-- Time -->
                <div class="mb-3">
                    <label for="time" class="form-label">Event Time</label>
                    <input type="time" class="form-control" name="time" required>
                </div>

                <!-- Location -->
                <div class="mb-3">
                    <label for="location" class="form-label">Event Location</label>
                    <input type="text" class="form-control" name="location" required placeholder="Enter Event Location">
                </div>

                <!-- Speaker -->
                <div class="mb-3">
                    <label for="speaker" class="form-label">Speaker</label>
                    <input type="text" class="form-control" name="speaker" required placeholder="Enter Speaker Name">
                </div>

                <!-- Registration Fee -->
                <div class="mb-3">
                    <label for="registration_fee" class="form-label">Registration Fee</label>
                    <input type="number" class="form-control" name="registration_fee" required placeholder="Enter Registration Fee">
                </div>

                <!-- Max Participants -->
                <div class="mb-3">
                    <label for="max_participants" class="form-label">Max Participants</label>
                    <input type="number" class="form-control" name="max_participants" required placeholder="Enter Max Participants">
                </div>

                <!-- Event Poster -->
                <div class="mb-3">
                    <label for="poster_url" class="form-label">Event Poster</label>
                    <input type="file" class="form-control" name="poster_url">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
