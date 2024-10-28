<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\{RedirectResponse, Response};

class PublishController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {

        $this->authorize('publish', $question);

        abort_unless(user()->can('publish', $question), Response::HTTP_FORBIDDEN);

        $question->draft = false;
        $question->save();

        return back();
    }
}
