<?php

// use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/earthquakes', function () {
    return view('earthquakes.index');
});

Route::get('/', function () {
    return view('density.index');
});

Route::get('/thematic-map/sulsel/density', function () {
    return view('density.index');
});

Route::get('/thematic-map/sulsel/tpt', function () {
    return view('tpt.index');
});

Route::get('/thematic-map/sulsel/student', function () {
    return view('student.index');
});
