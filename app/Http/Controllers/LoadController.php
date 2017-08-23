<?php

namespace HoursLoad\Http\Controllers;

use HoursLoad\Professors;
use HoursLoad\Subject;
use Illuminate\Http\Request;

class LoadController extends Controller
{
    var $professors;

    public $subjects;

    public function __construct() {
       //$this->professors = Professors::all(array('firstName'));
       $this->professors = Professors::getProfessors();
       $this->subjects = Subject::all(array('name', 'course', 'term'));
    }

    public function index() {
        return view('index',
            array('title' => 'Welcome','description' => '',
                'page' => 'index', 'prof' => $this->professors));
    }


    public function showSub(){
        return view('subjects',
            array('title' => 'Subjects','description' => '',
                'page' => 'subjects', 'sub' => $this->subjects));
    }

    public function showProf($idProf){
        $prof = new Professors();
        return view('profile',
            array('title' => 'Profile','description' => '',
                'page' => 'profile', 'user' => $prof->findById($idProf)));
    }


    public function show($name)
    {
        return view('index',array('name' => $name));
    }
}
