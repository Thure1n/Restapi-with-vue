<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//get all posts
Route::get('/posts', 'PostController@index');
//get single post
Route::get('/post/{id}', 'PostController@show');
//create new post
Route::post('/post', 'PostController@store');
//update post
Route::put('/post', 'PostController@store');
//delete post
Route::delete('/post/{id}', 'PostController@destroy');


