<?php

namespace HoursLoad;

use Illuminate\Database\Eloquent\Model;
use DB;

class Professors extends BaseModel 
{
    protected $primaryKey = 'idProfessors';
    protected $table = 'Professors';
    protected $fillable = array('firstName', 'patronomical','lastName');

    public static $sumHoursAutumn;
    public  static $sumHoursSpring;

    public $idInsertLoad;
    public $hours;
    public $fkLoad;

    private $idProf;

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }

    public static function getProfessors(){
        $professors = DB::table('Professors')
            ->join('Positions', 'Professors.fkPosition','=','Positions.idPositions')
            ->select('Professors.*', 'Positions.name as position')
          //  ->groupBy('Professors.idProfessors')
            ->get();
        return $professors;
    }

    public static function findById($id){
        $professor = DB::table('Professors')
            ->join('Positions', 'Professors.fkPosition','=','Positions.idPositions')
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
            ->where('idProfessors', '=', $id)
            ->groupBy('Subjects.idSubjects')
            ->orderBy('Subjects.course', 'ASC')
            ->orderBy('Subjects.name', 'ASC')
            ->get();
        return $load;
    }

    public static function getLoadPr($id){
        $load = DB::table('ProfLoad')
            ->join('Professors', 'ProfLoad.fkProf', '=', 'Professors.idProfessors')
            ->join('LoadSub', 'ProfLoad.fkLoaf', '=', 'LoadSub.idLoadSub')
            ->join('Subjects', 'LoadSub.fkSubject', '=', 'Subjects.idSubjects')
            ->where('idProfessors', '=', $id)
            ->get();
        return $load;
    }

    public static function getWorksForProfSubject($idProf, $idSubject){
        $load = DB::table('LoadSub')
            ->join('TypeOfWork', 'LoadSub.fkType', '=', 'TypeOfWork.idTypeOfWork')
            ->join('ProfLoad', 'LoadSub.idLoadSub', '=', 'ProfLoad.fkLoaf')
            ->where([['fkSubject', '=', $idSubject], ['fkProf', '=', $idProf]])
            ->get();
        return $load;
    }

    public static function setHourAutumn($subjects){
        self::$sumHoursAutumn = 0;
        foreach ($subjects as $sub){
            if (in_array($sub->term,\HoursLoad\Subject::$AUTUMN_TERM))
                self::$sumHoursAutumn += $sub->time;
        }
        return self::$sumHoursAutumn;
    }

    public static function setHourSpring($subjects){
        self::$sumHoursSpring = 0;
        foreach ($subjects as $sub){
            if (in_array($sub->term,\HoursLoad\Subject::$SPRING_TERM))
                self::$sumHoursSpring += $sub->time;
        }
        return self::$sumHoursSpring;
    }

    public static function getAllSumHours($id = null){
        if(is_null($id))
           return self::$sumHoursSpring + self::$sumHoursAutumn;
        else{
            $subjects = self::getLoadPr($id);
            $sum = 0;
            foreach ($subjects as $sub){
                $sum += $sub->time;
            }
            return $sum;
        }
    }

    public function existLoadRow($fkLoad, $fkProf){
        $row = DB::table('ProfLoad')
            ->where([['fkLoaf', '=', $fkLoad],   ['fkProf', '=', $fkProf]])
            ->first();
        if ($row === null)
           return null;

        else
            return $row;

    }

    public function addLoadForProf(){
        $insert = 0;
        for ($i = 0; $i < count($this->hours); $i++)
            if(is_null($this->hours[$i]) || $this->hours[$i] == 0)
                continue;
            else {
                $exist = $this->existLoadRow( $this->fkLoad[$i], $this->idInsertLoad);
                if(is_null($exist)){
                    $insert = DB::table('ProfLoad')->insert([
                        ['time' => $this->hours[$i], 'fkLoaf' => $this->fkLoad[$i], 'fkProf' => $this->idInsertLoad]
                    ]);
                }
                else {
                    $hours = $exist->time;
                    $insert = DB::table('ProfLoad')
                        ->where('idProfLoad',$exist->idProfLoad)
                        ->update(['time' => $hours + $this->hours[$i]]);
                }
            }
        if ($insert)
            return true;
        else
            return false;
    }

    public static function deleteLoadForProf($idProf, $idSub){
        $loadsSub = Subject::getWorksForSubject($idSub);
        foreach ($loadsSub as $load)
            DB::table('ProfLoad')->where([['fkLoaf','=',$load->idLoadSub],['fkProf', '=', $idProf]])->delete();
        return true;
    }

    public function updateLoadForProf($fkProfLoads){
        $update = 0;
        for ($i = 0; $i < count($this->hours); $i++) {
            if (is_null($this->hours[$i]))
                continue;
            if($this->hours[$i] == 0)
            {
                $update = DB::table('ProfLoad')->where('idProfLoad','=',$fkProfLoads[$i])->delete();
            }
            else {
                $update = DB::table('ProfLoad')
                    ->where('idProfLoad', $fkProfLoads[$i])
                    ->update(['time' => $this->hours[$i]]);
            }
        }
            return true;

    }

    public static function getLoadWage(){
        $row = DB::table('Global_info')
            ->first();
        if ($row === null)
            return 1;

        else
            return $row->loadWageRate;
    }

    public static function getProfByFKUser($idUser){
        $professor = DB::table('Professors')
            ->join('Positions', 'Professors.fkPosition','=','Positions.idPositions')
            ->select('Professors.*', 'Positions.name as position')
            ->where('fkUser', '=', $idUser)
            ->first();
        $professor->subjects= self::getLoadProf($professor->idProfessors);
        return $professor;
    }

    public static function getIdProfByFKUser($idUser){
        $professor = DB::table('Professors')
            ->select('Professors.idProfessors')
            ->where('fkUser', '=', $idUser)
            ->first();
        return $professor->idProfessors;
    }


}
