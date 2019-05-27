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
Route::get('/', 'PagesController@index')->name('index');
Route::get('/discover', 'PagesController@discover')->name('discover');
Route::get('/upgrade', 'PagesController@upgrade')->name('upgrade');
Route::get('/profile/edit', 'ProfileController@edit')->name('edit.profile');
Route::get('/profile/channel', 'ProfileController@channel')->name('channel.profile');
Route::get('/profile/podcast', 'ProfileController@podcast')->name('podcast.profile');
Route::resource('/profile', 'ProfileController');

/*==========Search Controller=============*/
Route::get('/search', 'SearchController@index')->name('search.index');
Route::post('/search', 'SearchController@search')->name('search.result');

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