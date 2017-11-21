<?php

abstract class model {
    protected $tableName;
    public function save()
    {

        if ($this->id == ''){
            $sql = $this->insert();
        } else {
            $sql = $this->update();
        }

        $db = dbConn::getConnection();
        $statement = $db->prepare($sql);


        $array = get_object_vars($this);
        foreach (array_flip($array) as $key=>$value){
            $statement->bindParam(":$value", $this->$value);
        }
        $statement->execute();
        $id = $db->lastInsertId();
        return $id;
    }

    private function insert() {

        $tableName = $this->getTablename();
        $array = get_object_vars($this);
        $columnString = implode(',', array_flip($array));
        $valueString = ':'.implode(',:', array_flip($array));
        $sql =  'INSERT INTO '.$tableName.' ('.$columnString.') VALUES ('.$valueString.')';
        return $sql;
    }
    private function update() {

        $tableName = $this->getTablename();
        $array = get_object_vars($this);
        $space = " ";
        $sql = 'UPDATE '.$tableName.' SET ';
        foreach ($array as $key=>$value){
            if( $value != null) {
                $sql .= $space . $key . ' = "'. $value .'"';
                $space = ", ";
            }
        }
        $sql .= ' WHERE id='.$this->id;
        return $sql;
    }

    public function delete() {

        $db = dbConn::getConnection();
        $tableName = $this->getTablename();
        $sql = 'DELETE FROM ' . $tableName . ' WHERE id ='. $this->id;
        $statement = $db->prepare($sql);
        $statement->execute();
    }
}
?>