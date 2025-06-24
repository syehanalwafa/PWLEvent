@extends('layouts.index')

@section('sidebar')
    @include('timpanitiakegiatan.sidebar')
@endsection

@section('content')
    <div class="container py-5">
        <div class="mb-4 text-center">
            <h1 class="fw-bold text-primary">Edit Event</h1>
        </div>

        <form action="{{ url('/panitia-kegiatan/events/'.$event['event_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card bg-white shadow-sm p-4">
                <h4 class="mb-4 text-muted">Event Information</h4>

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

                    @if($event['poster_url'])
                        <div class="text-center mb-3">
                            <p class="fw-semibold">Current Poster</p>
                            <img src="{{ 'http://localhost:5000/uploads/' . $event['poster_url'] }}"
                                 alt="Current Poster"
                                 class="img-thumbnail shadow"
                                 style="max-width: 250px;">
                        </div>
                    @endif

                    <input type="file" class="form-control" name="poster_url">
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ url('/panitia-kegiatan/events') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </div>
            </div>
        </form>
    </div>

@endsection
