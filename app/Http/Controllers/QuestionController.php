<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function index(): View
    {
        $questions = user()->questions()->with('votes')->get();

        return view('question.index', compact('questions'));
    }

    public function store(): RedirectResponse
    {
        $attributes = request()->validate([
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value[strlen($value) - 1] != '?') {
                        $fail("Are you sure that it is a question? It is missing the question mark in the end.");
                    }
                },
            ],
        ]);

        $attributes['draft']      = true;
        $attributes['created_by'] = user()->id;

        Question::create($attributes);

        return back();
    }
}
