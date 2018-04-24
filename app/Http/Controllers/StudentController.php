<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use Session;
use Helper;
use Auth;
use Hash;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class StudentController extends Controller
{

	public function index(){
 
		// $rules = array(
		//     'username' => 'required|min:9|max:9', 
		//     'password' => 'required|min:3' 
		// );
 
		// // run the validation rules on the inputs from the form
		// $validator = Validator::make(Input::all(), $rules);

		// // if the validator fails, redirect back to the form
		// if($validator->fails()) {
		//     return Redirect::to('/login')
		//         ->withErrors($validator) 
		//         ->withInput(Input::except('password')); 

		// } else {

		//     // create our user data for the authentication
		//     $data = array(
		//         'username' => Input::get('username'),
		//         'password'  => Input::get('password')
		//     );

		//     $user = User::where('username',$data['username'])
		// 		->first();

		//     // attempt to do the login
		// 	// Auth::attempt($data)
		//     if(Hash::check($data['password'], $user->password)) {

  //               Auth::login($user);
  //               echo Auth::user()->id;
  //       		//return view('home', compact('user'));

		//     } else {        

		//         // validation not successful, send back to form 
		//         return Redirect::to('/login');

		//     }
		// }
		
	}

	public function plan(Request $request)
    {

        $cor = Auth::user()->course;
        $course = "\"$cor\"";
        $courses_taken = Auth::user()->courses_taken;
        $process = new Process("python python\study_plan.py $course $courses_taken");
        $process->run();

        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();
        $row = 0;

        // CONVERTING THE SINGLE STRING RESULT FROM PYTHON INTO 2-D ARRAY
        // final[x][0] year; final[x][1] sem; final[x][2] subject; final[x][3] units; final[x][4] complete or not
        $lines = explode('/', $output);
        foreach ($lines as $line => $value) {            
            $val = explode(',', $value);
            if(sizeof($val)==6){
                $final[$row][0] = $val[0];
                $final[$row][1] = $val[1];
                if(!$val[2] || strlen($val[2])<3){
                    // GE or PE
                    $final[$row][2] = strtoupper($val[3]);
                } else {
                    // NON-GE
                    $final[$row][2] = strtoupper($val[2]);
                }
                $final[$row][3] = $val[4];
                $final[$row][4] = $val[5];
                $row++;
            }
        }

        // COUNT ONLY THE SUM OF UNITS PER SEMS
        $midr = 0;
        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
        $sum4 = 0;
        $sum5 = 0;
        $sum6 = 0;
        $sum7 = 0;
        $sum8 = 0;
        $sum9 = 0;
        $sum10 = 0;
        $sum11 = 0;
        $has5th = 0;
        foreach($final as $row) {
            if($row[0]==1 && $row[1]==1 && $row[4] > 0){
                if(substr_count($row[2], 'PE1')>0 || substr_count($row[2], 'NSTP')>0){
                    $sum1 = $sum1 + 0;
                } else {
                    $sum1 = $sum1 + $row[3];
                }
            } else if($row[0]==1 && $row[1]==2 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0 || substr_count($row[2], 'NSTP')>0){
                    $sum2 = $sum2 + 0;
                } else {
                    $sum2 = $sum2 + $row[3];
                }
            } else if($row[0]==2 && $row[1]==1 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0){
                    $sum3 = $sum3 + 0;
                } else {
                    $sum3 = $sum3 + $row[3];
                }
            } else if($row[0]==2 && $row[1]==2 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0){
                    $sum4 = $sum4 + 0;
                } else {
                    $sum4 = $sum4 + $row[3];
                }
            } else if($row[0]==3 && $row[1]==1 && $row[4] > 0){
                $sum5 = $sum5 + $row[3];
            } else if($row[0]==3 && $row[1]==2 && $row[4] > 0){
                $sum6 = $sum6 + $row[3];
            } else if($row[0]==4 && $row[1]==1 && $row[4] > 0){
                $sum7 = $sum7 + $row[3];
            } else if($row[0]==4 && $row[1]==2 && $row[4] > 0){
                $sum8 = $sum8 + $row[3];
            } else if($row[0]==5 && $row[1]==1){
                $has5th = $has5th + 1;
                if($row[4] > 0){
                    $sum10 = $sum10 + $row[3];
                }
            } else if($row[0]==5 && $row[1]==2 && $row[4] > 0){
                $sum11 = $sum11 + $row[3];
            }

            // IF MAY MIDYEAR
            if($row[0]==3 && strlen($row[1])>3 && $row[4] > 0){
                $mid[$midr][0] = $row[2];
                $mid[$midr][1] = $row[3];
                $mid[$midr][2] = $row[4];
                $midr++;  
                $sum9 = $sum9 + $row[3];
            }            

        }

        // RETURN THE PAGE VIEW
        return view('studyplan', compact('final','midr','mid','sum1','sum2','sum3','sum4','sum5','sum6','sum7','sum8','sum9','sum10','sum11','has5th'));
        
    }

    public function progress(Request $request)
    {
        $cor = Auth::user()->course;
        $course = "\"$cor\"";
        $courses_taken = Auth::user()->courses_taken;
        $process = new Process("python python\acad_progress.py $course $courses_taken");
        $process->run();

        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }

        // CONVERTING THE SINGLE STRING RESULT FROM PYTHON INTO 2-D ARRAY 
        // AND SEPARATING COURSES TAKEN BY COURSETYPES
        $output = $process->getOutput();
        $ccore = 0;
        $cah = 0; 
        $cssp = 0;
        $cmst = 0;
        $celect = 0;
        $cpenstp = 0;
        $lines = explode('/', $output);
        foreach ($lines as $line) {          
            $val = explode(',', $line);
            if(sizeof($val)>1){
                if((substr_count(strtoupper($val[1]),"CORE")>0) || (substr_count(strtoupper($val[1]),"SERVICE")>0)){
                    if((substr_count(strtoupper($val[0]),"PE1")>0)){
                        $open[$cpenstp][0] = strtoupper($val[0]);
                        $open[$cpenstp][1] = $val[2];
                        $cpenstp++;
                    } else {
                        $core[$ccore][0] = strtoupper($val[0]);
                        $core[$ccore][1] = $val[2];
                        $ccore++;
                    }                    
                } else if (substr_count(strtoupper($val[1]),"GE(AH)")>0) {        
                    $ah[$cah][0] = strtoupper($val[0]);
                    $ah[$cah][1] = $val[2];
                    $cah++;
                } else if (substr_count(strtoupper($val[1]),"GE(MST)")>0) {
                    $mst[$cmst][0] = strtoupper($val[0]);
                    $mst[$cmst][1] = $val[2];
                    $cmst++;
                } else if (substr_count(strtoupper($val[1]),"GE(SSP)")>0) {
                    $ssp[$cssp][0] = strtoupper($val[0]);
                    $ssp[$cssp][1] = $val[2];
                    $cssp++;
                } else if (substr_count(strtoupper($val[1]),"ELECTIVE")>0) {
                    $elect[$celect][0] = strtoupper($val[0]);
                    $elect[$celect][1] = $val[2];
                    $celect++;
                } else if (substr_count(strtoupper($val[1]),"PE")>0||substr_count(strtoupper($val[1]),"NSTP")>0) {
                    $open[$cpenstp][0] = strtoupper($val[0]);
                    $open[$cpenstp][1] = $val[2];
                    $cpenstp++;
                } 
            }
        }

        $process = new Process("python python\courses_counts.py $course $courses_taken");
        $process->run();

        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }

        // AND COUNTING THE NUMBER OF COURSES TAKEN BY COURSETYPES
        $counts = $process->getOutput();
        $values = explode(',', $counts);

        $ccore = ($ccore / $values[0]) * 100;
        $celect = ($celect / $values[1]) * 100;
        $cah = ($cah / $values[2]) * 100;
        $cmst = ($cmst / $values[3]) * 100;
        $cssp = ($cssp / $values[4]) * 100;
        $cpenstp = ($cpenstp / $values[5]) * 100;

        return view('acadprogress', compact('core','ccore','ah','cah','ssp','cssp','mst','cmst','elect','celect','open','cpenstp','values'));
    }

    public function preference(Request $request)
    {
        $cor = Auth::user()->course;
        $course = "\"$cor\"";
        $courses_taken = Auth::user()->courses_taken;
        $process = new Process("python python\preference.py $course $courses_taken");
        $process->run();

        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }

        // SEPARATING THE SINGLE STRING RESULT FROM PYTHON ACCODING TO COURSETYPES
        $output = $process->getOutput();
        $subjType = explode('/', $output);

        $ah = explode(",", $subjType[0]);
        $mst = explode(",", $subjType[1]);
        $ssp = explode(",", $subjType[2]);
        $core = explode(",", $subjType[3]);
        array_pop($ah);
        array_pop($mst);
        array_pop($ssp);
        array_pop($core);

        $process = new Process("python python\study_plan.py $course $courses_taken");
        $process->run();

        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }

        // SEPARATING THE SINGLE STRING RESULT FROM PYTHON
        // EXTRACTING ONLY THE PRECEEDING SEMESTER
        $output = $process->getOutput();
        $row = 0;

        // CONVERTING THE SINGLE STRING RESULT FROM PYTHON INTO 2-D ARRAY
        // final[x][0] year; final[x][1] sem; final[x][2] subject; final[x][3] units; final[x][4] complete or not
        $lines = explode('/', $output);
        foreach ($lines as $line => $value) {            
            $val = explode(',', $value);
            if(sizeof($val)==6){
                $final[$row][0] = $val[0];
                $final[$row][1] = $val[1];
                if(!$val[2] || strlen($val[2])<3){
                    // GE or PE
                    $final[$row][2] = strtoupper($val[3]);
                } else {
                    // NON-GE
                    $final[$row][2] = strtoupper($val[2]);
                }
                $final[$row][3] = $val[4];
                $final[$row][4] = $val[5];
                $row++;
            }
        }

        foreach($final as $subj){
            if($subj[2] == strtoupper($core[0])){
                $year = $subj[0];
                $sem = $subj[1];
            }
        }

        // EXTRACTING ALL THE SUBJECT DETAILS OF THE NEXT SEMESTER
        $row=0;
        foreach($final as $subj){
            if($subj[0] == $year and $subj[1] == $sem){
                $sfinal[$row][0] = $subj[0];
                $sfinal[$row][1] = $subj[1];
                $sfinal[$row][2] = $subj[2];
                $sfinal[$row][3] = $subj[3];
                $sfinal[$row][4] = $subj[4];
                $row++;
            }
        }

        // COUNT ONLY THE SUM OF UNITS PER SEMS
        $sum1 = 0;
        foreach($sfinal as $row) {
            if($row[0]==1 && $row[1]==1 && $row[4] > 0){
                if(substr_count($row[2], 'PE1')>0 || substr_count($row[2], 'NSTP')>0){
                    $sum1 = $sum1 + 0;
                } else {
                    $sum1 = $sum1 + $row[3];
                }
            } else if($row[0]==1 && $row[1]==2 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0 || substr_count($row[2], 'NSTP')>0){
                    $sum1 = $sum1 + 0;
                } else {
                    $sum1 = $sum1 + $row[3];
                }
            } else if($row[0]==2 && $row[1]==1 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0){
                    $sum1 = $sum1 + 0;
                } else {
                    $sum1 = $sum1 + $row[3];
                }
            } else if($row[0]==2 && $row[1]==2 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0){
                    $sum1 = $sum1 + 0;
                } else {
                    $sum1 = $sum1 + $row[3];
                }
            } else {
                $sum1 = $sum1 + $row[3];
            }   
        }         

        $con = 0;
        //echo $output;
        return view('addpreference', compact('ah','mst','ssp','core','year','sem','sfinal','sum1','con'));
    } 

    public function submitpreference(Request $request){
        $year = Input::get('year');
        $sem = Input::get('sem');
        $con = Input::get('subject_count');

        for($i=1;$i<=$con;$i++){
            echo Input::get("subject_".(string)$i); 
        }
        
    }

    public function wishlist(Request $request)
    {
        return view('addwishlist');
    }

    public function generateSchedule(Request $request)
    {
        $cor = Auth::user()->course;
        $course = "\"$cor\"";
        $courses_taken = Auth::user()->courses_taken;
        // $process = new Process("python python\backtracking.py $course $courses_taken");
        $process = new Process("python python\localsearch.py $course $courses_taken");
        $process->run();
        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }
        // print($process->getOutput());
        // echo dump(json_decode($process->getOutput(), true));
        return json_decode($process->getOutput(), true);
        // return "HELLO";
    }
}
