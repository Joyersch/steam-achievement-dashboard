<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('app:pull')->hourly();
