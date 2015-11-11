<?php

require_once('config.php');

class Debugger {
    var $m_enable;    
    var $m_dbg_file;
    var $m_output_stdout;
    var $m_output_file;
    var $m_dbg_file_handler;
    var $m_init_truncate_file;

    public function __construct() {
        $dbg_dir = G_DBG_DIRNAME;
        $dbg_file = G_DBG_FILENAME;

        if (! file_exists($dbg_dir)) {
            if (false == mkdir($dbg_dir)) {
                die("Can not create directory \"$dbg_dir\"");
            }
        }
        
        $this->m_enable = G_DBG_ENABLE; 
        $this->m_output_stdout = G_DBG_OUTPUT_STDOUT;
        $this->m_output_file = G_DBG_OUTPUT_FILE;
        $this->m_init_truncate_file = G_DBG_INIT_TRUNCATE_FILE;
        $this->m_dbg_file = $dbg_dir . "/" . $dbg_file;

        $this->m_dbg_file_handler = fopen($this->m_dbg_file, "a+");
        if (is_null($this->m_dbg_file_handler)) die("Can not open file " . $this->m_dbg_file . " for writting.\n");

        if (true == $this->m_init_truncate_file) {
            ftruncate($this->m_dbg_file_handler, 0);
            $this->writeLog("Log file ".$this->m_dbg_file." had been truncated.");
        }
    }

    public function __destruct() {
        if (isset($this->m_dbg_file_handler)) {
            fclose($this->m_dbg_file_handler);
            unset($this->m_dbg_file_handler);
        }
    }

    public function enableOutputStdout() {
        $this->$m_output_stdout = true;
    }

    public function enableOutputFile() {
        $this->$m_output_file = true;
    }

    public function disableOutputStdout() {
        $this->$m_output_stdout = false;
    }

    public function disableOutputFile() {
        $this->$m_output_file = false;
    }

    public function writeLog($logString) {
        $outputString = $this->getTime() . " " . "$logString\n"; 
    
        if ($this->m_output_stdout) {
            $this->writeStdoutLog($outputString);
        }
    
        if ($this->m_output_file) {
            $this->writeFileLog($outputString);
        }
    }

    private function writeStdoutLog($logString) {
        echo $logString;
    }

    private function writeFileLog($logString) {
        if (isset($this->m_dbg_file_handler)) {
            fwrite($this->m_dbg_file_handler, $logString);
        }
    }

    private function getTime() {
        return "[" . date('Y-m-d H:i:s') . "]";
    }
};

final class DebuggerInstance {
    public static function GetInstance() {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new Debugger();
            if (is_null($instance)) die ("Can not create debugger instance\n");
        }
        
        return $instance;
    }

    private function __construct() {}
};

//$debuggerObj = DebuggerInstance::GetInstance();
//$debuggerObj->writeLog("Log test");

?>
