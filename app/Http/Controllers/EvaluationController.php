<?php

namespace App\Http\Controllers;
use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function evaluate(Request $request)
    {
        $this->validate($request, [
            'prompt_id' => 'required|exists:prompts,id',
            'response' => 'required|string',
            'score' => 'required|numeric|min:0|max:10',
        ]);

        $evaluation = Evaluation::create($request->all());
        return response()->json($evaluation, 201);
    }
}