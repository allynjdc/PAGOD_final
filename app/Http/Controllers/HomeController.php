<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
