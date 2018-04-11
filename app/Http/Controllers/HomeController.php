<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Redirector;
use Carbon\Carbon;
use App\User;
use Session;
use Helper;

//use Auth;
 
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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

        // \Cookie::queue(
        // \Cookie::forget('XSRF-TOKEN')
        // );
        // return $this->sendResponse([], 'Logout successfully')
        //             ->withCookie(\Cookie::forever('CLIENT_ID_COOKIE', $CLIENT_ID));
        Cookie::queue(Cookie::forget($this->testParamName, '/', $this->cookieDomain));
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