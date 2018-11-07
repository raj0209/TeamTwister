<?php
	session_start();
	require_once("functions.php");
	
	$_SESSION = array();
	
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-4200, '/');
	}
	
	session_destroy();

	
	redirectTo("index.php?logout=1");
?>