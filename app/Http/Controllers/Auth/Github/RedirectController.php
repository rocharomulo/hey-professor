<?php

namespace App\Http\Controllers\Auth\Github;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }
}
