<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/function.php"); ?>
<?php include("xmlgeneration.php"); ?>
<?php
	if(!chkLogin()){
		redirectTo("index.php");
	}
?>
<?php $name=$_SESSION['username'];?>

<?php
	if(isset($_POST['submit'])){
		$query10="SELECT * from teamtwisterstatus";
		
		$result10=mysql_query($query10,$connection);

		if(!$result10){
		die("The server might be off now : ".mysql_error());
		}
		$row = mysql_fetch_array($result10);
		
	
    if($row[0]){
		//check if eleven players are selected. else return error message
		$player1=trim(mysqlPrep($_POST['player1']));
		$player2=trim(mysqlPrep($_POST['player2']));
		$player3=trim(mysqlPrep($_POST['player3']));
		$player4=trim(mysqlPrep($_POST['player4']));
		$player5=trim(mysqlPrep($_POST['player5']));
		$player6=trim(mysqlPrep($_POST['player6']));
		$player7=trim(mysqlPrep($_POST['player7']));
		$player8=trim(mysqlPrep($_POST['player8']));
		$player9=trim(mysqlPrep($_POST['player9']));
		$player10=trim(mysqlPrep($_POST['player10']));
		$captain=trim(mysqlPrep($_POST['player11']));
			if(trim($_POST['player1'])=="" || trim($_POST['player2'])=="" || trim($_POST['player3'])=="" || trim($_POST['player4'])=="" || trim($_POST['player5'])=="" || trim($_POST['player6'])=="" || trim($_POST['player7'])=="" || trim($_POST['player8'])=="" || trim($_POST['player9'])=="" || trim($_POST['player10'])=="" || trim($_POST['player11'])==""){
				$message="Please select 11 players!";
			}
			else{
				$query="UPDATE teamtwisterscores SET player1='{$player1}', player2='{$player2}', player3='{$player3}', player4='{$player4}', player5='{$player5}', player6='{$player6}', player7='{$player7}', player8='{$player8}', player9='{$player9}', player10='{$player10}', captain='{$captain}' WHERE username='{$name}'";
			
				$chk=mysql_query($query);
				confirmQuery($chk);
				$val=mysql_affected_rows();
				if($chk){
						$message="Submitted";
				}
				else{
						$message="Make sure you have entered all the values correctly or contact the web developer";
				}
			}
		}
		else{
		      $message="Sorry the sight is disabled right now";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href=" images/teamtwister.ico" type="image/ico" />
    <title>Synapse 2013 presents Team Twister</title>	
  
	<script type="text/javascript" src=" js/bootstrap.js"></script>			

<?php 
$query="select distinct country from teamtwisterplayers order by country";
$result=mysql_query($query,$connection);
if(!$result){
	die("The server might be off now:".mysql_error());
}
$countrycount=mysql_num_rows($result);
$query2="select * from teamtwisterscores WHERE username='{$name}'";
$result2=mysql_query($query2,$connection);

$selectedidarry=array();
if(!$result2){
	die("The server might be off now : ".mysql_error());
}
$row = mysql_fetch_array($result2);
?>
<script type="text/javascript">

window.onload=initall;
<?php
	$status = getStatus();
	echo "var enable=".$status.";";
?>
var batsmen=0;
var bowlers=0;
var wicketkeeper=0;
var allrounder=0;
var cost=0;
var k=0;
var n=0;
var comingcount=0;
var capt="";
var mistake=0;

var xhr = false;

var list = new Array();
var dataArray = new Array();
var playerArray = new Array();
var selectedArray = new Array();

var url = "playerlist1.xml";
 var outmsg1=display("Australia");
 var outmsg2=display("Selected players");

function clkSelect(){
   var outmsg="";
 	for(var i=0;i<selectedArray.length;i++){
 		outmsg=outmsg+"<option value=\""+selectedArray[i].playername+"\">"+selectedArray[i].playername+"</option>>";
 		}
 	document.getElementById("captain").innerHTML=outmsg;
}

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
	list[0]="<?php echo $row[1];?>";
	list[1]="<?php echo $row[2];?>";
	list[2]="<?php echo $row[3];?>";
	list[3]="<?php echo $row[4];?>";
	list[4]="<?php echo $row[5];?>";
	list[5]="<?php echo $row[6];?>";
	list[6]="<?php echo $row[7];?>";
	list[7]="<?php echo $row[8];?>";
	list[8]="<?php echo $row[9];?>";
	list[9]="<?php echo $row[10];?>";
	list[10]="<?php echo $row[11];?>";
	

    
    for(var i=0;i<<?php echo $countrycount; ?>;i++){	/*the 2 has to be changed with the count of php or countries count*/ 
	 var countryid = "c"+i;
	 
	 document.getElementById(countryid).onclick=check;
	 }
}

function selectplayer(evt){
   var thetag = (evt) ? evt.target : window.event.srcElement;
   var i=thetag.id;
   for (var j=0;j<selectedArray.length;j++){
   	if(selectedArray[j].playername==playerArray[i].playername){
   		alert("you have already selected the player");
			return false;		
		}
	}   
   var outmsg=display("Selected Players");
 
   switch(playerArray[i].playertype)
   {
   	case "batsmen":
   		batsmen=batsmen+1;
    	break;
    case "bowler":
    	bowlers=bowlers+1;
    	break;
    case "wicketkeeper":
    	wicketkeeper=wicketkeeper+1;
    	break;
    case "allrounder":
    	allrounder=allrounder+1;
    	break;
    default:
    	alert("xml mistake");
   }
   
	if(batsmen>5){
		alert("exceeded batsmen");
		batsmen=batsmen-1;
		return false;
	}
	if(bowlers>4){
		bowlers=bowlers-1;
		alert("exceeded limit for bowlers");
		return false;
	}
	if(wicketkeeper>1){
		wicketkeeper=wicketkeeper-1;
		alert("exceeded wicketkeepers");
		return false;
	}
	if(allrounder>1){
		allrounder=allrounder-1;
		alert("exceeded allrounders");
		return false;
	}		
	if(selectedArray.length==11){
		alert("you can not select more than 11 players");
		return false;
	}	
		
	selectedArray[selectedArray.length] =  retTemponArray(playerArray,i);
	cost=cost+parseInt(selectedArray[selectedArray.length-1].cost);
	document.getElementById("cost").value=cost;
   	
	for(var i=0;i<selectedArray.length;i++){
		outmsg=outmsg+"<tr><td><img src=\" images/"+selectedArray[i].playertype+".png\" alt=\"\" width=\"25\" height=\"25\" /></td>"+"<td><a href=\"\" id=\"s"+i+"\">"+selectedArray[i].playername+"</a></td><td>"+selectedArray[i].cost+"</td></tr>";
   	}
   outmsg=outmsg+"</tbody></table>";
   	document.getElementById("selectedplayers").innerHTML=outmsg;
  	clkSelect();
   	for(var i=0;i<selectedArray.length;i++){
   	var selectedid="s"+i;
   	document.getElementById(selectedid).onclick=removeplayer;
   	}
   	return false;	
}

function removeplayer(evt){
	var thetag = (evt) ? evt.target : window.event.srcElement;
   	var i=thetag.id;
   	i=i.replace("s", "");
    
    switch(selectedArray[i].playertype)
   	{
   	case "batsmen":
   		batsmen=batsmen-1;
      	break;
    case "bowler":
      	bowlers=bowlers-1;
      	break;
    case "wicketkeeper":
      	wicketkeeper=wicketkeeper-1;
      	break;
    case "allrounder":
      	allrounder=allrounder-1;
      	break;
    default:
      	alert("xml mistake");
    }
   	cost=cost-parseInt(selectedArray[i].cost);  
   	selectedArray[i] = retTemponArray(selectedArray,selectedArray.length-1);
    document.getElementById("cost").value=cost;
   	selectedArray.length=selectedArray.length-1;
   	var outmsg=display("Selected Players");
   	for(var i=0;i<selectedArray.length;i++){
	outmsg=outmsg+"<tr><td><img src=\" images/"+selectedArray[i].playertype+".png\" alt=\"\" width=\"25\" height=\"25\" /></td>"+"<td><a href=\"\" id=\"s"+i+"\">"+selectedArray[i].playername+"</a></td><td>"+selectedArray[i].cost+"</td></tr>";
   	}
   
   	document.getElementById("selectedplayers").innerHTML=outmsg;
   	clkSelect();
   	for(var i=0;i<selectedArray.length;i++){
   		var selectedid="s"+i;
   		document.getElementById(selectedid).onclick=removeplayer;
   	}
	return false;
}

function check(evt){
   var thetag = (evt) ? evt.target : window.event.srcElement;
   var country=thetag.innerHTML;   
 
   //document.write(country);
   var outmsg=display(country);
   var count=0;  
   var listcount=0; 
   for (var i=0;i<dataArray.length;i++){
   		if(dataArray[i].country==country){
   			playerArray[count] =retTemponArray(dataArray,i) ;
			outmsg=outmsg+"<tr><td><img src=\" images/"+dataArray[i].playertype+".png\" alt=\"\" width=\"25\" height=\"25\" /></td>"+"<td><a href=\"\" id=\""+count+"\">"+dataArray[i].playername+"</a></td><td>"+dataArray[i].cost+"</td></tr>";
     		count++;
     	}
   	}
  	outmsg=outmsg+"</tbody></table>";

	document.getElementById("players").innerHTML=outmsg;
    for(var i=0;i<count;i++){
    var idselected=""+i;	 
		document.getElementById(idselected).onclick=selectplayer;
	}
	return false;	
}

function setDataArray(){
	if (xhr.readyState == 4) {
		if (xhr.status == 200) {
			if (xhr.responseXML) {
				var allData = xhr.responseXML.getElementsByTagName("player"); /*xhr request is sent and data stored in dataArray*/
          
            complete=allData.length-1;
            for (var i=0; i<allData.length; i++) {
				  dataArray[i] = retTemp(allData,i);
				  
				  setaustralia(allData,i);/*displaying player list of australia*/
				  
   			  if(list[0]!=""){	
   			  setselectedplayer(allData,i)/*displaying selected player list*/
   			  }  
			}
			  
			}
		}
		else {
			alert("There was a problem with the request " + xhr.status);
		}
	}
}	

function getVal(theData,theTag) {
	return theData.getElementsByTagName(theTag)[0].firstChild.nodeValue;
}

function retTemp(allData,i){	

	var tempObj = new Object;
	tempObj.playertype = getVal(allData[i],"playertype");
	tempObj.playername = getVal(allData[i],"playername");
	tempObj.country = getVal(allData[i],"country");
	tempObj.cost = getVal(allData[i],"cost");
	tempObj.playerid = getVal(allData[i],"playerid");
	return tempObj;
}

function display(headingname){
	var outmsg="<table class=\"table table-condensed table-hover\"><caption><legend><h2 class=\"label label-large label-warning\">"+headingname+"</h2></br></br></legend></caption><thead><tr>";
   	var outmsg=outmsg+"<th>Type</th><th>Playername</th><th>Cost</th></tr></thead><tbody>";   
   	return outmsg;
}

function setaustralia(allData,i){
	 /*starting of setting for australia*/  	
	if(dataArray[i].country=="Australia"){  
		playerArray[k]=retTemponArray(dataArray,i);
		k++;
	}
	if(i==allData.length-1){
		for(var l=0;l<playerArray.length;l++){
			outmsg1=outmsg1+"<tr><td><img src=\" images/"+playerArray[l].playertype+".png\" alt=\"\" width=\"25\" height=\"25\" /></td>"+"<td><a href=\"\" id=\""+l+"\">"+playerArray[l].playername+"</a></td>"+"<td>"+playerArray[l].cost+"</td></tr>";
		}
   		outmsg1=outmsg1+"</tbody></table>";
   		document.getElementById("players").innerHTML=outmsg1;
   		for(var l=0;l<playerArray.length;l++){
    		var idselected=""+l;	 
	 		document.getElementById(idselected).onclick=selectplayer;/*onclick event for the australian players*/
		}
   	}
   				/*end of setting of the australia country list*/
}

function setselectedplayer(allData,i){
	for(var j=0;j<list.length;j++){
		if(dataArray[i].playerid==list[j]){  
		if(list[10]==dataArray[i].playerid){
			capt=dataArray[i].playername;
		}
		switch(dataArray[i].playertype){
			case "batsmen":
				batsmen=batsmen+1;
				break;
			case "bowler":
					bowlers=bowlers+1;
					break;
			case "wicketkeeper":
					wicketkeeper=wicketkeeper+1;
					break;
			case "allrounder":
					allrounder=allrounder+1;
					break;
			default:
					alert("xml mistake");
		}
		if(batsmen>5){
			mistake=1;
			batsmen=batsmen-1;
		}
		if(bowlers>4){
			mistake=1;
			bowlers=bowlers-1;				
		}
		if(wicketkeeper>1){
			mistake=1;
			wicketkeeper=wicketkeeper-1;				
		}
		if(allrounder>1){
			mistake=1;
			allrounder=allrounder-1;				
		}
		if(mistake == 0){
			selectedArray[n]=retTemponArray(dataArray,i);
			n++;
		}
		else{
			mistake=0;
		}
		}
	}
	if(dataArray.length==allData.length && comingcount==0){
   	comingcount=1;
	for(var k=0;k<selectedArray.length;k++){
		outmsg2=outmsg2+"<tr><td><img src=\" images/"+selectedArray[k].playertype+".png\" alt=\"\" width=\"25\" height=\"25\" /></td>"+"<td><a href=\"\" id=\"s"+k+"\">"+selectedArray[k].playername+"</a></td>"+"<td>"+selectedArray[k].cost+"</td></tr>";
   	   	cost=cost+parseInt(selectedArray[k].cost);
   	}
   outmsg2=outmsg2+"</tbody></table>";
   var outmsg5="";
   outmsg5=outmsg5+"<option value=\""+capt+"\">"+capt+"</option>";
   for(var k=selectedArray.length-1;k>-1;k--)
   {
	   	if(selectedArray[k].playername != capt){
		outmsg5=outmsg5+"<option value=\""+selectedArray[k].playername+"\">"+selectedArray[k].playername+"</option>";
	}   
   }
   document.getElementById("captain").innerHTML=outmsg5;
   document.getElementById("cost").value=cost;
   document.getElementById("selectedplayers").innerHTML=outmsg2;
   for(var k=0;k<selectedArray.length;k++){
   		var selectedid="s"+k;
   		document.getElementById(selectedid).onclick=removeplayer;
   }
   }	
	
}

function retTemponArray(Array1,i){
	var tempObj = new Object;
	tempObj.playertype = Array1[i].playertype;
	tempObj.playername = Array1[i].playername;
	tempObj.country = Array1[i].country;
	tempObj.cost = Array1[i].cost;
	tempObj.playerid = Array1[i].playerid;
	return tempObj;
	
}

function getSelectIndex(playerName){
	for(var i=0; i<selectedArray.length; i++){
		if(selectedArray[i].playername==playerName)
			return i;
	}
	return 10; //by default the last player will be considered as the captain
}

function swapObjs(obj1, obj2){
	var tmp=new Object;

	tmp.playerid=obj1.playerid;
	tmp.playername=obj1.playername;
	tmp.cost=obj1.cost;
	tmp.country=obj1.country;
	tmp.playertype=obj1.playertype;
	
	obj1.playerid=obj2.playerid;
	obj1.playername=obj2.playername;
	obj1.cost=obj2.cost;
	obj1.country=obj2.country;
	obj1.playertype=obj2.playertype;

	obj2.playerid=tmp.playerid;
	obj2.playername=tmp.playername;
	obj2.cost=tmp.cost;
	obj2.country=tmp.country;
	obj2.playertype=tmp.playertype;

}
	
function onClkSubmit(form){	
    if(cost<=1000){
    if(enable){
		if(selectedArray.length==11){
			var lastPlayerName=selectedArray[10].playername;
			var selectIndex=getSelectIndex(form.captain.value);
			if(lastPlayerName!=(form.captain.value)){
			swapObjs(selectedArray[10], selectedArray[selectIndex]);
			}
			
			form.player1.value=selectedArray[0].playerid;
			form.player2.value=selectedArray[1].playerid;
			form.player3.value=selectedArray[2].playerid;
			form.player4.value=selectedArray[3].playerid;
			form.player5.value=selectedArray[4].playerid;
			form.player6.value=selectedArray[5].playerid;
			form.player7.value=selectedArray[6].playerid;
			form.player8.value=selectedArray[7].playerid;
			form.player9.value=selectedArray[8].playerid;
			form.player10.value=selectedArray[9].playerid;
			form.player11.value=selectedArray[10].playerid;
			return true;
		}
		else{
			alert("Operation Failed. Please select 11 players");
			return false;
		}
	}
	else{
	alert("The site is disabled right now");
	return false;
	}
	}
	else{
		alert("cost exceeded");
		document.getElementById("mess").innerHTML="<p></p>";
		return false;
	}

}
</script>

</head>


<body>

<?php include("header.php"); 
?>
		<?php
			$count=0;
			echo "<div id=\"home-tiles\" class=\"container-fluid\">";
			
        	while($row = mysql_fetch_array($result)) {
		
				if(($count+3) % 3 == 0 ) { 
					echo "
				<div class=\"row-fluid\">";  
				}
         		echo "
					<div class=\"metro span4\" >
					";
				
				echo	"	<a href=\"#sel\"  id=\"c".$count."\" data-toggle=\"modal\" style=\"padding-top:0; padding-right:0;\" class=\"tile wide imagetext bg-color-"; 
						if($count%4==0)
						{ 
							echo "blue"; 
						}
						else if($count % 4 == 1) { echo "green"; }
						else if($count % 4 == 2) { echo "orange"; }
						else { echo "pink"; }
						if($count % 3 == 0) { echo " first"; }
						else if($count % 3 == 1) { echo " middle"; }
						else { echo " last "; }
						echo"\">
						
							  <div  style=\"line-height:130px; font-size:40px;width:290px;height:130px;position:relative;left:-20px;padding-left:20px;\">".$row[0]."</div>
						   
						</a>
					</div>
				";
				if(($count+1) % 3 == 0) { echo "</div></br></br>"; }
				$count=$count+1;  
				
         	} 
			echo "</div>";
			
		?>
		<div class="modal1 hide fade" id="sel" aria-hidden="true">
			<div class="modal-header">
				
				<div class="row">
					<div class="span9">
						<center><h2>Click on the Player to select/remove</h2></center>
					</div>
					<div class="span1">
						Cost: <input class="span1" disabled id="cost" value=""/>
					</div>
				</div>
			</div>
			<div  class="modal1-body">
				<div class="span10">
					<div class="row">
						<div id="players" class="span5">
							<?php
								if(isset($message)){
									echo "<p>".htmlentities($message)."</p>";
								}
							?>
						</div>
				
						<div  id="selectedplayers" class="span5">
						</div>	
						
						<div class="form">
							<form name="submit" action="createteam.php" method="post" onsubmit="return onClkSubmit(this);">
							<div class="row">
								<input type="hidden" name="player1" value=""/>
								<input type="hidden" name="player2" value=""/>
								<input type="hidden" name="player3" value=""/>
								<input type="hidden" name="player4" value=""/>
								<input type="hidden" name="player5" value=""/>
								<input type="hidden" name="player6" value=""/>
								<input type="hidden" name="player7" value=""/>
								<input type="hidden" name="player8" value=""/>
								<input type="hidden" name="player9" value=""/>
								<input type="hidden" name="player10" value=""/>
								<input type="hidden" name="player11" value=""/>	</br>
							</div>				
							<div class="row">
							
								<div class="clear-fix"></div>
								<div class="pull-right"></div>&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;	
								Select captain:	 			
									<select name="captain" id="captain"></select>&nbsp;&nbsp;&nbsp;	<input type="submit" name="submit" id="submit" value="submit"/>
							</div>
							</form>
							
							<div id="mess">
							<?php if(isset($message) && !empty($message)){
									echo "<p><i>".htmlentities($message)."</i></p>";
						
							}?>
							</div>
						</div>
						</br>			  
					</div>
				</div>
			</div>
		</div>

</body>
<?php
	include("footer.php");
	connectionClose($connection);
?>
