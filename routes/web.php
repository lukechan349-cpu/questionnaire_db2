<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Simple dashboard route
Route::get('/dash', function () {
    return view('dashboard');
});

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

// Questionnaire routes using QuestionController
use App\Http\Controllers\QuestionController;

Route::get('/questionnaire', [QuestionController::class, 'index']);
Route::post('/questionnaire/answer', [QuestionController::class, 'store']);

// Answer history page (separate view) - shows past answers only
Route::get('/questionnaire/history', function () {
    $answers = Answer::with('question')->orderBy('created_at', 'desc')->get();
    return view('questionnaire.history', compact('answers'));
});

// JSON endpoint used by the dashboard popup to fetch answer history
Route::get('/questionnaire/history-data', function () {
    $answers = Answer::with('question')->orderBy('created_at', 'desc')->get()->map(function ($a) {
        return [
            'id' => $a->id,
            'question' => $a->question ? $a->question->title : null,
            'answer_text' => $a->answer_text,
            'created_at' => $a->created_at->toDateTimeString(),
            'created_human' => $a->created_at->diffForHumans(),
        ];
    });

    return response()->json(['data' => $answers]);
});

// Clear history endpoint (delete all answers)
Route::post('/questionnaire/history-clear', function (Request $request) {
    // simple authorization could be added here; for now allow any web user
    \Illuminate\Support\Facades\DB::table('answers')->truncate();
    return response()->json(['ok' => true]);
});
