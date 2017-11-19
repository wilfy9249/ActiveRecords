<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('DATABASE', 'wc335');
define('USERNAME', 'wc335');
define('PASSWORD', 'ZxBEThIc');
define('CONNECTION', 'sql1.njit.edu');

class dbConn{
    //variable to hold connection object.
    protected static $db;
    //private construct - class cannot be instatiated externally.
    private function __construct() {
        try {
            // assign PDO object to db variable
            self::$db = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch (PDOException $e) {
            //Output error - would normally log this to error file rather than output to user.
            echo "Connection Error: " . $e->getMessage();
        }
    }
    // get connection function. Static method - accessible without instantiation
    public static function getConnection() {
        //Guarantees single instance, if no connection object exists then create one.
        if (!self::$db) {
            //new connection object.
            new dbConn();
        }
        //return connection.
        return self::$db;
    }
}
class collection {
    static public function create() {
        $model = new static::$modelName;
        return $model;
    }

    static public function findAll() {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet;
    }
    static public function findOne($id) {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet[0];
    }
}
class accounts extends collection {
    protected static $modelName = 'account';
}

class todos extends collection {
    protected static $modelName = 'todo';
}

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
        print_r($array); echo '</br>';
        $columnString = implode(',', array_flip($array));
        print_r($columnString);echo '</br>';
        $valueString = ':'.implode(',:', array_flip($array));
        print_r($valueString);echo '</br>';
        $sql =  'INSERT INTO '.$tableName.' ('.$columnString.') VALUES ('.$valueString.')';
        ECHO $sql;echo '</br>';
        return $sql;
    }
     private function update() {
        //$sql = 'sometthing';
        //return $sql;

        //$db = dbConn::getConnection();
        //$tableName = get_called_class();
        //$array = get_object_vars($this);
        //$columnString = implode(',', $array);
        //$valueString = ":".implode(',:', $array);

        //echo "INSERT INTO $tableName (" . $columnString . ") VALUES (" . $valueString . ")</br>";

        echo "UPDATE". '</br>';

    }

     public function delete() {

         echo $this -> id;

         $db = dbConn::getConnection();
         $tableName = get_called_class();
         $sql = 'DELETE FROM ' . $tableName .'s'. ' WHERE id ='. $this -> id;
         echo $sql;
         $statement = $db->prepare($sql);
         $statement->execute();
    }
}
class account extends model {
}
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
// this would be the method to put in the index page for accounts
$records = accounts::findAll();
//print_r($records);

// this would be the method to put in the index page for todos
//$records = todos::findAll();
//print_r($records);

//this code is used to get one record and is used for showing one record or updating one record
//$record = todos::findOne(1);
//print_r($record);

//$record = new todo();
//$record -> id = 5;
//$record -> delete();
//$records = todos::delete(5 );
//print_r($record);

//this is used to save the record or update it (if you know how to make update work and insert)
// $record->save();
//$record = accounts::findOne(1);

//This is how you would save a new todo item
//$record = new todo();
//$record -> id = '';
//$record -> ownerid = 4;
//$record-> message = 'some task';
//$record-> isdone = 1;
//$record-> save();
//print_r($record);
//$record = todos::create();
//print_r($record);


echo "<h2>Insert One Record</h2>";
$record = new todo();
$record->owneremail="testnjit.edu";
$record->ownerid= "4";
$record->createddate="2017-05-01 00:00:00";
$record->duedate="2017-06-01 00:00:00";
$record->message="test data";
$record->isdone= "1";
$insertID = $record->save();
ECHO $insertID;

$records = todos::findAll();