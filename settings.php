<?php
	include_once("header.php");
?>

<?php if(!chkLogin()){
	redirectTo("index.php");
}?>
<?php 
	if(isset($_POST['submit'])){
		if(trim($_POST['oldPassword']) && trim($_POST['newPassword']) && trim($_POST['confirmPassword'])){
			$username=trim(mysqlPrep($_SESSION['username']));
			$oldPassword=trim(mysqlPrep($_POST['oldPassword']));
			$hashOldPassword=sha1($oldPassword);
			$query="SELECT username FROM teamtwisterusers WHERE username='{$username}' AND hash_password='{$hashOldPassword}'";
			$set=mysql_query($query);
			confirmQuery($set);
			$num=mysql_num_rows($set);
			if($num){
				//proceed with changing the password
				$newPassword=trim(mysqlPrep($_POST['newPassword']));
				$confirmPassword=trim(mysqlPrep($_POST['confirmPassword']));
				if($newPassword==$confirmPassword){
					$hashNewPassword=sha1($newPassword);
					$insrt="UPDATE teamtwisterusers SET hash_password='{$hashNewPassword}' WHERE username='{$username}'";
					$optn=mysql_query($insrt);
					confirmQuery($optn);
					$chk=mysql_affected_rows();
					if($optn){
						$message="Your Password has been changed.";
					}
					else{
						$message="Unknown error. Please Try again or contact the web developer";
					}
				}
				else{
					$message="ERROR: new Password and confirm Password fields does not match";
				}	
			}
			else{
				$message="ERROR: Incorrect Password.";
			}
		}
		else{
			$message="ERROR: Make sure that all the fields are filled";
		}
	}
?>
<div class="span12">
<div id="row">
	
		
		
		<div class="span8 pull-right">
	
	
			<h2 class="title"><span class="text-error">Change Password</span></h2></br>
			<div>
			<?php
				if(isset($message)){
				echo "<p>".htmlentities($message)."</p>";
				unset($message);
				}
			?>
			<table>
			<form name="changePassword" action="settings.php" method="post">
			<tr>
				<td  class="text-info">Old Password: </td><td><input type="password" name="oldPassword" value="" id="oldPassword"/></td>
			</tr>
			<tr>
				<td  class="text-info">New Password: </td><td><input type="password" name="newPassword" value="" id="newPassword"/></td>
			</tr>
			<tr>
				<td  class="text-info">Confirm Password: </td><td><input type="password" name="confirmPassword" value="" id="conPassword"/></td>
			</tr>
			<tr></tr>
			<tr>
				<td><input name="submit" type="submit" value="Change" onsubmit="return formValidation(this);"/></td>
			</tr>
			</form>
			</table>
			</div>
		
	</div><!-- // end #content -->
	<div class="clear"></div>
	</div>
</div><!-- // end #main -->
<?php
	include_once("footer.php");
	connectionClose($connection);
?>
