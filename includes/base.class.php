<?php

require_once('config.php');
require_once('debugger.class.php');

class Base {
    var $m_debugObj;
    var $m_lastError;

    public function __construct() {
        $this->m_debugObj = DebuggerInstance::GetInstance();
        $this->m_lastError = null;
    }

    protected function writeLog($logString, $line) {
        $reflector = new ReflectionClass(get_class($this));
        if (is_array($logString)) {
            $outputString = "[".$reflector->getName()."] Dump array start |" . $this->getBaseFileName($reflector) . ":".$line;
            $this->m_debugObj->writeLog($outputString);
            $this->dump_array($reflector, $logString, $line, "");
            $outputString = "[".$reflector->getName()."] Dump array end |" . $this->getBaseFileName($reflector) .":".$line;
            $this->m_debugObj->writeLog($outputString);
        } else {
            $outputString = "[".$reflector->getName()."]". $logString . " | " . $this->getBaseFileName($reflector) .":".$line;
            $this->m_debugObj->writeLog($outputString);
        }
    }
    
    private function getBaseFileName($reflector) {
        return basename($reflector->getFileName());
    }

    private function dump_array($reflector, $arrayObj, $line, $tab) {
        foreach ($arrayObj as $key => $value) {
            if (is_array($value)) {
                $tab .= " ";
                $this->dump_array($reflector, $value, $line, $tab);
            } else {
                $outputString = "[".$reflector->getName()."]". $tab . "['$key'] = $value " . " | " . $this->getBaseFileName($reflector) .":".$line;
                $this->m_debugObj->writeLog($outputString);
            }
        } 
    }
};

?>
