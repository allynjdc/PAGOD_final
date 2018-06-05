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
	Route::get('/submitpreference','StudentController@submitpreference')->name('submitpreference');
	Route::post('/saveconstraints', 'StudentController@saveConstraints')->name('saveconstraints');
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/studyplan','StudentController@plan')->name('studyplan');
	Route::get('/acadprogress','StudentController@progress')->name('acadprogress');
	Route::get('/addwishlist','StudentController@wishlist')->name('addwishlist');
	Route::get('/addpreference','StudentController@preference')->name('addpreference');
	Route::get('/acquireschedule', 'StudentController@acquireSchedule')->name('acquireschedule');
	// Route::get('/acquireviolated', 'StudentController@acquireViolated')->name('acquireviolated');
	Route::post('/generateschedule', 'StudentController@generateSchedule')->name('generateschedule');
	Route::get('/classofferings', 'StudentController@offeredSchedules')->name('classofferings');
});
