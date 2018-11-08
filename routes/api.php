<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1','middleware' => ['auth:api'],'namespace'=>'Api'], function () {
    Route::resource('members', 'MemberApiController');
    Route::resource('contacts', 'ContactApiController');
    Route::get('user',function (Request $request){
        return $request->user();
    });
});


Route::group(['prefix' => 'v1','namespace'=>'Api'], function () {
    Route::get('package', 'PackageApiController@index');
    Route::post('login','UserApiController@login');
});
