<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $response = Http::withToken(config('services.openrouter.key'))
            ->timeout(60)
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => config('services.openrouter.model'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Ikaw ang assistant sa Tingalan Naluwas Church. Tubaga ang user sa parehas nga language nga iyang gigamit.',
                    ],
                    ['role' => 'user', 'content' => $request->message],
                ],
            ]);

        if ($response->failed()) {
            return response()->json([
                'error' => $response->json('error.message') ?? 'Naay error sa AI.',
            ], $response->status());
        }

        return response()->json([
            'reply' => $response->json('choices.0.message.content'),
        ]);
    }
}