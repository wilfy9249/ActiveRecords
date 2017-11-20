<?php

class Manage {
    public static function autoload($class) {
        //you can put any file name or directory here
        include $class . '.php';
    }
}
spl_autoload_register(array('Manage', 'autoload'));

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('DATABASE', 'wc335');
define('USERNAME', 'wc335');
define('PASSWORD', 'ZxBEThIc');
define('CONNECTION', 'sql1.njit.edu');

$obj=new main();

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

class main
{
    public function __construct()
    {
        // this would be the method to put in the index page for accounts
       // $records = accounts::findAll();
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


        echo "<h2>Insert Records</h2>";
        $record = new todo();
        $record->owneremail="testnjit.edu";
        $record->ownerid= "4";
        $record->createddate="2017-05-01 00:00:00";
        $record->duedate="2017-06-01 00:00:00";
        $record->message="test data";
        $record->isdone= "1";
        $insertID = $record->save();
        $records = todos::findAll();
//ECHO $insertID;

        echo "<table  border=\"1\">";
        foreach($records as $key=>$row) {
            echo "<tr>";
            foreach($row as $key2=>$row2){
                echo "<td>" . $row2 . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        echo "<h2>Update Records</h2>";
        $record = new todo();
        $record->id=2;
        $record->message="update data";
        $record->isdone= "1";
        $updateID = $record -> save();
    }
}







