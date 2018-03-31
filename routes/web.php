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
	
Route::get('/logout',function(){
	Auth::logout();
	return redirect('/'); 
});

Auth::routes();

// route to process the form
Route::post('/home','StudentController@index')->name('login');

Route::group(['middleware' => 'auth'], function(){

	Route::get('/home1', 'HomeController@index')->name('home');
	Route::get('/studyplan','HomeController@plan');
	Route::get('/acadprogress','HomeController@progress');
	Route::get('/addwishlist','HomeController@wishlist');
	Route::get('/addpreference','HomeController@preference');
});
