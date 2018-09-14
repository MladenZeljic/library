<?php
	require_once __DIR__.'/../../data/data_access/userDAO.php';
	require_once __DIR__.'/../../data/data_controllers/admin_manager_controller.php';

	$admin_manager_controller = new admin_manager_controller();
	$admin_manager_controller->do_action();
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>User profile</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/library-icon.ico" />
		<link rel="stylesheet" href="../styles/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../styles/bootstrap-nav-fix.css" />
		<link rel="stylesheet" href="../styles/admin-manager.css" />
		<link rel="stylesheet" href="../styles/bootstrap-form-fix.css" />
	</head>
	<body>
		<nav class="navbar navbar-expand-lg nav-fix sticky-top navbar-light bg-light">
			<a class="navbar-brand" href="#"><div class="nav-logo-wrap"><div class="nav-logo"></div> <span class="nav-text">E-LIBRARY</span></div> </a>
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="#">My profile<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarAdminDropdown" role="button" data-toggle="dropdown">
						Admin options
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Manage categories</a>
						<a class="dropdown-item" href="#">Manage genres</a>
						<a class="dropdown-item" href="#">Manage users</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarLibraryDropdown" role="button" data-toggle="dropdown">
						Library options
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Manage authors</a>
						<a class="dropdown-item" href="#">Manage books</a>
						<a class="dropdown-item" href="#">Manage book lendings</a>
						<a class="dropdown-item" href="#">Manage members</a>	
						<a class="dropdown-item" href="#">Manage publishers</a>
					</div>
				</li>
				<li class="nav-item">
					<form id="logout" method="post" action="">
						<input type="hidden" name="logout" value="logout" /> 
						<a class="nav-link" href="#" onclick="document.getElementById('logout').submit();">Log out</a>
					</form>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</nav>
	
	<!--Page body-->
	<div class="page-body-wrap">
		<div class="page-body">
			<div id="user-form" class="user-form-wrap">
				<form class="user-form" method="post" action="">
					<div class="form-group"><div class="col-sm-offset-2 col-sm-10 form-title form-title-fix">My info</div></div>
					<div class="form-section left-section">
						<div class="form-group">
							<label class="control-label col-sm-2 user-col-fix" for="first-input">First name</label>
							<div class="col-sm-10 user-col-fix">
								<input type="text" class="form-control" id="firstname-input" name="firstname-input" placeholder="Enter your first name" value="<?php echo $user->get_firstname(); ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 user-col-fix" for="lastname-input">Last name</label>
							<div class="col-sm-10 user-col-fix">
								<input type="text" class="form-control" id="lastname-input" name="lastname-input" placeholder="Enter your last name" value="<?php echo $user->get_lastname(); ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 user-col-fix" for="date-of-birth-input">Date of birth</label>
							<div class="col-sm-10 user-col-fix">
								<input type="date" class="form-control" id="date-of-birth-input" name="date-of-birth-input" placeholder="Enter your date of birth" value="<?php echo $user->get_date_of_birth(); ?>">
							</div>
						</div>
					</div>
					<div class="form-section">
						<div class="form-group">
							<label class="control-label col-sm-2 user-col-fix" for="email-input">E-mail</label>
							<div class="col-sm-10 user-col-fix">
								<input type="email" class="form-control" id="email-input" name="email-input" placeholder="Enter your e-mail" value="<?php echo $user->get_e_mail();?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 user-col-fix" for="username-input">Username</label>
							<div class="col-sm-10 user-col-fix">
								<input type="text" class="form-control" id="username-input" name="username-input" placeholder="Enter your username" value="<?php echo $user->get_username(); ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 user-col-fix" for="password-input">Password</label>
							<div class="col-sm-10 user-col-fix">
								<input type="password" class="form-control" id="password-input" name="password-input" placeholder="Enter your new password" >
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div class="form-group">        
						<div class="col-sm-offset-2 col-sm-10 user-form-button-wrap">
							<button type="submit" class="btn btn-primary form-button" name="save" value="save">Save</button>
						</div>
					</div>
					
				</form>
			</div>
		</div>
				
		
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>
