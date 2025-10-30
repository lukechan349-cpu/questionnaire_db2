<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::all();
        return view('questionnaire.index', compact('questions'));
    }


    public function store(Request $request)
    {
        $answers = $request->input('answers', []);
        
        foreach ($answers as $questionId => $answerText) {
            Answer::create([
                'question_id' => $questionId,
                'user_id' => auth()->id(),
                'answer_text' => $answerText
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Thank you for answering the questionnaire!']);
        }

        return back()->with('success', 'Thank you for answering the questionnaire!');
    }
}