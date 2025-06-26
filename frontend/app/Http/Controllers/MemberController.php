<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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


    public function showRegisterForm($id) {
        return view('member.register', compact('id'));
    }

    public function registerEvent(Request $request, $id)
{
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    $response = Http::post("http://localhost:5000/api/events/$id/register", [
        'id' => $user->id,
    ]);

    if ($response->failed()) {
        return redirect()->back()->withErrors('Gagal melakukan registrasi');
    }

    $qr_code = $response->json()['qr_code'];
    return view('member.qr', compact('qr_code'));
}


    public function showUploadForm($id) {
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

    return redirect()->route('member.events')->with('success', 'Bukti pembayaran berhasil diupload.');
}


    public function showQr($id) {
        // Kalau butuh ambil dari API bisa ditambahkan
        return view('member.qr', ['qr_code' => session('qr_code')]);
    }
}
