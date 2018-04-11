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

//Route::group(['middleware' => ['web']], function(){

	// route to process the form
	//Route::post('/home','StudentController@index')->name('login');
Route::get('/home', 'HomeController@index');
Route::get('/studyplan','StudentController@plan');
Route::get('/acadprogress','StudentController@progress');
Route::get('/addwishlist','HomeController@wishlist');
Route::get('/addpreference','HomeController@preference');
//});

// Route::get('/logout',function(){
// 	Auth::logout();
// 	return redirect('/'); 
// }); 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
