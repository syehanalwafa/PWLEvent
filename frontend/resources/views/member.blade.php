<h1>Selamat datang Member, {{ session('name') }}</h1>
<form method="POST" action="/logout">@csrf <button>Logout</button></form>
