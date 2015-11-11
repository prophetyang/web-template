<?php
require_once('includes/database/database_base.class.php');

class DB_MySQL extends DatabaseBase {
    var $m_host;
    var $m_user;
    var $m_database;
    var $m_passwd;
    var $m_handler;
    var $m_result;
    
    public function __construct($host, $user, $passwd, $database) {
        parent::__construct();
        $this->m_host = $host;
        $this->m_user = $user;
        $this->m_passwd = $passwd;
        $this->m_database = $database;
        $this->m_handler = "";
    }

    public function __destruct() {
        if (isset($this->m_handler)) {
            mysql_close($this->m_handler);
        }
    }
    
    public function Connect() {
        $this->m_handler = mysql_connect($this->m_host, $this->m_user, $this->m_passwd);
        if (false == $this->m_handler) {
            $this->m_lastError = DB_ERROR_CONNECT_DATABASE . "(" . $this->m_host .", ". $this->m_user .")";
            $this->writeLog($this->m_lastError, __LINE__);
            return false;
        }
        
        $this->result = mysql_select_db($this->m_database, $this->m_handler);
        if (false == $this->result) {
            $this->m_lastError = DB_ERROR_SELECT_DATABASE . " \"" . $this->m_database . "\".";
            $this->writeLog($this->m_lastError, __LINE__);
        }
    
        $this->writeLog("Connect to database successfully.", __LINE__);
        return $this->result;
    }

    public function GetLastError() {
        return $this->m_lastError;
    }

    public function ClearLastError() {
        unset($this->m_lastError);
    }

    public function Disconnect() {
        if (isset($this->m_handler)) {
            $this->result = mysql_close($this->m_handler);
            if (false == $this->result) {
                $this->m_lastError = DB_ERROR_DISCONNECT;
                $this->writeLog($this->m_lastError, __LINE__);
                return false;
            }
            unset($this->m_handler);
            $this->writeLog("Disconnect from database successfully.", __LINE__);
        }

        return true;
    }

    public function Query($sqlcmd) {
        $retcode = true;

        $this->writeLog("Receive SQL command \"$sqlcmd\"", __LINE__);
        $this->result = mysql_query($sqlcmd);
        if (false == $this->result) {
            $this->m_lastError = DB_ERROR_QUERY . " \"$sqlcmd\"";
            $this->writeLog($this->m_lastError, __LINE__);
            $retcode = false;
        }

        $this->writeLog("SQL query successfully.", __LINE__);
        return $retcode;
    }
    
    public function FetchData() {
        $rowdata = array();

        if ($this->result) {
            while ($row = mysql_fetch_array($this->result)) {
                $rowdata[] = $row;
            }
            $this->writeLog($rowdata, __LINE__);
            $this->writeLog("Fetch data successfully.", __LINE__);
        } else {
            $this->m_lastError = DB_ERROR_FETCH_DATA;
            $this->writeLog($this->m_lastError, __LINE__);
        }

        return $rowdata;
    }
};

?>
