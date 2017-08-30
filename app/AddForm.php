<?php

namespace HoursLoad;

use Illuminate\Database\Eloquent\Model;

class AddForm extends Model
{
    public $hours;
    public $idProf;
    public $fkLoad;

    public function addLoad(){
        $prof = new Professors();
        $prof->idInsertLoad = $this->idProf;
        $prof->hours = $this->hours;
        $prof->fkLoad = $this->fkLoad;
        return $prof->addLoadForProf();
    }

    public function updateLoad(){
        $prof = new Professors();
        $prof->idInsertLoad = $this->idProf;
        $prof->hours = $this->hours;
        return $prof->updateLoadForProf($this->fkLoad);
    }

}
