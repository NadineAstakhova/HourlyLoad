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


    public static $SPRING_TERM = [2, 4, 6, 8];
    public static $AUTUMN_TERM = [1, 3, 5, 7];

    public static function getFreeSubjects(){

    }


}
