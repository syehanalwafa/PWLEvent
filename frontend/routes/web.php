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


    // Rute untuk Administrator
    Route::get('/admin', function () {
        return view('administrator.admin');  // Halaman untuk Administrator
    })->name('admin');

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
