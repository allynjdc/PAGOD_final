<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'profile_picture', 'password', 'course', 'courses_taken'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function courseName(){
        if ($this->course == "ba cd"){
            return "BA in Community Development";
        }elseif ($this->course == "ba cms"){
            return "BA in Comminucation and Media Studies";
        }elseif ($this->course == "ba hist"){
            return "BA in History";
        }elseif ($this->course == "ba lit") {
            return "BA in Literature";
        }elseif ($this->course == "ba polsci (double major)") {
            return "BA in Political Science (Double Major)";
        }elseif ($this->course == "ba polsci (single major)") {
            return "BA in Political Science (Single Major)";
        }elseif ($this->course == "ba psych") {
            return "BA in Psychology";
        }elseif ($this->course == "ba socio") {
            return "BA in Sociology";
        }elseif ($this->course == "bs accountancy") {
            return "BS in Accountancy";
        }elseif ($this->course == "bs appmath") {
            return "BS in Applied Mathematics";
        }elseif ($this->course == "bs bio") {
            return "BS in Biology";
        }elseif ($this->course == "bs business administration") {
            return "BS in Business Administration";
        }elseif ($this->course == "bs chem") {
            return "BS in Chemistry";
        }elseif ($this->course == "bs chemical engineering") {
            return "BS in Chemical Engineering";
        }elseif ($this->course == "bs cmsc") {
            return "BS in Computer Science";
        }elseif ($this->course == "bs econ") {
            return "BS in Economics";
        }elseif ($this->course == "bs fisheries") {
            return "BS in Fisheries";
        }elseif ($this->course == "bs food technology") {
            return "BS in Food Technology";
        }elseif ($this->course == "bs management") {
            return "BS in Management";
        }elseif ($this->course == "bs ph") {
            return "BS in Public Health";
        }
        return "BS in Statistics";
    }
}
