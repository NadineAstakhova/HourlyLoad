<?php

namespace HoursLoad;

use Illuminate\Database\Eloquent\Model;
use DB;

class Professors extends BaseModel 
{
    protected $primaryKey = 'idProfessors';
    protected $table = 'Professors';
    protected $fillable = array('firstName', 'patronomical','lastName');

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

    public function findById($id){
        return $this->find($id);

    }


}
