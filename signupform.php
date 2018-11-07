<div class="modal-header">
	<center><h2> Signup for Teamtwister </h2></center>
</div>
<div class="modal-body span6">
	<form class="form row" name="create" action="signupcheck.php" method="post">
		<div class="span3">
					 <div class="control-group">
					   <div class="controls">
						 <input type="text" name="username" placeholder="Username" autofocus required>
					   </div>
					 </div>
					 <div class="control-group">
					   <div class="controls">
						 <input type="email" name="emailid" placeholder="Email ID" required>
					   </div>
					 </div>
					 <div class="control-group">
					   <div class="controls">
						 <input type="password" name="password" placeholder="Password" required>
					   </div>
					 </div>
		</div>
		<div class="span3">
					 <div class="control-group">
					   <div class="controls">
						 <input type="password" name="conPassword" placeholder="Confirm Password" required>
					   </div>
					 </div>
					
					 <div class="control-group">
					   <div class="controls">
						 <input type="text" pattern="^[0-9]{10}$" name="contactNo" placeholder="10 digit Contact Number" required>
					   </div>
					 </div>
					<select name="college">
						<option value="da-iict" selected="selected">da-iict</option>
						<option value="other">other</option>
					</select>
		</div>
		<div class="clear-fix"></div>
		</br>
		<div class="row">
					 <div class="control-group">
					   <div class="controls">
						 <button type="submit" name="register" class="btn btn-primary span6">Register</button>
					   </div>
					 </div>
		</div>
		</center>
	</form>
</div>
<div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>