<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProxyController;


Route::get('/', function () {
    return view('student');
});


Route::get('/proxy', [ProxyController::class, 'getStudentData']);