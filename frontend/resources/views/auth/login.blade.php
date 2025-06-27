<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tiketin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-container h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 10px;
            padding-left: 40px;
        }

        .form-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .form-text {
            text-align: center;
            margin-top: 15px;
        }

        .form-text a {
            color: #007bff;
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
        }

        .error-message {
            text-align: center;
            color: red;
            font-size: 0.9rem;
            margin-top: -10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2><i class="fas fa-ticket-alt me-2"></i>Login Tiketin</h2>

        @if(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-login">Login</button>
        </form>

        <div class="form-text">
            Belum punya akun? <a href="{{ url('/register') }}">Daftar di sini</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
