<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MemberController;

// Letakkan di sini
$withToken = function($request) {
    return Http::withHeaders([
        'Authorization' => 'Bearer ' . Session::get('token')
    ]);
};


// Guest routes
Route::get('/', function () {
    $events = Http::get('http://localhost:5000/api/events')->json();
    return view('guest.home', compact('events'));
});


// Route detail event (untuk guest dan member)
Route::get('/events/{id}', function ($id) {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . Session::get('token')
    ])->get("http://localhost:5000/api/events/{$id}");

    if ($response->successful()) {
        $event = (object) $response->json();

        // Gunakan Session::get('role') untuk menentukan tampilan
        if (Session::get('role') === 'Member') {
            return view('member.events', compact('event'));
        }

        return view('guest.event', compact('event'));
    }

    return redirect('/')->with('error', 'Event tidak ditemukan');
})->name('event.show');



// Route detail event khusus member
Route::get('/member/events/{id}', function ($id) use ($withToken) {
    if (Session::get('role') !== 'Member') {
        return redirect('/')->with('error', 'Akses ditolak');
    }

    $response = $withToken(request())->get("http://localhost:5000/api/events/{$id}");
    if ($response->successful()) {
        $event = (object) $response->json();
        return view('member.events', compact('event'));
    }

    return redirect('/member')->with('error', 'Event tidak ditemukan');
})->name('member.event.show');



Route::view('/register', 'guest.register')->name('register');

Route::view('/login', 'auth.login')->name('login');


Route::post('/login', function (Request $request) {
    $response = Http::post('http://localhost:5000/api/auth/login', [
        'email' => $request->email,
        'password' => $request->password,
    ]);
    \Log::info('Response dari backend:', $response->json());

    if ($response->successful()) {
        $data = $response->json();

        Session::put('token', $data['token'] ?? null);
        Session::put('role', $data['role'] ?? null);
        Session::put('name', $data['name'] ?? null);

        // Cek apakah 'id' ada
        if (isset($data['id'])) {
            Session::put('user_id', $data['id']);
        } else {
            logger()->warning('Login berhasil tapi "id" tidak ditemukan dalam response.', $data);
        }

        return redirect($data['redirectUrl'] ?? '/'); // fallback ke halaman utama jika tidak ada redirectUrl
    }

    return redirect('/login')->with('error', 'Login gagal. Cek email dan password.');
});


// Rute Home Member

// Halaman utama member (daftar event)
Route::get('/member', function () {
    $events = Http::get('http://localhost:5000/api/events')->json();
    return view('member.home', compact('events'));
})->name('member.home');

// Form konfirmasi pembelian tiket
Route::get('/member/events/{id}/register', function ($id) use ($withToken) {
    if (Session::get('role') !== 'Member') {
        return redirect('/login')->with('error', 'Harap login sebagai Member');
    }

    $response = $withToken(request())->get("http://localhost:5000/api/events/{$id}");

    if ($response->successful()) {
        $event = (object) $response->json();
        return view('member.register', compact('event'));
    }

    return redirect('/member')->with('error', 'Event tidak ditemukan');
})->name('member.register.form');

// Beli tiket & generate QR (POST)
Route::post('/member/events/{id}/register', [MemberController::class, 'registerEvent'])
    ->name('member.register');

// Tampilkan form upload bukti bayar (GET)
Route::get('/member/payment/{id}', [MemberController::class, 'showUploadForm'])
    ->name('member.payment.form');

// Upload bukti pembayaran (POST)
Route::post('/member/payment/{id}', [MemberController::class, 'uploadProof'])
    ->name('member.payment.upload');

// Lihat QR Code setelah beli tiket
Route::get('/member/qr/{id}', [MemberController::class, 'showQr'])
    ->name('member.qr');

Route::post('/member/payment/{id}', [MemberController::class, 'uploadProof'])->name('member.payment.upload');

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
Route::post('/admin/users/{id}', function (Request $request, $id) {
    $response = Http::put("http://localhost:5000/api/admin/users/{$id}", $request->all());

    if ($response->successful()) {
        return redirect('/admin')->with('success', 'Pengguna berhasil diperbarui');
    }

    return redirect("/admin/users/{$id}/edit")->with('error', 'Gagal memperbarui pengguna');
});

Route::put('/admin/users/{id}', function (Request $request, $id) {
    $response = Http::put("http://localhost:5000/api/admin/users/{$id}", $request->all());

    if ($response->successful()) {
        return redirect('/admin')->with('success', 'Pengguna berhasil diperbarui');
    }

    return redirect("/admin/users/{$id}/edit")->with('error', 'Gagal memperbarui pengguna');
});
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

// Rute untuk Tim Keuangan
Route::get('/tim-keuangan', function () {
    return view('timkeuangan.tim-keuangan');  // Halaman untuk Tim Keuangan
})->name('tim-keuangan');

// Rute untuk Tim Panitia Kegiatan
Route::get('/panitia-kegiatan', function () {
    // Pastikan pengguna sudah login dan memiliki role 'panitia pelaksana kegiatan'
        // Mengambil data event dari backend API
        $response = Http::get('http://localhost:5000/api/events');  // Gantilah dengan URL API yang benar

        // Jika API berhasil memberikan data
        if ($response->successful()) {
            $events = $response->json();  // Mengambil data event dalam bentuk array

            // Kirim data ke view
            return view('timpanitiakegiatan.dashboard', ['events' => $events]);  // Akses 'data' jika respons mengandung key 'data'
        } else {
            // Jika API gagal, tampilkan pesan error
            return redirect('/login')->with('error', 'Gagal mengambil data event');
        }

    return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
})->name('panitia-kegiatan');

