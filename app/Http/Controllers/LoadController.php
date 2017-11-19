<?php

namespace HoursLoad\Http\Controllers;

use HoursLoad\AddForm;
use HoursLoad\Http\Requests\AddLoadFormRequest;
use HoursLoad\Professors;
use HoursLoad\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoadController extends Controller
{
    var $professors;

    public $subjects;

    public function __construct() {
       //$this->professors = Professors::all(array('firstName'));
       $this->professors = Professors::getProfessors();
       $this->subjects = Subject::getAll();
       // $this->subjects = Subject::getSubjects();
    }

    public function index($role) {
        if($role == '1')
            return view('index',
                array('title' => 'Welcome','description' => '',
                    'page' => 'index', 'prof' => $this->professors));
        if ($role == '2'){
            return view('profile',
                array('title' => 'Profile','description' => '',
                    'page' => 'profile', 'user' => Professors::getProfByFKUser(Auth::user()->idUser)));

        }
    }

    public function show()
    {
        return view('subjects',
            array('title' => 'Subjects','description' => '',
                'page' => 'subjects', 'sub' => $this->subjects));
    }

    public function showAllSubjects(){
        return view('allsubjects',
            array('title' => 'Subjects','description' => '',
                'page' => 'subjects', 'sub' => $this->subjects));
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

            return redirect('subjects/'.$idProf)->with('save', 'Дисциплина успешно добавлена/изменена');
        }
        else
            return redirect('subjects/'.$idProf)->with('error', 'Ошибка записи');

    }

    public function delete($idProf, $idSub){
        Professors::deleteLoadForProf($idProf,$idSub);
        return redirect()->back();
    }

    public function updateForm($idProf, $idSub){
        return view('addform',
            array('title' => 'AddForm','description' => '',
                'page' => 'addform', 'idProf' => $idProf, 'idSub' => $idSub,
                'arrLoad' => Professors::getWorksForProfSubject($idProf,$idSub)));
    }

    public function updateLoadProf($idProf, AddLoadFormRequest $request){
        $model = new AddForm();
        $model->idProf = $idProf;
        $model->hours = $request->get('hours');
        $model->fkLoad = $request->get('idProfLoad');


        if ($model->updateLoad()){

            return redirect('profile/'.$idProf)->with('save', 'Дисциплина успешно изменена');
        }
        else
            return redirect('profile/'.$idProf)->with('error', 'Ошибка записи');

    }





}
