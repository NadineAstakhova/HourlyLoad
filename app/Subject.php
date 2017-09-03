<?php

namespace HoursLoad;

use Illuminate\Database\Eloquent\Model;
use DB;

class Subject extends BaseModel
{
    //
    /*public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }*/

    protected $primaryKey = 'idSubjects';
    protected $table = 'Subjects';
    protected $fillable = array('name', 'course','term');


    public static $SPRING_TERM = [2, 4, 6, 8];
    public static $AUTUMN_TERM = [1, 3, 5, 7];

    public static function getSubjects($idSubject){
        $subjects = DB::table('Subjects')
            ->join('LoadSub', 'Subjects.idSubjects', '=', 'LoadSub.fkSubject')
            ->join('TypeOfWork', 'LoadSub.fkType', '=', 'TypeOfWork.idTypeOfWork')
            ->where('idSubjects', '=', $idSubject)
            ->groupBy('Subjects.idSubjects')
            ->get();
        return $subjects;

    }

    public static function getWorksForSubject($idSubject){
        $load = DB::table('LoadSub')
            ->join('TypeOfWork', 'LoadSub.fkType', '=', 'TypeOfWork.idTypeOfWork')
          //  ->join('ProfLoad', 'LoadSub.idLoadSub', '=', 'ProfLoad.fkLoaf')
            ->where('fkSubject', '=', $idSubject)
            ->get();
        return $load;
    }

    public static function getSumOfLoadSub($fkLoad){
        $sum = DB::table('ProfLoad')
            ->where('fkLoaf', $fkLoad)
            ->sum('time');
        return $sum;
    }

    public static function getSumOfLoadPSub($fkLoad, $fkProf){
        $sum = DB::table('ProfLoad')
            ->where([['fkLoaf', $fkLoad], ['fkProf', '!=', $fkProf]])
            ->sum('time');
        return $sum;
    }

    public static function getFreeHours($fkLoad, $allTime, $fkProf = null){
        $loadHours = 0;
        if(isset($fkProf))
            $loadHours = self::getSumOfLoadPSub($fkLoad, $fkProf);
        else
            $loadHours = self::getSumOfLoadSub($fkLoad);
        return $allTime - $loadHours;
    }

    public static function getAllTime($idSubject){
        $sum = DB::table('LoadSub')
            ->where('fkSubject', '=', $idSubject)
            ->sum('hours');
        return $sum;
    }

    public static function getAllLoadsTime($idSubject){
        $sum = DB::table('LoadSub')
            ->join('ProfLoad', 'LoadSub.idLoadSub', '=', 'ProfLoad.fkLoaf')
            ->where('fkSubject', '=', $idSubject)
            ->sum('time');
        return $sum;
    }

    public static function getSubjectName($idSubject){
        $subject = DB::table('Subjects')
            ->where('idSubjects', '=', $idSubject)
            ->first();
        return $subject->name;
    }




}
