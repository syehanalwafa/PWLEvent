<h1>Selamat datang Admin, {{ session('name') }}</h1>
<form method="POST" action="/logout">@csrf <button>Logout</button></form>
