@extends('layouts.index')
@extends('timpanitiakegiatan.sidebar')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Event</h1>

        <!-- Form untuk mengedit event -->
        <form action="{{ url('/panitia-kegiatan/events/'.$event['event_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Untuk HTTP PUT method -->

            <div class="card shadow-lg p-4">
                <h4 class="mb-4">Event Information</h4>

                <!-- Event Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Event Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $event['name'] }}" required>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label for="date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::parse($event['date'])->format('Y-m-d') }}" required>
                </div>

                <!-- Time -->
                <div class="mb-3">
                    <label for="time" class="form-label">Event Time</label>
                    <input type="time" class="form-control" name="time" value="{{ \Carbon\Carbon::parse($event['time'])->format('H:i') }}" required>
                </div>

                <!-- Location -->
                <div class="mb-3">
                    <label for="location" class="form-label">Event Location</label>
                    <input type="text" class="form-control" name="location" value="{{ $event['location'] }}" required>
                </div>

                <!-- Speaker -->
                <div class="mb-3">
                    <label for="speaker" class="form-label">Speaker</label>
                    <input type="text" class="form-control" name="speaker" value="{{ $event['speaker'] }}" required>
                </div>

                <!-- Registration Fee -->
                <div class="mb-3">
                    <label for="registration_fee" class="form-label">Registration Fee</label>
                    <input type="number" class="form-control" name="registration_fee" value="{{ $event['registration_fee'] }}" required>
                </div>

                <!-- Max Participants -->
                <div class="mb-3">
                    <label for="max_participants" class="form-label">Max Participants</label>
                    <input type="number" class="form-control" name="max_participants" value="{{ $event['max_participants'] }}" required>
                </div>

                <!-- Event Poster -->
                <div class="mb-3">
                    <label for="poster_url" class="form-label">Event Poster</label>
                    <input type="file" class="form-control" name="poster_url">
                    @if($event['poster_url'])
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $event['poster_url']) }}" alt="Current Poster" class="img-thumbnail" style="width: 150px;">
                            <p class="mt-2">Current Poster</p>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update Event</button>
                <a href="{{ url('/panitia-kegiatan/events') }}" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
