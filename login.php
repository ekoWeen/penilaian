<div class="col-sm-6">
    <div class="form-box">              
		<span class="glyphicon glyphicon-log-in"></span> 
			Log In
		</h3>
	</div>
	<div class="panel-body">
		<form role="form"  action ="proses_login.php" method="post" class="login-form">
			<div class="form-group">
				<label class="sr-only" for="username">Username</label>
				<input type="text" name="username" placeholder="Username..." class="form-username form-control" title="masukkan username" id="username" autofocus required="required">
			</div>
			<div class="form-group">
				<label class="sr-only" for="password">Password</label>
				<input type="password" name="password" placeholder="Password..." class="form-password form-control" title="masukkan password" id="password" required="required">
			</div>
			<button  type="submit" name="submit" class="btn btn-success btn-lg btn-block">Log In</button>
		</form>
	</div>
</div>