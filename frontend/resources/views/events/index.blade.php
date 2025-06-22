{{-- resources/views/events/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
</head>
<body>
    <h1>Event List</h1>

    <a href="{{ route('events.create') }}">Create Event</a>
    
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event['name'] }}</td>
                <td>{{ $event['date'] }}</td>
                <td>{{ $event['location'] }}</td>
                <td>
                    <a href="{{ url('/events/'.$event['event_id'].'/edit') }}">Edit</a> |
                    <form action="{{ url('/events/'.$event['event_id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
