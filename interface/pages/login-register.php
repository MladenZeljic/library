<!DOCTYPE HTML>

<?php
	
	require_once __DIR__.'/../../data/data_controllers/login_register_controller.php';
	
	$login_register_controller = new login_register_controller();
	$login_register_controller->do_action();
	
	$helper = new helpers();
?>

<html>
<head>
	<title>Sign in/sign up</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/library-icon.ico" />
	<link rel="stylesheet" href="../styles/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../styles/login-register.css" />
	<link rel="stylesheet" href="../styles/bootstrap-form-fix.css" />
</head>
<body>
	<div id="login-form" class="login-form-wrap">
		<div class="form-box">
			<form class="login-form" method="post" onsubmit="return validate_form(this);" action="">
				<div class="form-group"><div class="col-sm-offset-2 col-sm-10 form-title">Log in</div></div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="log-username-input">Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="log-username-input" name="log-username-input" placeholder="Enter your username" value=<?php echo $helper->print_request_value("log-username-input","post");?>>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="log-password-input">Password</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="log-password-input" name="log-password-input" placeholder="Enter your password" value=<?php echo $helper->print_request_value("log-password-input","post");?>>
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
						<button type="submit" class="btn btn-primary form-button" name="login" value="login">Log in</button>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-10 center-link">
					<span><small onclick="fade_element('login-form','register-form')">You can also register</small> <small><a class="go-back" href="../../index.php">Go back</a></small></span>
				</div>
			</form>
		</div>
	</div>
	<div id="register-form" class="register-form-wrap form-hide">
		<div class="form-box">
			<form class="register-form" method="post" onsubmit="return validate_form(this);" action="">
				<div class="form-group"><div class="col-sm-offset-2 col-sm-10 form-title">Register</div></div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-fix" for="first-input">First name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="firstname-input" name="firstname-input" placeholder="Enter your first name" value=<?php echo $helper->print_request_value("firstname-input","post");?>>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-fix" for="lastname-input">Last name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="lastname-input" name="lastname-input" placeholder="Enter your last name" value=<?php echo $helper->print_request_value("lastname-input","post");?>>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-fix" for="date-of-birth-input">Date of birth</label>
					<div class="col-sm-10">
						<input type="date" class="form-control" id="date-of-birth-input" name="date-of-birth-input" placeholder="Enter your date of birth" value=<?php echo $helper->print_request_value("date-of-birth-input","post");?>>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-fix" for="email-input">E-mail</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="email-input" name="email-input" placeholder="Enter your e-mail" value=<?php echo $helper->print_request_value("email-input","post");?>>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="username-input">Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="username-input" name="username-input" placeholder="Enter your username" value=<?php echo $helper->print_request_value("username-input","post");?>>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="password-input">Password</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="password-input" name="password-input" placeholder="Enter your password" value=<?php echo $helper->print_request_value("password-input","post");?>>
					</div>
				</div>
				<div class="form-group">        
					<div class="col-sm-offset-2 col-sm-10 form-button-wrap">
						<button type="submit" class="btn btn-primary form-button" name="register" value="register">Register</button>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-10 center-link">
					<span class="action-link"><small onclick="fade_element('register-form','login-form')">Already have an account? </small> <small> <a class="go-back" href="../../index.php">Go back</a></small></span>
					
				</div>
			</form>
		</div>
	</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="../scripts/js/bootstrap.min.js"></script>
	<script src="../scripts/index.js"></script>

</body>
</html>
