<!DOCTYPE HTML>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="resources/images/library-icon.ico" />
	<link rel="stylesheet" href="interface/styles/css/bootstrap.min.css" />
	<link rel="stylesheet" href="interface/styles/index.css" />
</head>
<body>
	<div id="login-form" class="login-form-wrap">
		<div class="form-box">
			<form class="login-form" method="post" action="#">
				<div class="form-group"><div class="col-sm-offset-2 col-sm-10 form-title">Log in</div></div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="log-username-input">Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="log-username-input" placeholder="Enter your username">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="log-password-input">Password</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="log-password-input" placeholder="Enter your password">
					</div>
				</div>
				<div class="form-check">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<input type="checkbox" class="form-check-input" id="password-check" onclick="show_password()">
							<label class="form-check-label" for="password-check">Show your password</label>
						</div>
					</div>
				</div>
				<div class="form-group">        
					<div class="col-sm-offset-2 col-sm-10 form-button-wrap">
						<button type="submit" class="btn btn-primary form-button">Log in</button>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-10 center-link">
					<p onclick="fade_login()"><small>You can also register</small></p>
				</div>
			</form>
		</div>
	</div>
	<div id="register-form" class="register-form-wrap form-hide">
		<div class="form-box">
			<form  class="register-form" method="post" action="#">
				<div class="form-group"><div class="col-sm-offset-2 col-sm-10 form-title">Register</div></div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-fix" for="first-input">First name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="firstname-input" placeholder="Enter your first name">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-fix" for="lastname-input">Last name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="lastname-input" placeholder="Enter your last name">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-fix" for="date-of-birth-input">Date of birth</label>
					<div class="col-sm-10">
						<input type="date" class="form-control" id="date-of-birth-input" placeholder="Enter your date of birth">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="email-input">E-mail</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="email-input" placeholder="Enter your e-mail">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="username-input">Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="username-input" placeholder="Enter your username">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="password-input">Password</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="password-input" placeholder="Enter your password">
					</div>
				</div>
				<div class="form-group">        
					<div class="col-sm-offset-2 col-sm-10 form-button-wrap">
						<button type="submit" class="btn btn-primary form-button">Register</button>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-10 center-link">
					<p onclick="fade_register()"><small>Already have an account?</small></p>
				</div>
			</form>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="interface/scripts/js/bootstrap.min.js"></script>
	<script src="interface/scripts/index.js"></script>

</body>
</html>

<?php

?>
