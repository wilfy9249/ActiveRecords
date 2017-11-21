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
        printHtmlTags::headingOne('Active Record Assignment');
        printHtmlTags::horizontalRule();

        // SELECT ONE RECORD
        printHtmlTags::headingOne('Select One Record');
        $selectOneRecord = todos::findOne(1);
        htmlTable::displayOneRecord($selectOneRecord);
        printHtmlTags::horizontalRule();

        //SELECT ALL RECORDS
        printHtmlTags::headingOne('Select All Records');
        $selectRecords = todos::findAll();
        htmlTable::displayAllRecords($selectRecords);
        printHtmlTags::horizontalRule();

        //INSERT ONE RECORD
        printHtmlTags::headingOne('Insert One Record');
        $record = new todo();
        $record->owneremail="testnjit.edu";
        $record->ownerid= "4";
        $record->createddate="2017-05-01 00:00:00";
        $record->duedate="2017-06-01 00:00:00";
        $record->message="test data";
        $record->isdone= "1";
        $insertID = $record->save();
        $records = todos::findAll();
        htmlTable::displayAllRecords($records);
        printHtmlTags::horizontalRule();

        //UPDATE A RECORD
        printHtmlTags::headingOne('Update a Record With Id :'.$insertID);
        $updateRecord = new todo();
        $updateRecord->id= $insertID;
        $updateRecord->message="update data";
        $updateRecord->isdone= "1";
        $updateRecord -> save();
        $updatedRecords = todos::findAll();
        htmlTable::displayAllRecords($updatedRecords);
        printHtmlTags::horizontalRule();

        //DELETE A RECORD
        printHtmlTags::headingOne('Delete a Record With Id :'.$insertID);
        $deleteRecord = new todo();
        $deleteRecord-> id = $insertID;
        $deleteRecord-> delete();
        $deletedRecords = todos::findAll();
        htmlTable::displayAllRecords($deletedRecords);
        printHtmlTags::horizontalRule();
    }
}







