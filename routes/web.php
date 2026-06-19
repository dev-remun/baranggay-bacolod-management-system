<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\RegistrationController;

Route::get('/register', [RegistrationController::class, 'create'])->name('register.create');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.submit');

Route::post('/register/back', [RegistrationController::class, 'goBackRegistrationForms'])->name('register.back');

Route::post('/evalPersonalInfo', [RegistrationController::class, 'evaluatePersonalInfo'])->name('register.evalPersonalInfo');
Route::post('/evalParentsInfo', [RegistrationController::class, 'evaluateParentsInfo'])->name('register.evalParentsInfo');
Route::post('/evalSiblingsInfo', [RegistrationController::class, 'evaluateSiblingsInfo'])->name('register.evalSiblingsInfo');
