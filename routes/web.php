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
Route::get('/discover', 'PagesController@discover');
Route::get('/upgrade', 'PagesController@upgrade');
Route::get('/profile/edit', 'ProfileController@edit');
Route::get('/profile/channel', 'ProfileController@channel');
Route::get('/profile/podcast', 'ProfileController@podcast');
Route::resource('/profile', 'ProfileController');

/*==========Search Controller=============*/
Route::get('/search', 'SearchController@index');
Route::post('/search', 'SearchController@search');

/*==========Channel Controller=============*/
Route::resource('channel', 'ChannelController');
Route::post('/channel/{channel}/subscribe', 'SubscriptionController@store');
Route::delete('/channel/{channel}/unsubscribe', 'SubscriptionController@destroy');

/*==========Podcast Controller=============*/
Route::get('/upload', 'PodcastController@index');
Route::post('/upload', 'PodcastController@store');
Route::get('/channel/{channel}/podcast/{podcast}', 'PodcastController@show');
Route::get('/channel/{channel}/podcast/{podcast}/edit', 'PodcastController@edit');
Route::patch('/channel/{channel}/podcast/{podcast}', 'PodcastController@update');
Route::post('/channel/{channel}/podcast/{podcast}/comment', 'CommentController@store');
Route::post('/channel/{channel}/podcast/{podcast}/rate', 'RatingController@store');

Auth::routes();