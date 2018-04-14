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

Route::group(['middleware' => ['auth']], function(){

	// route to process the form
	Route::get('/home', 'HomeController@index');
	Route::get('/studyplan','StudentController@plan');
	Route::get('/acadprogress','StudentController@progress');
	Route::get('/addwishlist','StudentController@wishlist');
	Route::get('/addpreference','StudentController@preference');
});
