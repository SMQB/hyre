<?php

namespace App\Http\Controllers;
use App\Models\Prompt;
class PromptController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'template' => 'required|string',
        ]);

        $prompt = Prompt::create($request->all());
        $response = self::AI_Request($prompt->title);
        $evaluation = new Evaluation();
        $evaluation->prompt_id = $prompt->id;
        $evaluation->response = $response;
        $evaluation->score = $response->usage->completion_tokens? $response->usage->completion_tokens : 0;
        $evaluation->save();
        return response()->json($prompt, 201);
    }

    public function index()
    {
        return response()->json(Prompt::all());
    }
    
    
    public static function AI_Request($prompt)
    {
        $apiKey = env('AI_API_KEY');
        $url = 'https://api.openai.com/v1/completions';

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'text-davinci-003',
                'prompt' => $prompt,
                'max_tokens' => 200,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

}