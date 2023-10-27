<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenAIController extends Controller
{
    public function openHomePage()
    {
        return view('auth.open-ai.index');
    }

    public function loadResponse(Request $request)
    {
        $search = $request->user_message;

        $data = Http::withHeaders([

                    'Content-Type' => 'application/json',

                    'Authorization' => 'Bearer '. config('services.open-ai.key'),

                  ])

                  ->post("https://api.openai.com/v1/chat/completions", [

                    "model" => "gpt-3.5-turbo",

                    'messages' => [

                        [

                           "role" => "user",

                           "content" => $search,
                        //    'system' => 'system'

                       ]

                    ],

                    'temperature' => 0.5,

                    "max_tokens" => 200,

                    "top_p" => 1.0,

                    "frequency_penalty" => 0.52,

                    "presence_penalty" => 0.5,

                    "stop" => ["11."],

                  ])

        ->json();

        // return $data;
        return response()->json($data['choices'][0]['message'], 200, array(), JSON_PRETTY_PRINT);
    }
}
