<?php

//namespace ActiveRecords;

class Manage {
    public static function autoload($class) {
        //you can put any file name or directory here
         include $class . '.php';
        //require $class .'.php';
    }
}
spl_autoload_register(array('Manage', 'autoload'));

$obj=new main();

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







