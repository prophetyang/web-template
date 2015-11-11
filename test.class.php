<?php
require_once('includes/include.php');

$dbObj = DatabaseInstance::GetInstance();
$success = $dbObj->Connect();
$success = $dbObj->Query("SELECT * from user");
$rowdata = $dbObj->FetchData();
$dbObj->Disconnect();
?>
