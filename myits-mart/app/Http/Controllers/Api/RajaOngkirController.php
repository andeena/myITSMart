<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    // [PENTING] Definisikan URL API dan Key di atas agar mudah diubah
    protected $apiKey;
    protected $baseUrl = 'https://api.rajaongkir.com/starter';

    public function __construct()
    {
        // Ambil API Key dari file .env
        $this->apiKey = env('RAJAONGKIR_API_KEY');
    }

    /**
     * Mengambil daftar semua provinsi.
     */
    public function getProvinces()
    {
        if (!$this->apiKey) {
            return response()->json(['error' => 'API Key tidak dikonfigurasi.'], 500);
        }

        $response = Http::withHeaders(['key' => $this->apiKey])
                        ->get($this->baseUrl . '/province');

        return $response->successful()
            ? response()->json($response->json()['rajaongkir']['results'])
            : response()->json(['error' => 'Gagal mengambil data provinsi.'], $response->status());
    }

    /**
     * Mengambil daftar kota berdasarkan ID Provinsi.
     */
    public function getCities($province_id)
    {
        if (!$this->apiKey) {
            return response()->json(['error' => 'API Key tidak dikonfigurasi.'], 500);
        }

        $response = Http::withHeaders(['key' => $this->apiKey])
                        ->get($this->baseUrl . '/city', ['province' => $province_id]);

        return $response->successful()
            ? response()->json($response->json()['rajaongkir']['results'])
            : response()->json(['error' => 'Gagal mengambil data kota.'], $response->status());
    }
}