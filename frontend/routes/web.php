<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

Route::view('/login', 'login');
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $response = Http::post('http://localhost:5000/api/auth/login', [
        'email' => $request->email,
        'password' => $request->password,
    ]);

    if ($response->successful()) {
        Session::put('token', $response['token']);
        Session::put('role', $response['role']);
        Session::put('name', $response['name']);

        return redirect($response['role'] === 'Administrator' ? '/admin' : '/member');
    }

    return redirect('/login')->with('error', 'Login gagal. Cek email dan password.');
});

Route::get('/admin', function () {
    if (Session::get('role') !== 'Administrator') abort(403);
    return view('admin');
});

Route::get('/member', function () {
    if (Session::get('role') !== 'Member') abort(403);
    return view('member');
});

Route::post('/logout', function () {
    Session::flush();
    return redirect('/login');
});
