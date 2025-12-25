<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConverterController;

//Route::get('/', function () {
//    return view('welcome');
//});



Route::get('/', [ConverterController::class, 'index']);
