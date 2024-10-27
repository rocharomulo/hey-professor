<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\{Question};
use Illuminate\Http\{RedirectResponse};

class LikeController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {
        auth()->user()->like($question);

        return back();
    }
}
