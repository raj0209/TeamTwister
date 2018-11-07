<!doctype html>
<?php include_once("includer.php");
$register = "";
$error_message = "";
 ?>
 <html class="no-js" lang="en"> 
<head>
   <meta charset="utf-8" />
   <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
   <!-- Mobile viewport optimized: h5bp.com/viewport -->
   <meta name="viewport" content="width=device-width">
<?php include("analyticstracking.php"); ?>
   

 
    <link rel="shortcut icon" href="images/teamtwister.ico" type="image/ico" />
   
  
   <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" type="text/css" href="content/css/yashness.css">
   <link rel="stylesheet" type="text/css" href="content/css/yashness-responsive.css"> 
   <link rel="stylesheet" type="text/css" href="content/css/yashmetro.css">
   <link rel="stylesheet" type="text/css" href="content/css/yashmetro-tiles.css">
  
   <link rel="stylesheet" type="text/css" href="content/css/metro-ui-light.css">
   <link rel="stylesheet" type="text/css" href="content/css/icomoon.css">

   <!--  these two css are to use only for documentation -->
   <link rel="stylesheet" type="text/css" href="content/css/demo.css">
   <link rel="stylesheet" type="text/css" href="scripts/google-code-prettify/prettify.css" >
   <meta name="description" content="Synapse DA-IICT presents...... A contest ( based on real cricket matches ) just for you. Make your team which you think is better than the rest and compete in a series of exciting levels." />
		<meta name="keywords" content="DAIICT, DA-IICT, Gandhinagar, Annual Event, windows8, windows 8,metro,  yash shah, synapse, daiict, destiny hacker, destiny, hacker, yashness.com, yashness" />
		<meta name="author" content="ya.shness">
		<meta name="robots" content="index, follow" />


   <!-- Le fav and touch icons -->

  
  <title>Synapse 2013 presents Team Twister</title>	
  
   <script src="scripts/modernizr-2.6.1.min.js"></script>
	<style>
		html,body { background:#0b0b0b; 
		/* background :url("images/cricket.jpg") no-repeat center center fixed;
		
-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover; */
		}
		.mystyle {color:white; }
	</style>

</head>

