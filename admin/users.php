<?php include("session.php");?>
<?php include("../includes/connection.php");?>
<?php include_once("functions.php");?>
<?php if(!chkLogin()){
	redirectTo("index.php");
}?>
<?php
	if(isset($_POST['submit'])){
		if(trim($_POST['username'])!=''){
			$username=trim(mysqlPrep($_POST['username']));
			$query="SELECT * FROM teamtwisterscores WHERE username='$username' LIMIT 1";
			$set=mysql_query($query);
			confirmQuery($set);
			if(mysql_num_rows($set)){
				$ary=mysql_fetch_array($set);
			}
			else{
				$message="Username not found";
			}
		}
		else{
			$message="Ussername field left empty";
		}
	}
?>
<html>
	<head>
		<title>Show scores of users</title>
	</head>
	<body>
		<form name="user_form" action="users.php" method="post">
			<p>Username: <input type="text" name="username" value=""/></p>
			<input type="submit" name="submit" value="Get Players Name"/>
			<?php
				if(isset($message)){
					echo "<p><i>{$message}</i></p>";
				}
				if(isset($ary)){
					$emailquery = "SELECT email FROM teamtwisterusers WHERE username = '$username' LIMIT 1";
					$ret=mysql_query($emailquery);
					confirmQuery($ret);
					if(mysql_num_rows($ret)){
						$fetchemail = mysql_fetch_array($ret);
						echo $fetchemail[0];
					}
					
					/*for($i=1; $i<=11; $i++){
						echo "<p>{$ary[".$i."]}</p>";
					}*/
					foreach($ary as $a)
						echo "<p>$a</p>";
				}
			?>
		</form>
		<a href="index.php">+ back to main</a>
	</body>
</html>
