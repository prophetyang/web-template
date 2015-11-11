<?php
require_once('includes/config.php');
require_once('includes/factory.class.php');
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

?>
