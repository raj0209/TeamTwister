<?php
	// This file is the place to store all basic functions
	function chkExistUsername($name){
		$chk=mysql_query("SELECT * FROM teamtwisterusers WHERE username='{$name}' LIMIT 1");
		confirmQuery($chk);
		if(mysql_num_rows($chk))
			//name exists
			return 1;
		else
			return 0;
	}
	function chkExistEmail($email){
		$chk=mysql_query("SELECT * FROM teamtwisterusers WHERE email='{$email}' LIMIT 1");
		confirmQuery($chk);
		if(mysql_num_rows($chk))
			//email exists
			return 1;
		else
			return 0;
	}
	function getStatus(){
		$set= mysql_query("SELECT * FROM teamtwisterstatus");
		confirmQuery($set);
		$array=mysql_fetch_array($set);
		return $array[0];
	}
	function setStatus($val){
		$set=mysql_query("UPDATE teamtwisterstatus SET enable={$val}");
		confirmQuery($set);
	}
	function chkPlayerId($id){
		$query="SELECT playername FROM teamtwisterplayers WHERE playerid='{$id}'";
		$chk=mysql_query($query);
		confirmQuery($chk);
		$num=mysql_num_rows($chk);
		if($num){
			return true;			
		}
		else{				
			return false;	
		}
	}
	function getPlayerScore($id, $captain=0){
		$query="SELECT * FROM teamtwisterplayers WHERE playerid='{$id}' LIMIT 1";
		$chk=mysql_query($query);
		confirmQuery($chk);
		$array=mysql_fetch_array($chk);
		if($array){
			$ans=$array[5];
			if($captain)
				return (2*$ans);
			else
				return $ans;
		}
		else {
			return 0;
		}
	}

	function insertScoreUser($username, $score){
		$username=trim(mysqlPrep($username));
		$query="SELECT totalScore FROM teamtwisterscores WHERE username='{$username}'";
		$chk=mysql_query($query);
		confirmQuery($chk);
		$array=mysql_fetch_array($chk);
		$oldScore=$array['totalScore'];
		$newScore=$oldScore+$score;
		$update="UPDATE teamtwisterscores SET prevScore={$oldScore}, totalScore={$newScore} WHERE username='{$username}'";
		$set=mysql_query($update);
		confirmQuery($set);
		if(mysql_affected_rows())
			return true;
		else
			return false;
	}
	
	function checkPlayerIdName($id, $name){
		$query="SELECT * FROM teamtwisterplayers WHERE playerid='{$id}' OR playername='{$name}'";
		$chk=mysql_query($query);
		confirmQuery($chk);
		$num=mysql_num_rows($chk);
		if($num)
			return true;
		else
			return false;
	}

	function mysqlPrep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function redirectTo( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

	function confirmQuery($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}
	
	function connectionClose($connection){
		if(isset($connection)){
			mysql_close($connection);
			unset($connection);
		}
	}
?>