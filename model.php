<?php

class model {
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
        //print_r($array); echo '</br>';

        $columnString = implode(',', array_flip($array));
        print_r($columnString);echo '</br>';
        $valueString = ':'.implode(',:', array_flip($array));
        //print_r($valueString);echo '</br>';
        $sql =  'INSERT INTO '.$tableName.' ('.$columnString.') VALUES ('.$valueString.')';
        ECHO $sql;echo '</br>';
        return $sql;
    }
    private function update() {

        $tableName = $this->getTablename();
        $array = get_object_vars($this);
        $comma = " ";
        $sql = 'UPDATE '.$tableName.' SET ';
        foreach ($array as $key=>$value){
            if( $value != null) {
                $sql .= $comma . $key . ' = "'. $value .'"';
                $comma = ", ";
            }
        }
        $sql .= ' WHERE id='.$this->id;
        echo $sql;
        return $sql;
    }

    public function delete() {

        echo $this -> id;

        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'DELETE FROM ' . $tableName .'s'. ' WHERE id ='. $this->id;
        echo $sql;
        $statement = $db->prepare($sql);
        $statement->execute();
    }
}
?>