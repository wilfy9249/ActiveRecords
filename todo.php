<?php

class todo extends model {
    public $id;
    public $owneremail;
    public $ownerid;
    public $createddate;
    public $duedate;
    public $message;
    public $isdone;

    public function getTablename(){
        $tableName='todos';
        return $tableName;
    }
}

?>