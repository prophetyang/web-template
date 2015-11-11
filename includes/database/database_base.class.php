<?php
require_once('includes/base.class.php');
require_once('includes/factory.class.php');

assert_options(ASSERT_ACTIVE, 1);

define('DB_ERROR_CONNECT_DATABASE', "Can not connect to database");
define('DB_ERROR_SELECT_DATABASE', "Can not use database");
define('DB_ERROR_QUERY', "SQL query failed");
define('DB_ERROR_FETCH_DATA', "Fetch data failed, no query result exist");
define('DB_ERROR_DISCONNECT', "Disconnect database failed");

abstract class DatabaseBase extends Base {
    var $m_host;
    var $m_user;
    var $m_database;
    var $m_passwd;
    var $m_handler;
    var $m_result;
    
    /* Extend classes MUST implement the following functions */
    abstract protected function Connect();    
    abstract protected function Disconnect();    
    abstract protected function Query($sqlcmd);    
    abstract protected function FetchData();    
};

?>
