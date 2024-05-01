<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use App\Models\UserGameStat;

class IndexController extends Controller
{
    public function index()
    {
        return view('index', ['activities' => Activity::fromLastMonth()]);
    }
}
