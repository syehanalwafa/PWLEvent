<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GuestController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    // Method untuk menampilkan daftar event di halaman utama
    public function index()
    {
        $events = $this->apiService->getEvents();  // Mendapatkan daftar event

        if ($events === null) {
            // Tangani kesalahan (misalnya, tampilkan pesan kesalahan)
            return view('error', ['message' => 'Failed to fetch events.']);
        }

        return view('guest.home', ['events' => $events]);
    }

    // Method untuk menampilkan detail event berdasarkan ID
    public function showEvent($id)
    {
    $response = Http::get("http://localhost:5000/api/events/guest/{$id}");

    if ($response->successful()) {
        $event = (object) $response->json();
        return view('guest.event', compact('event'));
    }

    return redirect('/')->with('error', 'Event tidak ditemukan');
    }
}
