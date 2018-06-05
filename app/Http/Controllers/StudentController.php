<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Bc\BackgroundProcess\BackgroundProcess;
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
            if(sizeof($val)==7){
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
                    if(is_numeric($row[3])){
                        $sum1 = $sum1 + $row[3];
                    }
                }
            } else if($row[0]==1 && $row[1]==2 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0 || substr_count($row[2], 'NSTP')>0){
                    $sum2 = $sum2 + 0;
                } else {
                    if(is_numeric($row[3])){
                        $sum2 = $sum2 + $row[3];
                    }
                }
            } else if($row[0]==2 && $row[1]==1 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0){
                    $sum3 = $sum3 + 0;
                } else {
                    if(is_numeric($row[3])){
                        $sum3 = $sum3 + $row[3];
                    }
                }
            } else if($row[0]==2 && $row[1]==2 && $row[4] > 0){
                if(substr_count($row[2], 'PE')>0){
                    $sum4 = $sum4 + 0;
                } else {
                    if(is_numeric($row[3])){
                        $sum4 = $sum4 + $row[3];
                    }
                }
            } else if($row[0]==3 && $row[1]==1 && $row[4] > 0 && is_numeric($row[3])){
                $sum5 = $sum5 + $row[3];
            } else if($row[0]==3 && $row[1]==2 && $row[4] > 0 && is_numeric($row[3])){
                $sum6 = $sum6 + $row[3];
            } else if($row[0]==4 && $row[1]==1 && $row[4] > 0 && is_numeric($row[3])){
                $sum7 = $sum7 + $row[3];
            } else if($row[0]==4 && $row[1]==2 && $row[4] > 0 && is_numeric($row[3])){
                $sum8 = $sum8 + $row[3];
            } else if($row[0]==5 && $row[1]==1){
                $has5th = $has5th + 1;
                if($row[4] > 0 && is_numeric($row[3])){
                    $sum10 = $sum10 + $row[3];
                }
            } else if($row[0]==5 && $row[1]==2 && $row[4] > 0 && is_numeric($row[3])){
                $sum11 = $sum11 + $row[3];
            }

            // IF MAY MIDYEAR
            if($row[0]==3 && strlen($row[1])>3 && $row[4] > 0){
                $mid[$midr][0] = $row[2];
                $mid[$midr][1] = $row[3];
                $mid[$midr][2] = $row[4];
                $midr++;  
                if(is_numeric($row[3])){
                    $sum9 = $sum9 + $row[3];
                }
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
        $cpenstp = 1;
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
                } else if (substr_count(strtoupper($val[1]),"PE")>0||substr_count(strtoupper($val[1]),"NSTP")>0||substr_count(strtoupper($val[1]),"PE1")>0) {
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

        $ccore1 = ((int)$ccore / (int)$values[0]) * 100;
        $celect1 = ((int)$celect / (int)$values[1]) * 100;
        $cah1 = ((int)$cah / (int)$values[2]) * 100;
        $cmst1 = ((int)$cmst / (int)$values[3]) * 100;
        $cssp1 = ((int)$cssp / (int)$values[4]) * 100;
        $copen1 = ((int)$cpenstp / (int)$values[5]) * 100;

        return view('acadprogress', compact('core','ccore', 'ccore1','ah','cah','cah1','ssp','cssp','cssp1','mst','cmst','cmst1','elect','celect','celect1','open','cpenstp','copen1','values'));
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
        // final[x][0] year; final[x][1] sem; final[x][2] subject; final[x][3] type; final[x][4] units; final[x][5] complete or not; final[x][6] lec/lab
        $lines = explode('/', $output);
        foreach ($lines as $line => $value) {            
            $val = explode(',', $value);
            if(sizeof($val)==7){
                $final[$row][0] = $val[0];
                $final[$row][1] = $val[1];
                if(!$val[2] || strlen($val[2])<3){
                    // GE or PE
                    $final[$row][2] = strtoupper($val[3]);
                } else {
                    // NON-GE
                    $final[$row][2] = strtoupper($val[2]);
                }
                $final[$row][3] = $val[3];
                $final[$row][4] = $val[4];
                $final[$row][5] = $val[5];
                $final[$row][6] = $val[6];
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
                $sfinal[$row][5] = $subj[5];
                $sfinal[$row][6] = $subj[6];
                $row++;
            }
        }

        // COUNT ONLY THE SUM OF UNITS PER SEMS
        $sum1 = 0;
        foreach($sfinal as $row) {
            if(substr_count(strtoupper($row[3]),"PE")>0  || strpos(strtolower($row[3]),"pe")){
                $sum1 = $sum1 + 0;
            } else {
                if(is_numeric($row[4])){
                    $sum1 = $sum1 + $row[4];
                }
            }   
        }         

        //IF PREFERENCES CSV FILE EXISTS
        $preferences = array();
        $preferencespath = "preferences/".Auth::user()->id.".csv";
        if (file_exists(public_path($preferencespath))){

            $handle = fopen($preferencespath, "r");
            while($csvLine = fgetcsv($handle, ",")){
                //f(strpos(strtolower($csvLine[3]), "core") === false and (strpos(strtolower($csvLine[3]),"service") === false)){
                    array_push($preferences, strtoupper($csvLine[2]));
                //}
            }
            fclose($handle);
        }
        // echo sizeof($preferences);

        $con = 0;
        return view('preferences', compact('ah','mst','ssp','core','year','sem','sfinal','sum1','con','preferences'));
    } 

    public function sanitize($str){
        $str = strtolower(str_replace(" ","",$str));
        $str = str_replace("\"","",$str);
        $str = str_replace("'","", $str);
        return $str;
    }

    public function detectQuotes($str){
        return preg_match('/"/', $str) || preg_match("/'/", $str);
    }

    public function submitpreference(Request $request){
        $year = Input::get('year');
        $sem = Input::get('sem');
        $con = Input::get('subject_count');

        $subjs = array();
        for($i=1;$i<=$con;$i++){
            $subject = Input::get("subject_".(string)$i);
            // $subject = strtolower(str_replace("",'"',$subject));
            array_push($subjs,array($year,$sem,$subject,Input::get("type_".(string)$i),Input::get("unit_".(string)$i),Input::get("leclab_".(string)$i)));
        }
 
        //
        // FOR VALIDATION
        //
        $cor = Auth::user()->course;
        $course = "\"$cor\"";
        $courses_taken = Auth::user()->courses_taken;
        $flag = 0;
        $flag_no_input = 0;
        $invalid_subjects = array();
        $quoted_subjects = array();
        foreach($subjs as $sub){
            $str = $this->sanitize($sub[2]);
            $type = strtolower(str_replace(" ", "", $sub[3]));
            if (!empty($str))
            {
                if($this->detectQuotes($sub[2])){
                    array_push($quoted_subjects, $sub[2]);
                    $flag = 1;
                    continue;
                }

                if((strpos(strtolower($type), "elective") === false) and (strpos(strtolower($type),"pe") === false)){
                    $process = new Process("python python\p_validation.py $course $courses_taken $str");
                    $process->run();
        
                    if(!$process->isSuccessful()){
                        throw new ProcessFailedException($process);
                    }
                    $output = $process->getOutput();
                    if(strcmp($output,"FALSE") > 1){
                        array_push($invalid_subjects, $sub[2]);
                        $flag = 1;
                    }
                }else{
                    $sub[2] = $str;
                    continue;
                }
            }
            else
            {
                $flag = 1;
                $flag_no_input = 1;
            }
        }
        
        if($flag == 1){
            $error_messages = array();
            if (!empty($invalid_subjects)){
                $error_message = array(
                    "is_invalid" => 1,
                    "is_quoted" => 0,
                    "is_blank" => 0,
                    "title" => "INVALID SUBJECT ERROR. ",
                    "body" => "Problems were found at the following inputs:",
                    "subjects" => $invalid_subjects
                );
                array_push($error_messages, $error_message);
            }
            if (!empty($quoted_subjects)){
                $error_message = array(
                    "is_invalid" => 0,
                    "is_quoted" => 1,
                    "is_blank" => 0,
                    "title" => "QUOTED INPUT ERROR. ",
                    "body" => "Problems were found at the following inputs:",
                    "subjects" => $quoted_subjects
                );
                array_push($error_messages, $error_message);
            }
            if($flag_no_input){
                $error_message = array(
                    "is_invalid" => 0,
                    "is_quoted" => 0,
                    "is_blank" => 1,
                    "title" => "BLANK INPUT ERROR. ",
                    "body" =>  "Some fields had no input.",
                );
                array_push($error_messages, $error_message);
            }
            return Redirect::to('addpreference')->with('mult_error', $error_messages);
        } else {
            return $this->savePreferences($subjs);
        }

    }

    public function wishlist(Request $request)
    {
        $preferencespath = "preferences/".Auth::user()->id.".csv";
        if (file_exists(public_path($preferencespath))){
            $datapath = public_path("csv/data.csv");
            $instructors = array();
            if(file_exists($datapath)){
                $handle = fopen($datapath, "r");
                while($csvLine = fgetcsv($handle, ",")){
                    $instructor = trim(utf8_encode($csvLine[11]));
                    if($instructor != "TBA"){
                        if(count(explode(" / ", $instructor)) < 2){
                            array_push($instructors, $instructor);
                        }else{
                            $mult_instructor = explode(" / ", $instructor);
                            foreach ($mult_instructor as $key => $instructor) {
                                array_push($instructors, $instructor);
                            }
                        }
                    }
                }
                fclose($handle);
            }
            $instructors = array_unique($instructors);
            sort($instructors);

            $violated_path = public_path("violated_constraints/".Auth::user()->id.".csv");
            $violated = array();
            $included_constraints = array();
            if(file_exists($violated_path)){
                $handle = fopen($violated_path, "r");
                while($csvLine = fgetcsv($handle, ",")){
                    $coursename = strtolower($csvLine[0]);
                    $included = $csvLine[1];
                    $is_violated = $csvLine[2];
                    if ($is_violated){
                        array_push($violated, $coursename);
                    }
                    if ($included){
                        array_push($included_constraints, $coursename);
                    }
                }
                fclose($handle);
            }
            $constraintspath = public_path("constraints/".Auth::user()->id.".csv");
            $header = true;
            $constraintHigh = array();
            $constraintLow = array();
            $constraintMed = array();
            if(file_exists($constraintspath)){
                $handle = fopen($constraintspath, "r");
                $header = true;
                $constraintHigh = array();
                $constraintLow = array();
                $constraintMed = array();
                while($csvLine = fgetcsv($handle, ",")){
                    if ($header){
                        $header = false;
                    }else{
                        $text = "";
                        $constraint_type = "";
                        $musthave = "";
                        $instructor = "";
                        $course = $csvLine[6];
                        $days = $csvLine[7];
                        $priority = "high";
                        $start = $csvLine[8];
                        $end = $csvLine[9];
                        $maxnum = 1;
                        if ($csvLine[12] == "M"){
                            $priority = "medium";
                        }else if ($csvLine[12] == "L"){
                            $priority = "low";
                        }
                        if ($csvLine[0] || $csvLine[1]){
                            $constraint_type = "meetingtime";
                            $text = "Classes must start from ".$start." to ".$end;
                            if ($csvLine[1]){
                                $text = "No Classes";
                                if ($start != $end){
                                    $text .= " from ".$start." to ".$end;
                                }else{
                                    $start = "8:00 AM";
                                    $end = "8:00 AM";
                                }
                            }
                            $text .= " on ".str_replace(" ", ", ", $days);
                        }else if ($csvLine[2] || $csvLine[3]) {
                            $constraint_type = "courserestriction";
                            $musthave = "musthave";
                            $text = "Must Have ";
                            if($csvLine[3]){
                                $musthave = "mustnothave";
                                $text = "Must Not Have ";
                            }
                            $text .= strtoupper($course);
                        }else if ($csvLine[4]) {
                            $constraint_type = "maxstraight";
                            $maxnum = $csvLine[11];
                            $text = "Maximum Number of Straight Classes must be ".$maxnum;
                        }else if ($csvLine[5]) {
                            $constraint_type = "maxdaily";
                            $maxnum = $csvLine[11];
                            $text = "Maximum Number of Daily Classes must be ".$maxnum;
                        }else if ((!empty($csvLine[10])) || ($csvLine[10] != "")){
                            $constraint_type = "prefinstructor";
                            $instructor = $csvLine[10];
                            $text = "Preferred instructor is ".$instructor;
                        }
                        $not_violated = array_search(strtolower($text), $violated);
                        if (is_int($not_violated)){
                            $not_violated = true;
                        }
                        $included = array_search(strtolower($text), $included_constraints);
                        if (is_int($included)){
                            $included = true;
                        }
                        $constraint = array(
                            "constraint_type" => $constraint_type,
                            "priority" => $priority,
                            "musthave" => $musthave,
                            "start_time" => $start,
                            "end_time" => $end,
                            "course" => $course,
                            "instructor" => $instructor,
                            "days" => $days,
                            "maxnum" => $maxnum,
                            "text" => $text,
                            "not_violated" => $not_violated,
                            "included" => $included
                        );
                        if ($priority == "high"){
                            array_push($constraintHigh, $constraint);
                        }else if($priority == "medium"){
                            array_push($constraintMed, $constraint);
                        }else if($priority == "low"){
                            array_push($constraintLow, $constraint);
                        }
                    }
                } 
                fclose($handle);
            }

            $constraintpreferredpath = public_path("preferred subjects/".Auth::user()->id.".csv");
            $constraintPreferred = array();
            if(file_exists($constraintpreferredpath)){
                $handle = fopen($constraintpreferredpath, "r");
                while($csvLine = fgetcsv($handle, ",")){
                    $text = "Must Have ".strtoupper($csvLine[0]);
                    $not_violated = array_search(strtolower($text), $violated);
                    if (is_int($not_violated)){
                        $not_violated = true;
                    }
                    $included = array_search(strtolower($text), $included_constraints);
                    if (is_int($included)){
                        $included = true;
                    }
                    $constraint = array(
                        "text" => $text,
                        "not_violated" => $not_violated,
                        "included" => $included
                    );
                    array_push($constraintPreferred, $constraint);
                }
            }

            $schedulepath = public_path("schedule/".Auth::user()->id.".csv");
            $schedule = array();
            if(file_exists($schedulepath)){
                $handle = fopen($schedulepath, "r");
                while($csvLine = fgetcsv($handle, ",")){
                    $year = $csvLine[0];
                    $semester = $csvLine[1];
                    $course = $csvLine[2];
                    $campus = $csvLine[3];
                    $leclab = $csvLine[4];
                    $section = $csvLine[5];
                    $units = $csvLine[6];
                   // $instructor = $csvLine[7];        // DAPAT I HIDE DAW ANG NAME SNG INSTRUCTOR
                    $instructor = "";
                    $sessions = explode("|", $csvLine[8]);
                    $array_sessions = array();
                    foreach ($sessions as $key => $session) {
                        $session = explode(",", $session);
                        $room = $session[0];
                        $days = explode(" ",$session[1]);
                        foreach ($days as $key => $day) {
                            $days[$key] = $this->returnIndex($day);
                        }
                        $start = $this->convertToTime($session[2]);
                        $end = $this->convertToTime($session[3]);
                        array_push($array_sessions, array(
                            "room" => $room,
                            "days" => $days,
                            "start" => $start,
                            "end" => $end
                        ));
                    }
                    $subject = array(
                        "coursename" => $course,
                        "units" => $units,
                        "leclab" => $leclab,
                        "section" => $section,
                        "instructor" => $instructor,
                        "sessions" => $array_sessions
                    );
                    array_push($schedule, $subject);
                }
                fclose($handle);
            }

            $restart = Auth::user()->need_restart;
            // var_dump($constraintHigh);
            // var_dump($constraintMed);
            // var_dump($constraintLow);
            // var_dump($constraintPreferred);
            return view('addwishlist', compact('constraintHigh', 'constraintLow', 'constraintMed', 'constraintPreferred','schedule', 'instructors','restart'));
            
            
        }
        return Redirect::to('addpreference')->with('error',"Your subject preferences have yet to be added. Please input your preferences first.");
    }

    public function returnIndex($day){
        $days = ["M", "T", "W", "Th", "F", "S"];
        return array_search($day, $days);
    }

    public function convertToTime($decimalTime){
    $stringTime = "";
    $hourPart = floor($decimalTime);
    $minutePart = $decimalTime - $hourPart;
    $timeOfDay = "am";
    if ($hourPart - 12 >= 0){
        $stringTime .= ($hourPart - 12);
        $timeOfDay = "pm";
    }else{
        $stringTime .= $hourPart;
        $timeOfDay = "am";
    }
    if (strlen($stringTime) < 2){
        $stringTime = "0".$stringTime;
    }
    $stringTime .= ":";
    $minutePart = $minutePart * 60;
    if (strlen($minutePart."") < 2){
        $minutePart = $minutePart . "0";
    }
    $stringTime .= ($minutePart . $timeOfDay);
    return $stringTime;
}

    public function generateSchedule(Request $request)
    {
        $cor = Auth::user()->course;
        $course = "\"$cor\"";
        $courses_taken = Auth::user()->courses_taken;
        $constraintspath =  "\"constraints\\\\".Auth::user()->id.".csv\"";
        $preferencespath =  "\"preferences\\\\".Auth::user()->id.".csv\"";
        $schedulepath = "\"schedule\\\\".Auth::user()->id.".csv\"";
        $violated_path = "\"violated_constraints\\\\".Auth::user()->id.".csv\"";
        $preferred_path = "\"preferred subjects\\\\".Auth::user()->id.".csv\"";
        $user = Auth::user();
        $user->schedule = $schedulepath;
        $user->need_restart = 0;
        $user->save();
        if (file_exists(public_path("schedule/".Auth::user()->id.".csv"))){
            unlink(public_path("schedule/".Auth::user()->id.".csv"));
        }
        // $process = new Process("python python\localsearch.py $course $courses_taken $constraintspath $preferencespath $schedulepath $violated_path $preferred_path");
        // $process->run();
        // if(!$process->isSuccessful()){
        //     throw new ProcessFailedException($process);
        // }
        $command = "start /B python.exe python\localsearch.py $course $courses_taken $constraintspath $preferencespath $schedulepath $violated_path $preferred_path 2>&1";
        $command = escapeshellcmd($command);
        $shell = new \COM("WScript.Shell");
        $oExec = $shell->Run("cmd /C $command", 0, false);
        return "run python";
    }

    public function acquireSchedule(Request $request)
    {
        $schedulepath = "\"schedule\\\\".Auth::user()->id.".csv\"";
        if (file_exists(public_path("schedule/".Auth::user()->id.".csv"))){
            $process = new Process("python python\acquire_schedule.py $schedulepath");
            $process->run();
            if(!$process->isSuccessful()){
                throw new ProcessFailedException($process);
            }
            $violated_path = public_path("violated_constraints/".Auth::user()->id.".csv");
            $violated = array();
            if(file_exists($violated_path)){
                $handle = fopen($violated_path, "r");
                while($csvLine = fgetcsv($handle, ",")){
                    if($csvLine[2]){
                        array_push($violated, strtolower($csvLine[0]));
                    }
                }
                fclose($handle);
            }
            // var_dump($process->getOutput());
            return array(json_decode($process->getOutput(), true), $violated);
        }
        return "NONE";
    }

    // public function acquireViolated(Request $request)
    // {
    //     $schedulepath = "schedule/".Auth::user()->id.".csv";
    //     $violated_path = public_path("violated_constraints/".Auth::user()->id.".csv");
    //     if(file_exists(public_path($schedulepath)) && file_exists(public_path($violated_path))){
    //         $violated = array();
    //         $handle = fopen($violated_path, "r");
    //         while($csvLine = fgetcsv($handle, ",")){
    //             array_push($violated, strtolower($csvLine[0]));
    //         }
    //         fclose($handle);
    //         return $violated;
    //     }
    //     return "NONE";
    // }

    public function saveConstraints(Request $request)
    {
        $constraintspath = "constraints/".Auth::user()->id.".csv";
        $violated_path = public_path("violated_constraints/".Auth::user()->id.".csv");

        //Saves all of the constraints that are not preferences
        $selected_array = array('meeting_time','no_class','musthave','mustnothave','maxstraight','maxdaily','subject','days','start','end','instructor','maxnum','priority');
        $output = fopen($constraintspath, 'w');
        fputcsv($output, $selected_array);
        if ($request->constraints != null){
            $array_data = array();
            foreach ($request->constraints as $key => $constraint) {
                $row = array(
                    $constraint['meeting_time'],
                    $constraint['no_class'],
                    $constraint['musthave'],
                    $constraint['mustnothave'],
                    $constraint['maxstraight'],
                    $constraint['maxdaily'],
                    $constraint['subject'],
                    $constraint['days'],
                    $constraint['start'],
                    $constraint['end'],
                    $constraint['instructor'],
                    $constraint['maxnum'],
                    $constraint['priority']);
                array_push($array_data, $row);
            }
            foreach ($array_data as $row){
                fputcsv($output, $row);
            }
        }
        fclose($output);

        //Saves all of the constraint names
        $output = fopen($violated_path, 'w');
        if ($request->constraint_names != null){
            $array_data = array();
            foreach ($request->constraint_names as $key => $constraint) {
                $row = array(
                    $constraint['text'],
                    $constraint['included'],
                    $constraint['violated']);
                array_push($array_data, $row);
            }
            foreach ($array_data as $row){
                fputcsv($output, $row);
            }
        }
        fclose($output);
        return $request->constraints;
    }

    public function savePreferences($array_data){
        $userid = Auth::user()->id;
        $filename = $userid.".csv";
        $user = Auth::user();
        $user->need_restart = 1;
        $user->save();
        $selected_array = array('year','semester','courseName','type','units','lec/lab');
        $preferences_output = fopen('preferences/'.$filename, 'w') ;
        $preferred_subjects_output = fopen('preferred subjects/'.$filename, 'w');

        fputcsv($preferences_output, $selected_array);

        foreach ($array_data as $row){
            $type = $row[3];
            $courseName = strtolower(str_replace("",'"',$row[2]));
            if (strpos($type, "elective") !== false){
                fputcsv($preferred_subjects_output, array($courseName));
                // $courseName = "";
            }
            $row[2] = $courseName;
            fputcsv($preferences_output, $row);
        }
        
        fclose($preferences_output);
        fclose($preferred_subjects_output);

        return Redirect::to('home')->with('success','Preferences created successfully!');
    }

    public function offeredSchedules(){

        $preferencespath = "preferences/".Auth::user()->id.".csv";
        if (file_exists(public_path($preferencespath))){

            $cor = Auth::user()->id;
            $course = "\"$cor\"";
            $process = new Process("python python\class_offerings.py $course");
            $process->run();

            if(!$process->isSuccessful()){
                throw new ProcessFailedException($process);
            }

            // SEPARATING THE SINGLE STRING RESULT FROM PYTHON ACCODING TO COURSETYPES
            $output = $process->getOutput();
            //echo $output;
            $i  = 0;
            $offerings = explode('/', $output);
            foreach ($offerings as $set) {
                $data = explode('|', $set);
                for($j = 0; $j < sizeof($data)-1 ; $j++){
                    $final[$i][$j] = $data[$j];
                    if($j == 8 and substr_count(strtolower($final[$i][8]),"lab")>0){
                        $final[$i][4] = "";
                        //echo yes;
                    }
                    // $final[$i][1] = $data[1];
                    // $final[$i][2] = $data[2];
                    // $final[$i][3] = $data[3];
                    // $final[$i][4] = $data[4];
                    // $final[$i][5] = $data[5];
                    // $final[$i][6] = $data[6];
                    // $final[$i][7] = $data[7];
                    //echo $data[8];
                }
                $i = $i+1;
            }

            return view('classoffering',compact('final'));
        }

        #return Redirect::to('addpreference')->with('error',"Your subject preferences have yet to be added. Please input your preferences first.");
    }
}
