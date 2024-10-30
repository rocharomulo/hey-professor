<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\SameQuestionRule;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function index(): View
    {
        $questions         = user()->questions;
        $archivedQuestions = user()->questions()->onlyTrashed()->get();

        return view('question.index', compact('questions', 'archivedQuestions'));
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
                new SameQuestionRule(),
            ],
        ]);

        $attributes['draft']      = true;
        $attributes['created_by'] = user()->id;

        Question::create($attributes);

        return back();
    }

    public function edit(Question $question): View
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

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

        $question->forceDelete();

        return back();
    }

    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('archive', $question);

        $question->delete();

        return back();
    }

    public function restore(int $id): RedirectResponse
    {
        $question = Question::withTrashed()->find($id);

        $this->authorize('restore', $question);

        $question->restore();

        return back();
    }
}
