<?php 
	session_start();	
	function chkLogin(){
		return isset($_SESSION['admin']);
	}
?>