// CRUD routes untuk event (misalnya jika kamu ingin tetap mempertahankan controller untuk CRUD)
// Rute untuk menampilkan form create event menggunakan metode GET
Route::get('/panitia-kegiatan/events/create', function () {
    return view('timpanitiakegiatan.create');
});
// Handle event creation form submission (POST)
Route::post('/panitia-kegiatan/events', function (Request $request) {
    $multipartData = [];

    // Tambahkan semua field selain file
    foreach ([
        'name', 'date', 'time', 'location',
        'speaker', 'registration_fee', 'max_participants'
    ] as $field) {
        $multipartData[] = [
            'name' => $field,
            'contents' => $request->input($field)
        ];
    }

    // Cek apakah file dikirim
    if ($request->hasFile('poster_url')) {
        $multipartData[] = [
            'name'     => 'poster_url',
            'contents' => fopen($request->file('poster_url')->getPathname(), 'r'),
            'filename' => $request->file('poster_url')->getClientOriginalName(),
        ];
    }

    // Kirim sebagai multipart
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . Session::get('token')
    ])
    ->asMultipart()
    ->post('http://localhost:5000/api/events/create', $multipartData);


    if ($response->successful()) {
        return redirect('/panitia-kegiatan/events')->with('success', 'Event berhasil dibuat');
    }

    return redirect('/panitia-kegiatan/events')->with('error', 'Gagal membuat event');
});

// Route untuk menampilkan daftar event (GET)
Route::get('/panitia-kegiatan/events', function () {
    $response = Http::get('http://localhost:5000/api/events');  // Mengambil data event dari backend API

    if ($response->successful()) {
        $events = $response->json();  // Mengambil data event dalam bentuk array
        return view('timpanitiakegiatan.dashboard', compact('events'));
    }

    return redirect('/panitia-kegiatan')->with('error', 'Gagal mengambil daftar event');
});



Route::get('/panitia-kegiatan/events/{id}/edit', function ($id) {
    $response = Http::get("http://localhost:5000/api/events/{$id}");

    if ($response->successful()) {
        $event = $response->json();
        return view('timpanitiakegiatan.edit', compact('event'));
    }

    return redirect('/panitia-kegiatan/events')->with('error', 'Gagal mengambil data event');
});

Route::put('/panitia-kegiatan/events/{id}', function (Request $request, $id) {
    $multipart = [];

    foreach (['name', 'date', 'time', 'location', 'speaker', 'registration_fee', 'max_participants'] as $field) {
        $multipart[] = [
            'name' => $field,
            'contents' => $request->input($field),
        ];
    }

    $multipart[] = [
        'name' => '_method',
        'contents' => 'PUT',
    ];

    if ($request->hasFile('poster_url')) {
        $file = $request->file('poster_url');
        $multipart[] = [
            'name'     => 'poster_url',
            'contents' => fopen($file->getPathname(), 'r'),
            'filename' => $file->getClientOriginalName(),
        ];
    }

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . Session::get('token')
    ])
    ->asMultipart()
    ->post("http://localhost:5000/api/events/{$id}", $multipart);

    if ($response->successful()) {
        return redirect('/panitia-kegiatan/events')->with('success', 'Event berhasil diperbarui');
    }

    return redirect("/panitia-kegiatan/events/{$id}/edit")->with('error', 'Gagal memperbarui event');
});

// Route POST untuk update event (dari form edit)
Route::post('/panitia-kegiatan/events/{id}', function (Request $request, $id) {
    $multipart = [];

    // Tambahkan semua field form ke multipart
    foreach (['name', 'date', 'time', 'location', 'speaker', 'registration_fee', 'max_participants'] as $field) {
        $multipart[] = [
            'name' => $field,
            'contents' => $request->input($field),
        ];
    }

    // Override method ke PUT
    $multipart[] = [
        'name' => '_method',
        'contents' => 'PUT',
    ];

    // Jika ada file poster
    if ($request->hasFile('poster_url')) {
        $file = $request->file('poster_url');
        $multipart[] = [
            'name'     => 'poster_url',
            'contents' => fopen($file->getPathname(), 'r'),
            'filename' => $file->getClientOriginalName(),
        ];
    }

    // Kirim ke backend Node.js
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . Session::get('token')
    ])
    ->asMultipart()
    ->post("http://localhost:5000/api/events/{$id}", $multipart);

    if ($response->successful()) {
        return redirect('/panitia-kegiatan/events')->with('success', 'Event berhasil diperbarui');
    }

    return redirect("/panitia-kegiatan/events/{$id}/edit")->with('error', 'Gagal memperbarui event');
});

Route::delete('/panitia-kegiatan/events/{id}', function ($id) {
    $response = Http::delete("http://localhost:5000/api/events/{$id}");

    if ($response->successful()) {
        return redirect('/panitia-kegiatan/events')->with('success', 'Event berhasil dihapus');
    }

    return redirect('/panitia-kegiatan/events')->with('error', 'Gagal menghapus event');
});

Route::post('/logout', function () {
    Session::flush();
    return redirect('/login');
});



