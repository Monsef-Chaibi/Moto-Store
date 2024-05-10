<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslationController extends Controller
{
    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'target_language' => 'required|string', // ensure target language is provided
        ]);

        $client = new Client();

        try {
            $response = $client->request('POST', 'https://text-translator2.p.rapidapi.com/translate', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'X-RapidAPI-Key' => '52af6700fbmsh75b41e871b65d57p1f0359jsn4205a9e3fc47',
                    'X-RapidAPI-Host' => 'text-translator2.p.rapidapi.com',
                ],
                'form_params' => [
                    'source_language' => 'en',
                    'target_language' => $request->target_language,
                    'text' => $request->text,
                ]
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
            return response()->json([
                'success' => true,
                'translatedText' => $data['data']['translatedText']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
