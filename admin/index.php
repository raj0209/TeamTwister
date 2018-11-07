<?php include_once("session.php");?>
<?php include_once("../includes/connection.php");?>
<?php include_once("functions.php");?>
<?php require_once("xmlgeneration.php"); ?>
<?php //here i will compare the login values with the database
	$updateSuccess = 0;
	if(isset($_POST['signup'])){

		//check whether the username and password fields are empty: will be done through javascript
		if((trim($_POST['username'])!='') && (trim($_POST['password'])!='')){

			//initialize $username and $password
			$username=trim(mysqlPrep($_POST['username'])); 
			$password=trim(mysqlPrep($_POST['password']));
		
			//check the length of user name and password: in javascript: required??

			$hash_password = sha1($password);
			
			//start the comparision process
			$query = "INSERT INTO teamtwisteradmin (username, password) VALUES ('{$username}', '{$hash_password}')";
		
			$set = mysql_query($query);

			//to confirm the query
			confirmQuery($set);
		
			$num = mysql_affected_rows();
		
			if($num){
				$_SESSION['admin'] = $username;
				$messageSignup = "Logged in";
			}
			else{
				$messageSignup = "Username/Password Incorrect. Please try again";
			}
		}
		else{
			$messageSignup = "Username/Password field left empty.Try again";
		}
	}
?>
<?php //here i will compare the login values with the database
	if(isset($_POST['login'])){

		//check whether the username and password fields are empty: will be done through javascript
		if((trim($_POST['username'])!='') && (trim($_POST['password'])!='')){

			//initialize $username and $password
			$username=trim(mysqlPrep($_POST['username'])); 
			$password=trim(mysqlPrep($_POST['password']));
		
			//check the length of user name and password: in javascript: required??

			$hash_password = sha1($password);
			
			//start the comparision process
			$query = "SELECT * FROM teamtwisteradmin WHERE username='{$username}' AND password='{$hash_password}' LIMIT 1";
		
			$set = mysql_query($query);

			//to confirm the query
			confirmQuery($set);
		
			$num = mysql_num_rows($set);
		
			if($num){
				$_SESSION['admin'] = $username;
				$message = "Logged in";
			}
			else{
				$message = "Username/Password Incorrect. Please try again";
			}
		}
		else{
			$message = "Username/Password field left empty.Try again";
		}
	}
?>
<?php 
	if(isset($_POST['update'])){
		$query="SELECT * FROM teamtwisterscores where player1 != 'NULL'";
		// echo $query;
		$scoreSet=mysql_query($query);
		confirmQuery($scoreSet);
		while($score=mysql_fetch_array($scoreSet)){
			$newScore=0;
			for($i=1; $i<=11; $i++){
				if($i==11){
					$newScore+=getPlayerScore($score[$i], 1);
					//echo "success".$newScore."<br/>";
				} else{
					$newScore+=getPlayerScore($score[$i]);
					//echo "success".$newScore."<br/>";
				}
			}
			$chk=insertScoreUser($score[0], $newScore);
			if($chk){
				$updateMessage = "Scores are updated. Now set the players scores to zero";
				$updateSuccess = 1;
			}
			else
				$updateMessage="not updated";
		}
	}
?>
<?php
	if(isset($_POST['status'])){
		$val=getStatus();
		if($val){
			setStatus(0);
		}
		else{
			setStatus(1);
		}
     }
?>
<?php
	if(isset($_POST['set'])){
		if(((trim($_POST['username'])!='') || (trim($_POST['email'])!='')) && (trim($_POST['setPassword'])!='')){
			$username=trim(mysqlPrep($_POST['username']));
			$password=trim(mysqlPrep($_POST['setPassword']));
			$email=trim(mysqlPrep($_POST['email']));
		
			//check the length of user name and password: in javascript: required??

			$hash_password = sha1($password);
			$chk=chkExistUsername($username)+chkExistEmail($email);
			if($chk){
				$set=mysql_query("UPDATE teamtwisterusers SET hash_password='{$hash_password}' WHERE username='{$username}' OR email='{$email}'");
				confirmQuery($set);
				if($set){
					$setMessage="Updated";
				}
				else{
					$setMessage="Unknown Error. Try again";}
			}
			else{
				$setMessage="Check again. Username already exists";
			}
		}
		else{
			$setMessage="Please Enter username and password";
		}
	}
