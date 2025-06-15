<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('guest.home');
});

Route::view('/register', 'guest.register')->name('register');

Route::view('/login', 'auth.login')->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
$response = Http::post('http://localhost:5000/api/auth/login', [
    'email' => $request->email,
    'password' => $request->password,
]);

if ($response->successful()) {
    // Pastikan menggunakan response yang benar dan memparse data JSON dengan baik
    Session::put('token', $response['token']);
    Session::put('role', $response['role']);
    Session::put('name', $response['name']);  // Memastikan 'name' dari JSON disimpan dengan benar
    return redirect($response['redirectUrl']);
}
    return redirect('/login')->with('error', 'Login gagal. Cek email dan password.');
});



// Menampilkan data user
Route::get('/admin', function () {
    // Mengambil data pengguna dengan role 'Tim Keuangan' dan 'Panitia Kegiatan' dari API Node.js
    $response = Http::get('http://localhost:5000/api/admin/users');  // Mengambil pengguna dari API Node.js
    
    if ($response->successful()) {
        $users = $response->json()['users']; // Mengambil data users dari response
        
        // Filter hanya menampilkan pengguna dengan role 'Tim Keuangan' dan 'Panitia Kegiatan'
        $filteredUsers = array_filter($users, function($user) {
            return $user['role'] == 'Tim Keuangan' || $user['role'] == 'panitia pelaksana kegiatan';
        });
        
        return view('administrator.admin', compact('filteredUsers')); // Mengirimkan data ke view
    }
    return redirect('/login')->with('error', 'Gagal mengambil data pengguna');
})->name('admin');

// Menampilkan form untuk menambahkan pengguna (GET)
Route::get('/admin/users/create', function () {
    return view('administrator.create');  // Menampilkan halaman form create pengguna
});

// add User admin
Route::post('/admin/users', function (\Illuminate\Http\Request $request) {
    $response = Http::post('http://localhost:5000/api/admin/users', $request->all());

    if ($response->successful()) {
        return redirect('/admin')->with('success', 'Pengguna berhasil ditambahkan');
    }

    return redirect('/admin')->with('error', 'Gagal menambahkan pengguna');
});


// update
// Route untuk menampilkan form edit pengguna
Route::get('/admin/users/{id}/edit', function ($id) {
    // Mengambil data pengguna berdasarkan ID dari API Node.js
    $response = Http::get("http://localhost:5000/api/admin/users/{$id}");

    if ($response->successful()) {
        $user = $response->json()['user']; // Mengambil data pengguna dari response
        return view('administrator.edit', compact('user')); // Menampilkan halaman edit dengan data pengguna
    }

    return redirect('/admin')->with('error', 'Gagal mengambil data pengguna');
});


Route::put('/admin/users/{id}', function ($id, \Illuminate\Http\Request $request) {
    $response = Http::put('http://localhost:5000/api/admin/users/'.$id, $request->all());

    if ($response->successful()) {
        return redirect('/admin')->with('success', 'Pengguna berhasil diperbarui');
    }

    return redirect('/admin')->with('error', 'Gagal memperbarui pengguna');
});

// delete
Route::delete('/admin/users/{id}', function ($id) {
    $response = Http::delete('http://localhost:5000/api/admin/users/'.$id);

    if ($response->successful()) {
        return redirect('/admin')->with('success', 'Pengguna berhasil dihapus');
    }

    return redirect('/admin')->with('error', 'Gagal menghapus pengguna');
});

// Rute untuk menonaktifkan pengguna
Route::post('/admin/users/{id}/deactivate', function ($id) {
    $response = Http::post('http://localhost:5000/api/admin/users/'.$id.'/deactivate');

    // Debugging Response API Node.js
    if ($response->successful()) {
        return redirect('/admin')->with('success', 'Pengguna berhasil dinonaktifkan');
    }

    return redirect('/admin')->with('error', 'Gagal menonaktifkan pengguna');
});

// Rute untuk mengaktifkan pengguna
Route::post('/admin/users/{id}/activate', function ($id) {
    $response = Http::post('http://localhost:5000/api/admin/users/'.$id.'/activate');

    if ($response->successful()) {
        return redirect('/admin')->with('success', 'Pengguna berhasil diaktifkan kembali');
    }

    return redirect('/admin')->with('error', 'Gagal mengaktifkan pengguna');
});

// Rute untuk Member
Route::get('/member', function () {
    return view('member.member');  // Halaman untuk Member
})->name('member');

// Rute untuk Tim Keuangan
Route::get('/tim-keuangan', function () {
    return view('timkeuangan.tim-keuangan');  // Halaman untuk Tim Keuangan
})->name('tim-keuangan');

// Rute untuk Tim Panitia Kegiatan
Route::get('/panitia-kegiatan', function () {
    return view('timpanitiakegiatan.panitia-kegiatan');  // Halaman untuk Tim Panitia Kegiatan
})->name('panitia-kegiatan');

Route::post('/logout', function () {
    Session::flush();
    return redirect('/login');
});

