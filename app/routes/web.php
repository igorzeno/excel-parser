<?php

use App\Http\Controllers\RowController;
use Illuminate\Support\Facades\Route;

Route::get('/import', [RowController::class,"index"]);
Route::post('/import', [RowController::class,"import"])->name('import');
Route::get('/rows', [RowController::class,"rows"]);

Route::get('/', function () {
    return view('welcome');
});