?>
<?php
	include_once("header.php");
?>
<div id="main">
	<div id="sidebar">
		<ul id="menu">
			<li class="item-1"><a href="index.php">Admin</a></li>
			<?php if(chkLogin()){
					echo "<li class=\"item-2\"><a href=\"logout.php\">Logout</a></li>";
					echo "<li class=\"item-3\"><a href=\"players.php\">Player Update</a></li>";
					echo "<li class=\"item-4\"><a href=\"playerentry.php\">Edit players</a></li>";
					echo "<li class=\"item-5\"><a href=\"changepassword.php\">Admin Acc Settings</a></li>";
				}
				else {
					echo "<li class=\"item-2\"><a href=\"../index.php\">Public Site</a></li>";	
				}
			?>
		</ul>
	</div><!-- // end #sidebar -->
	<div id="content">
		<p class="banner"><img src="../common/images/banner.png" alt="Banner" /></p>
		<h1>Team Twister: Admin's area</h1>
		<?php
		if(isset($message) && !empty($message)){
				echo "<p id=\"errors\"><i>" .htmlentities($message). "</i></p>";
				}
		
		 if(isset($_GET['logout']) && $_GET['logout']==1){
				echo "<p><i>You have successfully logged out</i><p>";
			 	unset($_GET['logout']);
				}
		 if(!chkLogin()){
		 	echo "<h3 class=\"title\">login</h3>";
			echo "<form name=\"loginForm\" action=\"index.php\" method=\"post\">";
			echo "<p>Username: <input type=\"text\" name=\"username\" value=\"\"/></p>";
			echo "<p>Password: <input type=\"password\" name=\"password\" value=\"\"/></p>";
			echo "<input type=\"submit\" name=\"login\" value=\"Sign In\"/>";
			echo "</form>";
		 }
		?>
		<hr/>
		<?php if(isset($setMessage) && !empty($setMessage)){
				echo "<p id=\"errors\"><i>" .htmlentities($setMessage). "</i></p>";
				}
		?>
		<?php if(chkLogin()){
				echo "<form name=\"setPasswordForm\" action=\"index.php\" method=\"post\">";
				echo "<h3 class=\"title\">Change user's password</h3>";
				echo "<p>Username: <input type=\"text\" name=\"username\" value=\"\"/></p>";
				echo "<p>E-mail:   <input type=\"text\" name=\"email\" value=\"\"/></p>";
				echo "<p>Set Password: <input type=\"password\" name=\"setPassword\" value=\"\"/></p>";
				echo "<input type=\"submit\" name=\"set\" value=\"Set Password\"/>";
				echo "</form>";
			}
		?>
		<hr/>
		<?php if(chkLogin()){
				echo "<form name=\"addUser\" action=\"index.php\" method=\"post\">";
				echo "<h3 class=\"title\">Add Administrator</h3>";
				echo "<p>Username: <input type=\"text\" name=\"username\" value=\"\"/></p>";
				echo "<p>Set Password: <input type=\"password\" name=\"password\" value=\"\"/></p>";
				echo "<input type=\"submit\" name=\"signup\" value=\"Add Admin\"/>";
				echo "</form>";
			}
		?>
		<hr/>
		<?php if(getStatus()){
				echo "<p>The site is enabled</p>";
				}
			else{
				echo "<p>The site is disabled</p>";
			}
		?>
		<?php if(chkLogin()){
				echo "<form name=\"updateForm\" action=\"index.php\" method=\"post\">";
				echo "<input type=\"submit\" name=\"status\" value=\"Status On/off\"/><br/>";
				echo "<hr/><br/><br/><hr/>";
				if(isset($updateMessage) && !empty($updateMessage)){
					echo "<p id=\"errors\"><i>" .htmlentities($updateMessage). "</i></p>";
				}	
				echo "<input type=\"submit\" name=\"update\" value=\"Update User Scores\" ";
				if($updateSuccess==1){
					echo "disabled=\"true\"";
					$updateSuccess = 0;
				}
				echo "/>";
				echo "<br/>";
				echo "</form>";
				if(isset($newScore))
					echo "<p>{$newScore}</p>"; 
	  			}
		?>
		<hr/>
	</div><!-- // end #content -->
	<div class="clear"></div>
</div><!-- // end #main -->
<?php
	include_once("footer.php");
	connectionClose($connection);
?>