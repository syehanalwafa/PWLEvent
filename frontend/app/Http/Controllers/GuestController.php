<?php
  use App\Services\ApiService;
  use Illuminate\Http\Request;

  class GuestController extends Controller
  {
      protected $apiService;

      public function __construct(ApiService $apiService)
      {
          $this->apiService = $apiService;
      }

      public function index()
      {
          $guests = $this->apiService->getGuests();

          if ($guests === null) {
              // Tangani kesalahan (misalnya, tampilkan pesan kesalahan)
              return view('error', ['message' => 'Failed to fetch guests.']);
          }

          return view('guests.index', ['guests' => $guests]);
      }
  }

