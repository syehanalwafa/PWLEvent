<?php
  namespace App\Services;

  use GuzzleHttp\Client;

  class ApiService
  {
      protected $client;
      protected $baseUrl;

      public function __construct()
      {
          $this->baseUrl = env('API_BASE_URL', 'http://localhost:5000/api'); // URL backend dari .env
          $this->client = new Client([
              'base_uri' => $this->baseUrl,
              'timeout'  => 5.0, // Sesuaikan timeout sesuai kebutuhan
          ]);
      }

      public function getGuests()
      {
          try {
              $response = $this->client->get('/guests'); // Ganti '/guests' dengan endpoint yang sesuai
              return json_decode($response->getBody(), true); // Decode JSON ke array asosiatif
          } catch (\Exception $e) {
              // Tangani kesalahan (log, lempar pengecualian, dll.)
              \Log::error('Error fetching guests from API: ' . $e->getMessage());
              return null; // Atau lempar pengecualian
          }
      }

      // Metode lain untuk POST, PUT, DELETE, dll.
  }


