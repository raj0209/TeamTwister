<?php require_once("includes/function.php"); ?>
<?php
	session_start();
	
	$_SESSION = array();
	
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-4200, '/');
	}
	
	session_destroy();

	
	redirectTo("index.php?logout=1");
?>