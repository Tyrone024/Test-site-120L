<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    /**
     * Handle the chat request and get AI response based on the user's message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResponse(Request $request)
    {
        // Validate that the required fields are provided
        $request->validate([
            'name' => 'required|string',
            'details' => 'required|string',
            'userPrompt' => 'required|string'
        ]);

        // Get the input values
        $name = $request->input('name');
        $details = $request->input('details');
        $userPrompt = $request->input('userPrompt');

        // Construct the message to send to the AI
        $message = "For a task named $name where the goal is to $details, answer the following question in a paragraph or less: $userPrompt";

        // Get the AI response
        $aiResponse = $this->getAIResponse($message);

        // Return the AI response
        return response()->json(['response' => $aiResponse], 200);
    }

    /**
     * Fetch the AI response using the provided message.
     *
     * @param string $message
     * @return string
     */
    private function getAIResponse($message)
    {
        $api_key = env('AI_API_KEY'); // Use an environment variable for the API key
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$api_key}";

        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        [
                            "text" => $message
                        ]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $data);

        // Check if the response is successful
        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'No response from AI service.';
        }

        return 'Failed to communicate with the AI service.';
    }
}