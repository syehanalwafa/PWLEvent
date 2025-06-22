{{-- resources/views/timpanitiakegiatan/edit.blade.php --}}
@extends('layouts.index')
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
        <form action="{{ url('/panitia-kegiatan/events/'.$event['event_id']) }}" method="POST">
            @csrf
            @method('PUT') <!-- Untuk HTTP PUT method -->

            <div class="mb-3">
                <label for="name" class="form-label">Nama Event</label>
                <input type="text" class="form-control" name="name" value="{{ $event['name'] }}" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::parse($event['date'])->format('Y-m-d') }}" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" name="location" value="{{ $event['location'] }}" required>
            </div>

            <div class="mb-3">
                <label for="speaker" class="form-label">Narasumber</label>
                <input type="text" class="form-control" name="speaker" value="{{ $event['speaker'] }}" required>
            </div>

            <div class="mb-3">
                <label for="registration_fee" class="form-label">Biaya Registrasi</label>
                <input type="number" class="form-control" name="registration_fee" value="{{ $event['registration_fee'] }}" required>
            </div>

            <div class="mb-3">
                <label for="max_participants" class="form-label">Jumlah Maksimal Peserta</label>
                <input type="number" class="form-control" name="max_participants" value="{{ $event['max_participants'] }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Event</button>
            <a href="{{ url('/panitia-kegiatan/events') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection