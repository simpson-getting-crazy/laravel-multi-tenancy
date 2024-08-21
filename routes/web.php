<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    dd(auth()->user());
    return view('welcome');
});

require __DIR__ . '/auth.php';
