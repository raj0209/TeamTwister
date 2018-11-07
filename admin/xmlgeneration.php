<?php include_once("../includes/connection.php") ?>
<?php include_once("functions.php"); ?>
<?php
			
			$players = array(); 			
			$query="select * from teamtwisterplayers";
			$result=mysql_query($query,$connection);
			if(!$result){
				die("The server might be off now:".mysql_error());
			}
        while($row = mysql_fetch_array($result)) {
         	if($row[4]=="batsmen"){
         		$players [] = array( 
  						'playerid' => $row[0], 
  						'playertype' => $row[4], 
  						'playername' => $row[1],
  						'country' => $row[2],
  						'cost' => $row[3]
  					); 
         	
         	}
		  }
		  $result1=mysql_query($query,$connection); 
		  while($row = mysql_fetch_array($result1)) {
         	if($row[4]=="allrounder"){
         	$players [] = array( 
  						'playerid' => $row[0], 
  						'playertype' => $row[4], 
  						'playername' => $row[1],
  						'country' => $row[2],
  						'cost' => $row[3]
  					); 
		      }
		  }
		  $result2=mysql_query($query,$connection);
		  while($row = mysql_fetch_array($result2)) {
         	if($row[4]=="wicketkeeper"){
         	$players [] = array( 
  						'playerid' => $row[0], 
  						'playertype' => $row[4], 
  						'playername' => $row[1],
  						'country' => $row[2],
  						'cost' => $row[3]
  					); 
		      }
		  }
		  $result3=mysql_query($query,$connection);
		  while($row = mysql_fetch_array($result3)) {
         	if($row[4]=="bowler"){
         	$players [] = array( 
  						'playerid' => $row[0], 
  						'playertype' => $row[4], 
  						'playername' => $row[1],
  						'country' => $row[2],
  						'cost' => $row[3]
  					); 
		      }
		  } 
		
		 
	
		   $file_handle = fopen('playerlist.xml','w'); 
			$content = "<?xml version=\"1.0\"?>\n<players>";
			$i=0;
			while($i<count($players))
			{
				$content.="\n\t<player>";				
				$content.="\n\t\t<playerid>".$players[$i]['playerid']."</playerid>";
				$content.="\n\t\t<playertype>".$players[$i]['playertype']."</playertype>";  
				$content.="\n\t\t<playername>".$players[$i]['playername']."</playername>"; 
				$content.="\n\t\t<country>".$players[$i]['country']."</country>"; 
				$content.="\n\t\t<cost>".$players[$i]['cost']."</cost>"; 				
				$content.="\n\t</player>\n";				
				$i=$i+1;
			} 
	
			$content .="</players>"; 
		
			
			fwrite($file_handle,$content); 
			fclose($file_handle);
?>