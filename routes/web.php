<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/randcode', function(){
//     $rand_code = Str::random(32).time();
//     // Str::after($subject, 'search')
//     return $rand_code;
// });

Route::get('/verify/{token}', [AuthController::class, 'verify'])->name('verify.email');
