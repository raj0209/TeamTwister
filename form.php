
<form class="form" action="./index.php" method="post">
				<span class="label label-info"><h2 style="color:white">Sign In</h2> </span></br></br>
						<?php if(isset($_GET['logout']) && $_GET['logout']==1){
							echo "<p class=\"text-success\"><i>You have successfully logged out</i></p>";
							unset($_GET['logout']);
						}
						if(isset($error_message) && !empty($error_message)){
							echo "<p class=\"text-warning\"><i>" .htmlentities($error_message). "</i></p>";
						} ?>
				 <div class="control-group">
				   <div class="controls">
					 <input type="text" id="inputEmail" name="username" placeholder="Username" autofocus>
				   </div>
				 </div>
				 <div class="control-group">
				   <div class="controls">
					 <input type="password" id="inputPassword" name="password" placeholder="Password">
				   </div>
				 </div>
				 <div class="control-group">
				   <div class="controls">
					 <label class="checkbox">
					   <input type="checkbox"><span class="metro-checkbox text-warning">Remember</span>
					 </label>
					 <button type="submit" name="submit" class="btn">Login</button>
				   </div>
				 </div>
</form>
