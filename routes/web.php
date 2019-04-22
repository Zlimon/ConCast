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

/*==========Pages Controller=============*/
Route::get('/', 'PagesController@index');

Route::get('/discover', [ 'as' => 'discover', 'uses' => 'PagesController@discover']);

Route::get('/upgrade', 'PagesController@upgrade');

Route::resource('/profile', 'ProfileController');

/*==========Channel Controller=============*/
Route::resource('channel', 'ChannelController');

Route::post('/channel/{channel}/subscribe', 'SubscriptionController@store');
Route::delete('/channel/{channel}/unsubscribe', 'SubscriptionController@destroy');

/*==========Podcast Controller=============*/
Route::get('/channel/{channel}/podcast/{podcast}', [ 'as' => 'show-podcast', 'uses' => 'PodcastController@show']);

Route::get('/channel/{channel}/podcast/{podcast}/edit', [ 'as' => 'edit-podcast', 'uses' => 'PodcastController@edit']);
Route::patch('/channel/{channel}/podcast/{podcast}', 'PodcastController@update');

Route::post('/channel/{channel}/podcast/{podcast}/comment', 'CommentController@store');

Route::post('/channel/{channel}/podcast/{podcast}/rate', 'RatingController@store');

/*==========Podcast Controller 2=============*/
Route::get('/upload', [ 'as' => 'upload', 'uses' => 'FileController@index']);
Route::post('/upload', 'FileController@verify');

Auth::routes();