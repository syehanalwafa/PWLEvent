@extends('layouts.index')

@section('sidebar')
    @include('timpanitiakegiatan.sidebar')
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Create Event</h1>

    <form action="{{ url('/panitia-kegiatan/events') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-lg p-4">
            <h4 class="mb-4">Event Information</h4>

            <div class="mb-3">
                <label for="name" class="form-label">Event Name</label>
                <input type="text" class="form-control" name="name" required placeholder="Enter Event Name">
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Event Date</label>
                <input type="date" class="form-control" name="date" required>
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Event Time</label>
                <input type="time" class="form-control" name="time" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Event Location</label>
                <input type="text" class="form-control" name="location" required placeholder="Enter Event Location">
            </div>

            <div class="mb-3">
                <label for="speaker" class="form-label">Speaker</label>
                <input type="text" class="form-control" name="speaker" required placeholder="Enter Speaker Name">
            </div>

            <div class="mb-3">
                <label for="registration_fee" class="form-label">Registration Fee</label>
                <input type="number" class="form-control" name="registration_fee" required placeholder="Enter Registration Fee">
            </div>

            <div class="mb-3">
                <label for="max_participants" class="form-label">Max Participants</label>
                <input type="number" class="form-control" name="max_participants" required placeholder="Enter Max Participants">
            </div>

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
@endsection
