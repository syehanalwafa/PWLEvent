<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member - Tiketin</title>
</head>
<body>
<h1>Selamat datang {{ session('role')}}, {{ session('name') }}</h1>


    <!-- Logout Form -->
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
