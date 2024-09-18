<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\DistanceController;

Route::resource('users', UserController::class);
Route::get('users/export/csv', [UserController::class, 'exportCsv'])->name('users.export.csv');
Route::post('/audio/playtime', [AudioController::class, 'getAudioPlaytime']);
Route::get('/upload', function () {
    return view('upload');
});
Route::get('/distance', function () {
    return view('distance');
});
Route::post('/calculate-distance', [DistanceController::class, 'calculateDistance']);