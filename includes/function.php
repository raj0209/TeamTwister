<?php
	function chkEmail($email){
		$set=mysql_query("SELECT * FROM teamtwisterusers WHERE email='{$email}'");
		confirmQuery($set);
		if(mysql_num_rows($set)){
			//already email exists
			return false;
		}
		else{
			return true;
		}
	}
	function getStatus(){
		$set=mysql_query("SELECT * FROM teamtwisterstatus");
		confirmQuery($set);
		$array=mysql_fetch_array($set);
		return $array[0];
	}
	
	function chkPlayerId($id){
			
		$query="SELECT playername FROM teamtwisterplayers WHERE playerId='{$id}'";
			
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
	function getScoreName($name){
		$chk=mysql_query("SELECT totalScore FROM teamtwisterscores WHERE username='{$name}' LIMIT 1");
		confirmQuery($chk);
		$score=mysql_fetch_array($chk);
		if(mysql_num_rows($chk))
			return $score[0];
		else
			return 0; //there is some error
	}
	function GenPwd($length = 7)
	{
		$password = "";
		$possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels
  
		$i = 0; 
    
		while ($i < $length) { 

    
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
       
    
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}

		}

		return $password;

	}
	function checkUsrPwd($message){
		if(isset($_POST['submit'])){
		$username = trim(mysqlPrep($_POST['username']));
		$password = trim(mysqlPrep($_POST['password']));
		$hash_password = md5($password); 
		
		$query = "SELECT username FROM teamtwisterusers WHERE username = '{$username}' AND hash_password = '{$hash_password}' LIMIT 1";
		
		$chk = mysql_query($query);
		confirmQuery($chk);
		$ary = mysql_fetch_array($chk);
		$num = mysql_num_rows($chk);
			if($num == 1){
				$_SESSION['username']=$ary['username'];//this helps to check whether the user has successfully logged in
				$message="";
				return $message;
			}
			else{
				$message = "Username or Password Incorrect. Please try again";
				return $message;
			}
		}
		else{
			$message="";
			return $message;
		}
	}

	function redirectTo($location){
		header("Location: {$location}");
		exit;
	}

	function confirmQuery($result_set){
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}

	
	function printUsername(){
		echo "<h2 class=\"title\">Welcome, " . htmlentities($_SESSION['username']) . "</h2>";
	}

	function connectionClose($connection){
		if(isset($connection)){
			mysql_close($connection);
			unset($connection);
		}
	}

	function mysqlPrep($value){
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
	function isEmail($email){
		return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
	}
?>