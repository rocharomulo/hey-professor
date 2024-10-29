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

    public function edit(Question $question): View
    {
        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
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

        $question->update(['question' => request()->question]);

        return redirect()->route('question.index');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->delete();

        return back();
    }
}
