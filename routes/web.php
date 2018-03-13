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

Route::get('/', function () {
	return view('auth/login');
})->middleware('guest');
	
Auth::routes();
Route::post('login',array('uses' => 'HomeController@confirmUser'));
Route::get('/home', 'HomeController@index'); 
Route::get('/studyplan','HomeController@plan');
Route::get('/acadprogress','HomeController@progress');
Route::get('/addwishlist','HomeController@wishlist');
Route::get('/addpreference','HomeController@preference');
