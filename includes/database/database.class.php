<?php
require_once('includes/config.php');
require_once('includes/factory.class.php');
require_once('includes/database/database_base.class.php');
require_once('includes/database/database_mysql.class.php');

class DatabaseFactory extends FactoryBase {
    public function createObject($objectType) {
        $object = null;
        switch ($objectType) {
            case "MYSQL": 
                $object = new DB_MySQL(G_DB_HOST, G_DB_USER, G_DB_PASSWD, G_DB_NAME);
                break;
            case "MSSQL":
                break;
            default:
                break;
        }
    
        return $object;
    }
};

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
