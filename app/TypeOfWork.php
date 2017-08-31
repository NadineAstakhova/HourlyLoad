<?php

namespace HoursLoad;

use Illuminate\Database\Eloquent\Model;
use DB;

class TypeOfWork extends BaseModel
{
    protected $primaryKey = 'idTypeOfWork';
    protected $table = 'TypeOfWork';
    protected $fillable = array('idTypeOfWork', 'type');

    public static function getTimeForType($idSubject, $idType){
        $subject = DB::table('LoadSub')
            ->where([['fkSubject', '=', $idSubject],['fkType', '=', $idType]])
            ->get();
        return $subject;
    }

    public static function getTimeForProfType($idProf, $idType, $idSubject){
        $subject = DB::table('ProfLoad')
            ->join('LoadSub', 'ProfLoad.fkLoaf', '=', 'LoadSub.idLoadSub')
            ->where([['ProfLoad.fkProf', '=', $idProf],['LoadSub.fkType', '=', $idType], ['LoadSub.fkSubject', '=', $idSubject]])
            ->get();
        return $subject;
    }


}
