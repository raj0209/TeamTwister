
<div class="row">


<?php include("header.php"); ?>


	</br>
  <div class="container-fluid">  
	<div class="row-fluid" style="padding-top:0px;">
		<aside class="span3">
			</br>
			<?php if(!chklogin()) { include("loginform.php"); 
				} else { 			
				include("topthree.php"); 
				}
			?>
			<h4 style="color:white;">
			<strong>Updates:
			</br></h4>
			<h5 style="color:white;">
			Website will be disabled from 11pm(2nd Mar) to 3am(3rd Mar)
			</br></br>
			Website will be enabled from 3am(3rd Mar) to 5.30pm(3rd Mar)
			</h5></strong>
		</aside>
		<div class="span6">
		
		<?php include("welcome.php"); ?>
		</div>
		<?php include("matches.php"); ?>
	</div>
</div>
</div>

<?php include("footer.php"); ?>
