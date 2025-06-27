<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MemberController extends Controller
{
    public function listEvents()
    {
        $response = Http::get('http://localhost:5000/api/events');

        if ($response->failed()) {
            return redirect()->back()->withErrors('Gagal mengambil data event');
        }

        $events = $response->json();
        return view('member.home', compact('events'));
    }

    public function showRegisterForm($id)
    {
        return view('member.register', compact('id'));
    }

    public function registerEvent(Request $request, $id)
{
    $userId = Session::get('user_id');

    if (!$userId) {
        return redirect()->route('login');
    }

    // Kirim data ke API untuk registrasi event
    $response = Http::post("http://localhost:5000/api/events/$id/register", [
        'id' => $userId,
    ]);

    if ($response->failed()) {
        return redirect()->back()->withErrors('Gagal melakukan registrasi.');
    }

    // Ambil registration_id dari response
    $registration_id = $response->json()['registration_id'] ?? null;

    if (!$registration_id) {
        return redirect()->route('member.home')->with('error', 'Registrasi berhasil, namun ID tidak ditemukan.');
    }

    // Redirect langsung ke form upload bukti pembayaran
    return redirect()->route('member.payment.form', $registration_id);
}


    public function listRegistrations()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $response = Http::get("http://localhost:5000/api/registrations/$userId");

        if ($response->failed()) {
            return redirect()->back()->withErrors('Gagal mengambil data registrasi');
        }

        $registrations = $response->json();
        return view('member.registrations', compact('registrations'));
    }

    public function showUploadForm($id)
    {
        return view('member.payment', compact('id'));
    }

    public function uploadProof(Request $request, $registration_id)
    {
        $request->validate([
            'proof' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $file = $request->file('proof');

        $response = Http::attach(
            'proof',
            file_get_contents($file),
            $file->getClientOriginalName()
        )->post("http://localhost:5000/api/payment-proof/$registration_id");

        if ($response->failed()) {
            return redirect()->back()->withErrors('Upload gagal.');
        }

        // Ambil QR dari response jika tersedia
        $qr_code = $response->json()['qr_code'] ?? null;

        if (!$qr_code) {
            return redirect()->route('member.home')->with('success', 'Upload berhasil. QR Code akan tersedia setelah verifikasi.');
        }

        Session::put('qr_code', $qr_code);

        return redirect()->route('member.qr', $registration_id);
    }

    public function showQr($id)
    {
        $qr_code = session('qr_code');

        if (!$qr_code) {
            return redirect()->route('member.home')->with('error', 'QR Code belum tersedia.');
        }

        return view('member.qr', compact('qr_code'));
    }
}
