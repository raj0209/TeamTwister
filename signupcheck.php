<?php
	include_once("includer.php");
?>
<?php //insertion operation in the database
	if(isset($_POST['register'])){

		if((trim($_POST['username'])!='') && (trim($_POST['password'])!='') && (trim($_POST['conPassword'])!='') && (trim($_POST['emailid'])!='') && (trim($_POST['contactNo']!=''))){
			
			$username=trim(mysqlPrep($_POST['username']));
			$query = "SELECT username FROM teamtwisterusers WHERE username='{$username}' LIMIT 1";
			$chk = mysql_query($query);
			$num = mysql_num_rows($chk);
			if($num==0){
				//now check if the confirm password equals the password
				$password = trim(mysqlPrep($_POST['password']));
				$conPassword = trim(mysqlPrep($_POST['conPassword']));
		
				if($password==$conPassword){
					$email=trim(mysqlPrep($_POST['emailid']));
					$hash_password = sha1($password);
					if(isEmail($email)){
						$chkEmail=chkEmail($email);
						if($chkEmail){
							$contactNo=trim(mysqlPrep($_POST['contactNo']));
							$hash_password = sha1($password);
							$college=trim(mysqlPrep($_POST['college']));
							$insert = "INSERT INTO teamtwisterusers (username, hash_password, email, college, contactNo) VALUES ('{$username}', '{$hash_password}', '{$email}', '{$college}', {$contactNo})";
							$set = mysql_query($insert);
							confirmQuery($set);
							$aff = mysql_affected_rows();
							if($aff==1){
								$queryInsert= "INSERT INTO teamtwisterscores (username, prevScore, totalScore) VALUES ('{$username}', 0, 0)";
								$chk=mysql_query($queryInsert);
								confirmQuery($chk);
								$num=mysql_affected_rows();
								if($num){
									$_SESSION['username']=$username;
									redirectTo("index.php");
								}
								else{
									$error_message="ERROR. Could not sign in. Try again";
								}
							} 
							else{
							$error_message="Could not register.<br>Unknown Error. Try again";
							$checkError = 1;
							}
						}
						else{
							$error_message="ERROR. Email id already in use. Please use another one";
						}
					}
					else{
						$error_message="Could not register. Enter valid Email id.";
					}
				}
				else{
					$error_message="Could not register.<br/>Confirm password does not match with password. Try again";
				}
			}
			else{
				$error_message="Could not register.<br/>Username already exists. Please use another one";
			}
		}
		else{
			$error_message="Could not register.<br/>Make sure that all the fields are entered and then click Register";
		}
	} 

		if($error_message){
			header("Location: index.php?login=\"\"&register=0&error_message={$error_message}");
		} else {
			header("Location: index.php?login=\"\"&register=1");
		}

?>