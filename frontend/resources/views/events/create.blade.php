{{-- resources/views/events/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
</head>
<body>
    <h1>Create Event</h1>

    <form action="{{ url('/events') }}" method="POST">
        @csrf

        <label for="name">Event Name</label>
        <input type="text" name="name" required><br>

        <label for="date">Date</label>
        <input type="date" name="date" required><br>

        <label for="location">Location</label>
        <input type="text" name="location" required><br>

        <label for="speaker">Speaker</label>
        <input type="text" name="speaker" required><br>

        <label for="registration_fee">Registration Fee</label>
        <input type="number" name="registration_fee" required><br>

        <label for="max_participants">Max Participants</label>
        <input type="number" name="max_participants" required><br>

        <button type="submit">Create Event</button>
    </form>
</body>
</html>
