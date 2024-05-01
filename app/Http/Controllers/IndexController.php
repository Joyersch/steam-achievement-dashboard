<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGameStat;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function user(string $name)
    {
        $user = User::whereName($name);
        if (!$user) {
            return view('errors.404', ['message' => 'no user with that name!'], 404);
        }

        return view('user', ['completion' => UserGameStat::getCompletion($user)]);

    }
}
