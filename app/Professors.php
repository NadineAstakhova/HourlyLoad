<?php

namespace HoursLoad;

use Illuminate\Database\Eloquent\Model;
use DB;

class Professors extends BaseModel 
{
    protected $primaryKey = 'idProfessors';
    protected $table = 'Professors';
    protected $fillable = array('firstName', 'patronomical','lastName');

    public $sumHoursAutumn;
    public $sumHoursSpring;

    private $idProf;

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }

    public static function getProfessors(){
        $professors = DB::table('Professors')
            ->crossJoin('Positions')
            ->select('Professors.*', 'Positions.name as position')
            ->get();
        return $professors;
    }

    public static function findById($id){
        $professor = DB::table('Professors')
            ->crossJoin('Positions')
            ->select('Professors.*', 'Positions.name as position')
            ->where('idProfessors', '=', $id)
            ->first();
        $professor->subjects= self::getLoadProf($id);
        return $professor;
    }

    public static function getLoadProf($id){
        $load = DB::table('ProfLoad')
            ->join('Professors', 'ProfLoad.fkProf', '=', 'Professors.idProfessors')
            ->join('LoadSub', 'ProfLoad.fkLoaf', '=', 'LoadSub.idLoadSub')
            ->join('Subjects', 'LoadSub.fkSubject', '=', 'Subjects.idSubjects')
            ->join('TypeOfWork', 'LoadSub.fkType', '=', 'TypeOfWork.idTypeOfWork')
            ->where('idProfessors', '=', $id)
            ->get();
        return $load;
    }

    public function setHourAutumn($subjects){
        $this->sumHoursAutumn = 0;
        foreach ($subjects as $sub){
            if (in_array($sub->term,\HoursLoad\Subject::$AUTUMN_TERM))
                $this->sumHoursAutumn += $sub->time;
        }
        return $this->sumHoursAutumn;
    }

    public function setHourSpring($subjects){
        $this->sumHoursSpring = 0;
        foreach ($subjects as $sub){
            if (in_array($sub->term,\HoursLoad\Subject::$SPRING_TERM))
                $this->sumHoursSpring += $sub->time;
        }
        return $this->sumHoursSpring;
    }

    public function getAllSumHours(){
        return $this->sumHoursSpring + $this->sumHoursAutumn;
    }


}
