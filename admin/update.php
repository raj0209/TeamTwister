<?php include("session.php");?>
<?php include("../includes/connection.php") ?>
<?php include_once("functions.php"); ?>

<?php if(!chkLogin()){
	redirectTo("index.php");
}?>

<?php 
	
if(isset($_POST['submit'])){
			if(isset($_POST['score']) && isset($_POST['playerId'])){
					$score=intval(trim(mysqlPrep($_POST['score'])));
					$playerid=(trim(mysqlPrep($_POST['playerId'])));
					$val=chkPlayerId($playerid);

					if($val){
							$query="UPDATE teamtwisterplayers SET playerscore={$score} WHERE playerid='{$playerid}'";
							$chk = mysql_query($query);
							confirmQuery($chk);
							$num=mysql_affected_rows();
							if($num){
								$message="Score Updated";
							}
							else{
								$message="ERROR. Query failed. Unknown Error";
							}
					}
					else {
						$message="ERROR.player id not found";
					}
			}
			else{
					$message="ERROR.Please enter valid score/playerid";
			}
	}		
?>
<?php
	include_once("../common/includes/header.php");
?>
<div id="main">
	<div id="sidebar">
		<ul id="menu">
			<li class="item-1"><a href="index.php">Admin</a></li>
			<?php if(chkLogin()){
					echo "<li class=\"item-2\"><a href=\"logout.php\">Logout</a></li>";
					echo "<li class=\"item-3\"><a href=\"players.php\">Player Update</a></li>";
					echo "<li class=\"item-4\"><a href=\"playerentry.php\">Edit players</a></li>";
				}
				else {
					echo "<li class=\"item-2\"><a href=\"\">Public Site</a></li>";	
				}
			?>
		</ul>
	</div><!-- // end #sidebar -->
	<div id="content">
		<p class="banner"><img src="../common/images/banner.png alt="Banner" /></p>
		<h1>Team Twister: Admin's area</h1>
		<?php 
			if(isset($message)){
				echo "<p>{$message}</p>";
			}
		?>
		<form action="update.php" method="post">
		<h2>playerId  : <input type="text" name="playerId" size="20" maxlength="20" id="playerid" /></h2>
		<h2>playerName:<input type="text" name="playername" size="20" maxlength="20" id="playername" /></h2>

		<h2>runs      :<input type="text" name="runs" size="20" maxlength="20" id="runs" value="0"/></h2>
		<h2>wickets   :<input type="text" name="wickets" size="20" maxlength="20" id="wickets" value="0"/></h2>
		<h2>Runout Catch Stump: 
		<input type="text" name="playername" size="20" maxlength="20" id="rcs" value="0"/></h2>
		<h2>Enter Score
		<input type="text" name="score" value=""/></h2><br/>
		<input type="submit" name="submit" value="submit"/>
		</form>


		<div id="recentmatches">
		<?php
 		$query1="select* from teamtwistermatches ";
		$result=mysql_query($query1,$connection);
		if(!$result){
			die("The server might be off now:".mysql_error());
		}
		echo "<table>";
		while($row = mysql_fetch_array($result)) {
			echo "<tr>";	
			echo "<td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td>";
			echo "</tr>";
		} 
		echo "</table>";
		?>
		</div>
	</div><!-- // end #content -->
	<div class="clear"></div>
</div><!-- // end #main -->
<?php
	include_once("footer.php");
	connectionClose($connection);
?>
