<?php

namespace HoursLoad\Http\Controllers;

use HoursLoad\AddForm;
use HoursLoad\Http\Requests\AddLoadFormRequest;
use HoursLoad\Professors;
use HoursLoad\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoadController extends Controller
{
    var $professors;

    public $subjects;

    public function __construct() {
       //$this->professors = Professors::all(array('firstName'));
       $this->professors = Professors::getProfessors();
       $this->subjects = Subject::all(array('idSubjects','name', 'course', 'term'));
    }

    public function index() {
        return view('index',
            array('title' => 'Welcome','description' => '',
                'page' => 'index', 'prof' => $this->professors));
    }


    public function showSub($idProf){
        return view('subjects',
            array('title' => 'Subjects','description' => '',
                'page' => 'subjects', 'sub' => $this->subjects, 'idProf' => $idProf));
    }

    public function showProf($idProf){
        return view('profile',
            array('title' => 'Profile','description' => '',
                'page' => 'profile', 'user' => Professors::findById($idProf)));
    }

    public function addForm($idProf, $idSub){
        return view('addform',
            array('title' => 'AddForm','description' => '',
                'page' => 'addform', 'idProf' => $idProf, 'idSub' => $idSub, 'arrLoad' => Subject::getWorksForSubject($idSub)));
    }

    public function updateLoad($idProf, AddLoadFormRequest $request){
        $model = new AddForm();
        $model->idProf = $idProf;
        $model->hours = $request->get('hours');
        $model->fkLoad = $request->get('idLoadSub');


        if ($model->addLoad()){
            return "ok";
        }
        else
            return "error";




       /* return view('welcome',
            array($model->hours))
            ->with('message', 'Your category has been created!');*/

    }


    public function show($name)
    {
        return view('index',array('name' => $name));
    }
}
