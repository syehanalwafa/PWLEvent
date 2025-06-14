<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Tiketin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .register-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }

        .form-control {
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .btn-register {
            background-color: #007bff;
            color: white;
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: none;
        }

        .btn-register:hover {
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

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            animation: fadeInOut 4s ease-in-out;
        }

        .toast-header {
            background-color: #28a745; /* Green for success */
            color: white;
            border-radius: 5px 5px 0 0;
        }

        .toast-body {
            background-color: #f8f9fa; 
            color: #333;
            font-weight: bold;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }
            10% {
                opacity: 1;
                transform: translateX(0);
            }
            90% {
                opacity: 1;
                transform: translateX(0);
            }
            100% {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
</head>
<body>

    <!-- Register Form -->
    <div class="register-container">
        <h2>Register to Tiketin</h2>

        <!-- Register Form -->
        <form id="registerForm">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="btn btn-register">Register</button>
        </form>

        <!-- Display error message if registration fails -->
        <div class="error-message" id="error-message"></div>

        <div class="form-text">
            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>

    <!-- Toast Notification for Success -->
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">Success</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Registrasi berhasil! Anda akan diarahkan ke halaman login.
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    
    <!-- Axios JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Mengambil form dan menangani pengiriman
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();  // Mencegah form untuk submit secara tradisional

            // Ambil data form
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            // Validasi password dan konfirmasi password
            if (password !== password_confirmation) {
                document.getElementById('error-message').innerText = "Password dan konfirmasi password tidak cocok!";
                return;
            }

            // Kirim data ke API Node.js menggunakan Axios
            axios.post('http://localhost:5000/api/auth/register', {
                name: name,
                email: email,
                password: password
            })
            .then(response => {
                // Jika registrasi berhasil, tampilkan notifikasi toast
                const toast = new bootstrap.Toast(document.getElementById('successToast'));
                toast.show();  // Menampilkan toast notification

                setTimeout(function() {
                    window.location.href = "/login";  // Mengarahkan ke halaman login setelah registrasi berhasil
                }, 3000);  // Setelah 3 detik, mengarahkan ke halaman login
            })
            .catch(error => {
                // Log error untuk debugging
                console.log(error);  // Log error secara rinci di konsol browser
                
                // Menampilkan pesan error jika ada
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
