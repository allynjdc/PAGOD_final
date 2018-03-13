<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Validator;
use Redirect;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home'); 
    }

    public function confirmUser(Request $request)
    {
        $userdata =$request->only(['student_number', 'password']);
        print "confirmUser";
        // // setting rules for Validation
        // $rules = array(
        //     'student_number' => 'required|'
        //     'password' => 'required|'
        // );

        // // run the Validation
        // $validator = validator::make(Input::all(),$rules);

        // // if fails
        // if($validator->fails()){
        //     return Redirect::to('/')
        //         ->withErrors($validator)
        //         ->withInput(Input::except('password'));
        // } else {
            // $userdata = array(
            //     'student_number' => Input::get('student_number'),
            //     'password'       => Input::get('password')
            // );

            $student_number = $userdata['student_number'];
            //echo exec("cd ../../../public/python; python login.py '201429324'");
            echo exec("python login.py '201429324'");
            // USE THIS http://symfony.com/doc/current/components/process.html
            
            // if($check == null || $check == ""){
            //     return Redirect::to('/');
            // } else {
            //     echo $check;
            //     return view('home');
            // }
             

            // if(Auth::attempt($userdata)){
            //     echo 'SUCCESS!'
            // } else {
            //     return Redirect::to('/')
            // }
        //}
    }

    public function plan()
    {
        return view('studyplan');
    }

    public function progress()
    {
        return view('acadprogress');
    }

    public function wishlist()
    {
        return view('addwishlist');
    }

    public function preference()
    {
        return view('addpreference');
    }
}
