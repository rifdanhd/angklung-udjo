<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatAIController extends Controller
{
    public function reply(Request $request)
    {
        $userMessage = $request->input('message');

        $systemContext = "Kamu adalah asisten virtual Saung Angklung Udjo.
            Kamu membantu pengunjung dengan informasi seputar:
            - Jadwal pertunjukan: setiap hari pukul 15.30 WIB (Indoor), Sabtu 16.00 WIB
            - Harga tiket: mulai dari Rp 60.000 (anak) dan Rp 80.000 (dewasa)
            - Lokasi: Jl. Padasuka No.118, Bandung
            - Jam buka: 08.00 - 17.00 setiap hari
            - Pertunjukan: angklung, wayang golek, tari tradisional Sunda
            - Booking: melalui website angklung-udjo.co.id
            Jawab dengan ramah, singkat, dalam Bahasa Indonesia.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-8b-instant',
            'messages' => [
                ['role' => 'system', 'content' => $systemContext],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'max_tokens' => 500,
        ]);

        \Log::info('Groq response: ' . $response->body());

        $reply = $response->json('choices.0.message.content')
                 ?? 'Maaf, saya sedang tidak bisa menjawab.';

        return response()->json(['reply' => $reply]);
    }
}
