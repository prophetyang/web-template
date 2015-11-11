<?php
require_once('includes/config.php');
require_once('includes/database/database_factory.class.php');

final class DatabaseInstance {
    public static function GetInstance() {
        static $instance = null;

        if (is_null($instance)) {
            $factory = new DatabaseFactory();
            $instance = $factory->createObject(G_DB_TYPE);
            if (is_null($instance)) {
                die("Can not create database object\n");
            }
        }
    
        return $instance;
    }
    
    private function __construct() {}
};

/*
$dbObj = DatabaseInstance::GetInstance(); 
$success = $dbObj->Connect();
$success = $dbObj->Query("SELECT * from user");
$rowdata = $dbObj->FetchData();
$dbObj->Disconnect();
*/

?>
