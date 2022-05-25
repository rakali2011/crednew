<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true,'register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/practiceprovider/export/{id}', [App\Http\Controllers\ExportController::class, 'practice_provider_export'])->name('home1');

Route::get('/document/{id}', [App\Http\Controllers\DocumentController::class, 'show']);
Route::get('/pdocument/{id}', [App\Http\Controllers\DocumentController::class, 'pshow']);




Route::get('home', function () {
    return redirect('/dashboard');
});

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
