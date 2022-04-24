<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});


Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    Route::get('profile', 'ProfileController@profile');
    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');
    Route::get('tag/list', 'TagController@list');
    Route::get('category/list', 'CategoryController@list');
    Route::get('practice/listing', 'PracticeController@listing');
    Route::get('payer/listing', 'PayerController@listing');
    Route::get('practice/getProviders/{id}', 'PracticeController@getProviders');
    Route::get('document/doctypes', 'DocumentController@doctypes');
    Route::get('document/show/{id}', 'DocumentController@show');
    Route::get('provider/show/{id}', 'ProviderController@show');
    Route::get('provider/payers/{id}', 'ProviderController@payers');
    Route::get('dashboard_counts', 'GeneralController@dashboard_counts');
    Route::post('allprovidersstatus', 'ProviderController@allProvidersStatus' )->name('allprovidersstatus');
    Route::post('allusersactivity', 'ActivityController@allUsersActivity' );
    Route::post('product/upload', 'ProductController@upload');
    Route::post('quickupdate-form-submit', 'QuickupdateController@update');
    Route::get('getRemarks', 'RemarkController@all');
    
    Route::apiResources([
        'user' => 'UserController',
        'product' => 'ProductController',
        'practice' => 'PracticeController',
        'provider' => 'ProviderController',
        'activity' => 'ActivityController',
        'quickupdate' => 'QuickupdateController',
        'document' => 'DocumentController',
        'practicedoc' => 'PracticedocController',
        'payer' => 'PayerController',
        'category' => 'CategoryController',
        'tag' => 'TagController',
    ]);
});
