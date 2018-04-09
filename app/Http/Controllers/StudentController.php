<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Redirector;
use Carbon\Carbon;
use App\User;
use Session;
use Helper;
use Auth;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class StudentController extends Controller
{

	public function index(){

		$rules = array(
		    'student_number' => 'required|min:9|max:9', 
		    'password' => 'required|min:3' 
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if($validator->fails()) {
		    return Redirect::to('/login')
		        ->withErrors($validator) 
		        ->withInput(Input::except('password')); 

		} else {

		    // create our user data for the authentication
		    $data = array(
		        'student_number' => Input::get('student_number'),
		        'password'  => Input::get('password')
		    );

		    $user = User::where('student_number',$data['student_number'])
				->where('password',$data['password'])
				->first();

		    // attempt to do the login
			// Auth::attempt($data)
		    if($user) {

				//echo $user;
        		return view('home');

		    } else {        

		        // validation not successful, send back to form 
		        return Redirect::to('/login');

		    }
		}
		
	}

}
