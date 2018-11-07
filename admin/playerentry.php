<?php include("session.php");?>
<?php include("../includes/connection.php") ?>
<?php include_once("functions.php"); ?>
<?php include_once("xmlgeneration.php"); ?>
<?php if(!chkLogin()){
	redirectTo("index.php");
}?>

<?php 
	if(isset($_POST['submit'])){
			if(isset($_POST['playerid']) && isset($_POST['playername']) && isset($_POST['country']) && isset($_POST['playertype']) && isset($_POST['cost'])){
				$playerid=	trim(mysqlPrep($_POST['playerid']));
				$playername =	trim(mysqlPrep($_POST['playername']));
				$country=	trim(mysqlPrep($_POST['country']));
				$playertype=	trim(mysqlPrep($_POST['playertype']));
				$cost=	trim(mysqlPrep($_POST['cost']));			
				
				$query3="select *from teamtwisterplayers where  playerid='{$playerid}'";
				$result3=mysql_query($query3,$connection);
				if(!$result3){
					die("The server might be off now:".mysql_error());
				}
				$num_rows = mysql_num_rows($result3);
				
				
				if($num_rows){
				/*update has to be done here*/						
				
				$query4="update teamtwisterplayers  set playername='{$playername}',country='{$country}',cost={$cost},playertype='{$playertype}' where   playerid='{$playerid}'";
				$result4=mysql_query($query4,$connection);
					if(!$result4){
						die("The server might be off now:".mysql_error());
					}
					$num=mysql_affected_rows();
					if($num)
					{
						echo("every thing got updated");					
					}								
				}
				
				else {
				/*insert the row into database*/
				$query5="INSERT INTO teamtwisterplayers (`playerid`, `playername`, `country`, `cost`, `playertype`, `playerscore`) VALUES('{$playerid}', '{$playername}', '{$country}', {$cost}, '{$playertype}',0)";
				$result5=mysql_query($query5,$connection);
					if(!$result5){
						die("The server might be off now:".mysql_error());
					}
					$num=mysql_affected_rows();
					if($num)
					{
						echo("every thing got inserted");					
					}					
					
					
				}
							
				
				
				
				
				
				}
					
					
	}
	
	if(isset($_POST['submit1'])){
		if(isset($_POST['playerid2'])){
			$playerid=	trim(mysqlPrep($_POST['playerid2']));		
			$query5="Delete from teamtwisterplayers where playerid='{$playerid}'";
			$result5=mysql_query($query5,$connection);
					if(!$result5){
						die("The server might be off now:".mysql_error());
					}
					else{
						echo("successfully deleted");	
					}			
			}
		

		
		
		}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="../common/images/teamtwister.ico" type="image/ico" />
    <meta name="description" content="Project Description" />
    <meta name="keywords" content="Project Keywords" />
    <title>Synapse 2012 presents Team Twister</title>	
    <link href="../common/stylesheets/style.css" rel="stylesheet" type="text/css" />	
    <script type="text/javascript" >
window.onload=initall;
var batsmen=0;
var bowlers=0;
var wicketkeeper=0;

var xhr = false;
var dataArray = new Array();
var playerArray = new Array();
var selectedArray = new Array();
var url = "playerlist.xml";
var totalscore=0;

function initall(){
	
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	}
	else {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) { }
		}
	}

   if (xhr) {
		xhr.onreadystatechange = setDataArray;
		xhr.open("GET", url, true);
		xhr.send(null);
	}
	else {
		alert("Sorry, but I couldn't create an XMLHttpRequest");
	}
	//end of ajax request
	document.getElementById("playerid").onblur=showplayername;
	
}



function setDataArray(){
	if (xhr.readyState == 4) {
		if (xhr.status == 200) {
			if (xhr.responseXML) {
				var allData = xhr.responseXML.getElementsByTagName("player");

				
				for (var i=0; i<allData.length; i++) {
					var tempObj = new Object;
					tempObj.playertype = getVal(allData[i],"playertype");
					tempObj.playername = getVal(allData[i],"playername");
					tempObj.country = getVal(allData[i],"country");
					tempObj.cost = getVal(allData[i],"cost");
					tempObj.playerid = getVal(allData[i],"playerid");
				   dataArray[i] = tempObj;
	            			
				}
			}
		}
		else {
			alert("There was a problem with the request " + xhr.status);
		}
		
	
	}
	
	function getVal(theData,theTag) {
		return theData.getElementsByTagName(theTag)[0].firstChild.nodeValue;
	}

	}

function showplayername(evt){
	 var thetag = (evt) ? evt.target : window.event.srcElement;
	 var theid=thetag.value;
	 for(var i=0;i<dataArray.length;i++){
	 if(dataArray[i].playerid==theid){
	 	document.getElementById("playername").value=dataArray[i].playername;	
		document.getElementById("playertype").value=dataArray[i].playertype;
		document.getElementById("country").value=dataArray[i].country;	
		document.getElementById("cost").value=dataArray[i].cost;			 
	 }
	 }
}
</script>		
</head>

<body>

<div id="header">
	<h1 id="logo"><a href="index.php">Team Twister</a></h1>
	<ul class="socials">
		<!--<li class="facebook"><a href="http://synapse.daiict.ac.in">Synapse</a></li>-->
	</ul>
	<div class="clear"></div>
</div><!-- // end #header -->
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
		<p class="banner"><img src="../common/images/banner.png" alt="Banner" /></p>
		<h1>Team Twister: Admin's area</h1>
		<h2>Edit players</h2>
		<?php 
		if(isset($message)){
			echo "<p>{$message}</p>";
		}
		?>
		<form action="playerentry.php" method="post">
		<h2> Update or insert a player<h2>
		<br/>
		<h2>playerId  : <input type="text" name="playerid" size="20" maxlength="20" id="playerid" /></h2>
		<h2>playerName:<input type="text" name="playername" size="20" maxlength="20" id="playername" /></h2>
		<h2>playertype :<input type="text" name="playertype" size="20" maxlength="20" id="playertype" /></h2>
		<h2>country :<input type="text" name="country" size="20" maxlength="20" id="country" /></h2>
		<h2>cost: <input type="text" name="cost" size="20" maxlength="15" id="cost" /></h2>
		<br/>
		<input type="submit" name="submit" value="submit"/>
		<br/>
		<h2>Delete a player<h2>
		<h2>playerId  : <input type="text" name="playerid2" size="20" maxlength="20" id="playerid2" /></h2>
		<input type="submit" name="submit1" value="submit1"/>
		</form>
		
		<div id="showsection">
			
		</div>
		<form action="players.php" method="post">
		<input type="submit" name="makezero" value="makezero"/>
		</form>
		<div id="tablelist">
		<?php
		$score=0; 
		$query1="select* from teamtwisterplayers";
		$result=mysql_query($query1,$connection);
		if(!$result){
			die("The server might be off now:".mysql_error());
		}
		echo "<table>";

		while($row = mysql_fetch_array($result)) {
			echo "<tr>";	
			echo "<td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td>";
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
