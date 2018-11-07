<?php include_once("session.php");?>
<?php include_once("../includes/connection.php") ?>
<?php include_once("functions.php"); ?>

<?php if(!chkLogin()){
	redirectTo("index.php");
}?>

<?php 
	
	
	if(isset($_POST['makezero'])){
   
   $query2 ="update teamtwisterplayers set playerscore=0";
   $result = mysql_query($query2,$connection);
	if(!$result){
		die("The server might be off now:".mysql_error());
	}

	}	
	if(isset($_POST['submit'])){
			if(isset($_POST['score']) && isset($_POST['playerId'])){
					$score=intval(trim(mysqlPrep($_POST['score'])));
					$playerid=(trim(mysqlPrep($_POST['playerId'])));
					$val=chkPlayerId($playerid);
					if($val){
							$query="UPDATE teamtwisterplayers SET playerscore={$score} WHERE playerId='{$playerid}'";
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="../common/images/teamtwister.ico" type="image/ico" />
    <meta name="description" content="Project Description" />
    <meta name="keywords" content="Project Keywords" />
    <title>Synapse 2012 presents Team Twister</title>	
    <link href="../content/css/bootstrap.css" rel="stylesheet" type="text/css" />
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
	document.getElementById("runs").onblur=addruns;
	document.getElementById("wickets").onblur=addruns;
	document.getElementById("rcs").onblur=addruns;
   
	 
}

function addruns(evt){
	totalscore=0;
	runs=document.getElementById("runs").value;
	wickets=document.getElementById("wickets").value;
	rcs=document.getElementById("rcs").value;
	totalscore=totalscore+parseInt(runs)+parseInt(runs/50)*5;
	totalscore=totalscore+parseInt(wickets)*25;
	if(wickets>=3&wickets<5){
		totalscore=totalscore+5;
		}
	if(wickets>=5){
		totalscore=totalscore+10;
		}
	totalscore=totalscore+parseInt(rcs)*5;	
	
	document.getElementById("showsection").innerHTML="<h3>Totalscore:"+totalscore+"</h3>";
	
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
	 }
	 }
	/*document.getElementById("playername").value=26;
	alert("reached here");*/
	
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
		<p class="banner"><img src="../images/banner.png" alt="Banner" /></p>
		<h1>Team Twister: Admin's area</h1>
		<h2>Edit player scores</h2>
		<?php 
			if(isset($message)){
				echo "<p>{$message}</p>";
			}
		?>
		<form action="players.php" method="post">
		<h2>playerId  : <input type="text" name="playerId" size="20" maxlength="20" id="playerid" /></h2>
		<h2>playerName:<input type="text" name="playername" size="20" maxlength="20" id="playername" /></h2>

		<h2>runs      :<input type="text" name="runs" size="15" maxlength="20" id="runs" value="0"/></h2>
		<h2>wickets   :<input type="text" name="wickets" size="15" maxlength="20" id="wickets" value="0"/></h2>
		<h2>Runout Catch Stump: 
		<input type="text" name="playername" size="20" maxlength="15" id="rcs" value="0"/></h2>
		<h2>Enter Score :
		<input type="text" name="score" value=""/></h2><br/>
		<input type="submit" name="submit" value="submit"/>
		</form>
		<div id="showsection">
			<!-- something will get dynamically generated here-->
		</div>
		<div id="tablelist">
		<?php
		$score=0; 
		$query1="select * from teamtwisterplayers where playerscore!= $score";
		$result=mysql_query($query1,$connection);
		if(!$result){
			die("The server might be off now:".mysql_error());
		}
		$counter=1;
		echo "<table>";
		while($row = mysql_fetch_array($result)) {
			echo "<tr>";	
			echo "<td>".$counter."</td><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[5]."</td>";
			echo "</tr>";
			$counter=$counter+1;
		} 
		echo "</table>";
		?>
		</div>

		<form action="players.php" method="post">
		<input type="submit" name="makezero" value="makezero"/>
		</form>
		</div><!-- // end #content -->
	<div class="clear"></div>
</div><!-- // end #main -->
<?php
	include_once("footer.php");
	connectionClose($connection);
?>
