<?php

namespace HoursLoad;

use Illuminate\Database\Eloquent\Model;

class Subject extends BaseModel
{
    //
    /*public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }*/

    protected $primaryKey = 'idSubjects';
    protected $table = 'Subjects';
    protected $fillable = array('name', 'course','term');

    public static function getFreeSubjects(){

    }
}
