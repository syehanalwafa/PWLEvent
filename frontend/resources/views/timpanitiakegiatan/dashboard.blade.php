@extends('layouts.index')

@section('sidebar')
    @include('timpanitiakegiatan.sidebar')
@endsection

@section('content')
<div class="container mt-4">
    <h2>Daftar Event yang Sudah Dibuat</h2>

    <div class="row">
        @if(count($events) > 0)
            @foreach ($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $event['poster_url'] ? 'http://localhost:5000/uploads/' . $event['poster_url'] : 'https://via.placeholder.com/300' }}" class="card-img-top" alt="Event Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event['name'] }}</h5>
                            <p class="card-text">{{ \Carbon\Carbon::parse($event['date'])->format('d-m-Y') }}</p>
                            <p class="card-text">{{ $event['location'] }}</p>

                            {{-- Tombol Update --}}
                            <a href="{{ url('/panitia-kegiatan/events/'.$event['event_id'].'/edit') }}" class="btn btn-primary">Update</a>

                            {{-- Form Delete --}}
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
@endsection
