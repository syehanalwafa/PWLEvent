@extends('layouts.index')
@extends('timpanitiakegiatan.sidebar')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tim Panitia Kegiatan</title>
    
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJv+5vN5d9+ic1JdWx2e+8gLrF5BPGG2tQzQ5e5fUj4uPpg97/fgyD3QEqft" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h2>Daftar Event yang Sudah Dibuat</h2>

        <div class="row">
            @if(count($events) > 0)
                @foreach ($events as $event)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <!-- Menggunakan gambar event jika ada, jika tidak, gambar placeholder -->
                            <img src="{{ asset('storage/' . $event['poster_url']) ? asset('storage/' . $event['poster_url']) : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="Event Image">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event['name'] }}</h5>
                                <p class="card-text">{{ \Carbon\Carbon::parse($event['date'])->format('d-m-Y') }}</p>
                                <p class="card-text">{{ $event['location'] }}</p>
                                
                                @if($event['poster_url'])
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $event['poster_url']) }}" alt="Event Poster" class="img-fluid">
                                    </div>
                                @endif

                                <!-- Button to Update Event -->
                                <a href="{{ url('/panitia-kegiatan/events/'.$event['event_id'].'/edit') }}" class="btn btn-primary">Update</a>

                                <!-- Form for Deleting Event -->
                                <form action="{{ url('/panitia-kegiatan/events/'.$event['event_id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <p>Tidak ada event yang tersedia.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