<body data-accent="blue" >




			<div id="myModal3" class="modal warning bg-color-blu hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-body">
                   <p><?php echo $_GET['error_message'];?></p>
				   <p><?php echo "Please try again... or contact Coordinators"; ?></p>
				   
                </div>
                <div class="modal-footer">
                   <button class="btn btn-large" data-dismiss="modal">Close</button>
                </div>
            </div>
	
						
   <header id="hero" class="">
		<div class="container">
			<div class="row">
			<div class="span2">
				<center><span class="text-info" style="font-family:'Times new roman'; line-height:23px; font-size:20px; color:orange;">Sponsored by </span></center>
				<a target="_blank" href="http://a1technologies.in/index-2.html" alt="A1 Technologies"><img src="images/sponsorlogo.jpg" alt="A1 Technologies"></img></a>
			</div>
			<div class="span8">
				<center>
				<?php 
		if(isset($_GET['register'])) {
			if($_GET['register']==0){ 
					echo "<h4 class=\"text-error\">Error Occured in Signup. <a  type=\"button\" data-toggle=\"modal\" href=\"#myModal3\" >Click</a> to see it.</h4></br>"; 
			} else if($_GET['register']==1){
					echo "<h4 class=\"text-info\"><span class=\"text-success\"> Yoo! </span> Successfull Signed Up !! </h4></br>";
			} 
		} 					
	?>
						<div class="btn-group">
							<a class="btn btn-primary" href="index.php">Home</a>
						</div>
						<div class="btn-group">
							<a class="btn btn-info"   href="rules.php">Rules</a>
						</div>
						<div class="btn-group">
							<a class="btn btn-warning" href="#ranks" data-toggle="modal">Ranks</a>
						</div>
						
						<?php
						if(chkLogin()){
							echo "<div class=\"btn-group\">
							<a class=\"btn btn-danger btn-large\" href=\"createteam.php\">Create team</a>
						</div>";
							
						}
						else{
							echo "<div class=\"btn-group\">
							<a class=\"btn btn-danger\" href=\"#myModal\" data-toggle=\"modal\">Sign Up</a>
						</div>";
						}
						?>						
						<div class="btn-group">
							<a class="btn mystyle" style="background:olive; border:solid olive 2.5px; border-left:none;" href="#contacts" data-toggle="modal">Contact Us</a>
							
						</div>
						<?php
						if(chkLogin()){
							echo "<div class=\"btn-group\">
							<a class=\"btn \" style=\"background-color:#A30A68; color:white; border:solid #A30A68 2.5px;\" href=\"logout.php\">Logout</a>
						</div>";
						}
						?>		
						<!-- <div class="btn-group">
							<a class="btn btn-success" href="#livescore" data-toggle="modal">Live Score</a>
						</div> -->
						<div class="btn-group">
							<a class="btn btn-success" href="#sponsor" data-toggle="modal">Sponsor</a>
						</div>
				</center>
			</div>
			<div class="span2">
			
			</div>
				<div id="top-info" class="pull-left">
					<?php 
					if(chkLogin()){
						echo"
							<a href=\"#\" class=\"\">
								<div class=\"top-info-block\">";
							   
							 
								echo "<h3 style=\"color:#F0F043;\">".htmlentities($_SESSION['username'])."</h3>";
								$score = getScoreName($_SESSION['username']);
								echo "<p style=\"color:#fff;\">Your score: ". $score ."</p>";
								echo "
									</div>
									<div class=\"top-info-block\">
									   <b class=\"icon-user\"></b>
									</div>
								</a>
								 <hr class=\"separator pull-left\"/>
								 <a id=\"settings\" class=\"pull-left\" href=\"settings.php\" >
									<b class=\"icon-settings\"></b>
								 </a>";
							} 
					?>
				</div>
			
			</div>
		</div>
   </header>
 
		<div class="modal hide fade" id="myModal" aria-hidden="true">
			<?php include("signupform.php"); ?>
			
						
			
		</div>
		
		
		<div class="modal hide fade" id="contacts" aria-hidden="true">
		<div ></br>
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#coordinators" data-toggle="tab">Coordinators</a></li>
              <li><a href="#developers" data-toggle="tab">Developers</a></li>
           
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active" id="coordinators">
               <div class="modal-body">
				<div >
				<ul class="thumbnails">
					<li class="span2">
						<a target="_blank" href="http://www.facebook.com/yash.yashness" class="thumbnail">
						<img src="images/yashness2.jpg" alt="">
					 </a>
					</li>
					<li class="span2">
						<a target="_blank" href="https://www.facebook.com/buddhdev.raj" class="thumbnail">
						<img src="images/raj.png" alt="">
					 </a>
					</li>
					<li class="span2">
						<a target="_blank" href="https://www.facebook.com/shubhanshu.gupta.982" class="thumbnail">
						<img src="images/shubhanshu.png" alt="">
					 </a>
					</li>
				</ul>
				</div>
				<div style="width:620px;">
				<div class="span2 pull-left">
					<h3 class="pull-left">Yash Shah</h3>
					</br>
					<h5>8401035423</h5>
				</div>
				<div class="span2">
					<h3 class="pull-left">Raj Buddhdev</h3>
					</br>
					<h5>7359309891</h5>
				</div>
				<div class="span2">
					<h3 class="pull-left">Shubhanshu</h3>
					</br>
					<h5>7359473626</h5>
				</div>
				</div>
			</div>
              </div>
              <div class="tab-pane fade" id="developers">
			  <div class="row">
				<a target="_blank" href="http://www.facebook.com/buddhdev.raj"><img class="span1 thumbnail" src="images/raj.png" alt="Raj BuddhDev"></img></a>
				<span class="span1"><strong>Raj Buddhdev</strong>, Database Management</span>
                <a target="_blank" href="http://www.facebook.com/yash.yashness"><img class="span1 thumbnail" src="images/yashness.jpg" alt="Yash Shah"></img></a>
				<span class="span1"><strong>Yash Shah</strong>, Front End Development</span>
                <a target="_blank" href="http://www.facebook.com/vaibhavid1"><img class="span1 thumbnail" src="images/vaibhavi.jpg" alt="Yash Shah"></img></a>
				<span class="span1"><strong>Vaibhavi Desai</strong>,</br>Logo and Designing</span>
              </div>
              </div>
				</br>
				</br>
			
			  </div>
		</div>
		
		
		</div>
		
		</div>
		<div class="span6">
			<div class="modal hide fade" id="ranks" aria-hidden="true">
				<div class="modal-header">
					<center><h2><span>Ranks</span></h2></center>
				</div>
				<div class="modal-body">
					<?php $rankSet=mysql_query("SELECT username, totalScore FROM teamtwisterscores ORDER BY totalScore DESC");
						  confirmQuery($rankSet);?>
					<table class="table span6 pull-right table-hover table-condensed">
					<thead>
						<tr>
							<th >Rank</th>
							<th >Name</th>
							<th >Points</th>
							
						</tr>
					</thead>
					<tbody>
					<?php 
						$pos=1;
						while($rank=mysql_fetch_array($rankSet)){
							echo "<tr ";
							echo " ><td>{$pos}</td><td>".htmlentities($rank[0])."</td><td>".htmlentities($rank[1])."</td></tr>";
							$pos++;
						}
					?>
					</tbody>
					</table>
				</div>
			</div>	
			<div class="modal hide fade" id="sponsor" aria-hidden="true">
				</br>
				
				<div class="modal-body">
					<a target="_blank" href="http://a1technologies.in/index-2.html" ><img src="images/sponsorlogo.jpg" alt="A1Technology"></img>
										</a>
										</br>
										
										</br>
					<p style="font-size:16px; color:black;">A1 Technologies is an Authorised Distributor for whole Gujarat and Franchisee Store for a variety of California Based Luxury T.V. Brand.</p>
					</br>
					<p style="font-size:16px; color:black;">Company is manned by a dedicated team of young and motivated personnel. The team is under the dynamic leadership of its whole time Directors, Mr. Harshad N. Patel and Mr. Jitendra N. Patel.</p>
					</br>
					<hr>
