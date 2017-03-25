<?php
session_start();

if(!(isset($_SESSION["UserLog"]))){
	
	header('Location: index.php?uss='.$_GET["ulog"]);	
}
else
{
	$objUser=$_SESSION["UserLog"];
}

?>