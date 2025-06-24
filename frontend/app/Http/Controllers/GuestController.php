<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

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
        // Mendapatkan data event berdasarkan ID
        $event = $this->apiService->getEventById($id);

        if ($event === null) {
            // Tangani kesalahan jika event tidak ditemukan
            return view('error', ['message' => 'Event not found.']);
        }

        // Mengirim data event ke view event.blade.php
        return view('guest.event', ['event' => $event]);
    }
}
