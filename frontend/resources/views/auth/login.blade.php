<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tiketin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }

        .form-control {
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: none;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .form-text {
            text-align: center;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Login Form -->
    <div class="login-container">
        <h2>Login to Tiketin</h2>

        <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-login">Login</button>
    </form>

        <!-- Display error message if login fails -->
        <div class="error-message" id="error-message"></div>

        <div class="form-text">
            <p>Don't have an account? <a href="{{ url('/register') }}">Register here</a></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    
    <!-- Axios JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Menangani pengiriman form
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();  // Mencegah form untuk submit secara tradisional

            // Ambil data form
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Kirim data ke API Node.js menggunakan Axios
            axios.post('http://localhost:5000/api/auth/login', {
                email: email,
                password: password
            })
            .then(response => {
                // Jika login berhasil, simpan token dan arahkan ke halaman sesuai role
                const { token, redirectUrl } = response.data;

                // Simpan token di localStorage untuk autentikasi lebih lanjut
                localStorage.setItem('token', token);

                // Arahkan ke halaman yang sesuai berdasarkan role
                window.location.href = redirectUrl;  // Redirect ke /admin, /member, /tim-keuangan, atau /panitia-kegiatan
            })
            .catch(error => {
                // Menampilkan pesan error jika ada
                console.log(error);  // Log error secara rinci di konsol browser
                if (error.response) {
                    document.getElementById('error-message').innerText = error.response.data.message;
                } else {
                    document.getElementById('error-message').innerText = 'Terjadi kesalahan, coba lagi nanti.';
                }
            });
        });
    </script>

</body>
</html>