<div class="clearfix"></div>		
		<a target="_blank" href="http://a1sureja.in/" ><img src="images/sureja.jpg" alt="A1Sureja"></img>
										</a>
										</br>
										
										</br>
					<p style="font-size:16px; color:black;">A1 Sureja Industries has become a global leader due to its long-standing expertise which delivers unique opportunities in untapped areas and distinctive solutions. It has maintained leadership in its area of operations by providing innovative solutions and future-ready products to ever-widening base of global clients. A1 Sureja Industries is committed to provide low cost-high quality allied products while preserving & protecting natural resources and the environment.</p>
					</br>
		</div>
			</div>
		</div>
			<div class="modal2 hide fade" style="" id="livescore" aria-hidden="true">
				<div class="modal-header">
					<center><h2><span>Live Score</span></h2></center>
				</div>
				<div class="modal-body">
					<!-- <script language="JavaScript" type="text/JavaScript" src="http://ifeed.vcricket.com/get_codeEx.aspx?dk=FB19D1D98EA74646B2442F65EB280BA7&amp;sc=&amp;sz=180x320&amp;lang=en"></script><noscript><a href="http://www.vcricket.com/help.aspx?q=java_disable"  target="_blank"><img src="htt://www.vcricket.com/images/error_java_180x320.gif"  alt="Javascript is disabled." width="180" height="320" border="0" /></a><div style="font-size:8px; padding-left:10px"><a href="http://www.vcricket.com/">vCricket.com</a></div></noscript><!-- Please note this will not work if directly run in browser. -->	
				</div>
			</div>
		
		
	
		<div id="fb-root">
		</div>
			<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
   </br> </br>