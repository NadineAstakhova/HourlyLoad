<?php

namespace HoursLoad;

use Illuminate\Database\Eloquent\Model;

class AddForm extends Model
{
    public $hours;
    public $idProf;

    public function addLoad(){
        $prof = new Professors();
        $prof->idInsertLoad = $this->idProf;
        $prof->hours = $this->hours;

        return $prof->addLoadForProf();
    }

}
