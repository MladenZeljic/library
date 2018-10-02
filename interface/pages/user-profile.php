<?php
	require_once __DIR__.'/../../data/data_access/userDAO.php';
	require_once __DIR__.'/../../data/data_controllers/user_profile_controller.php';

	$user_profile_controller = new user_profile_controller();
	$user_profile_controller->do_action();
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	$helper = new helpers();	
	$memberDao = new memberDAO();
	$member = $memberDao->get_by_user($user);
	$addressDao = new addressDAO();
	$addresses = $addressDao->get_all();	
	
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
		<link rel="stylesheet" href="../styles/user-profile.css" />
		<link rel="stylesheet" href="../styles/bootstrap-form-fix.css" />
		<link rel="stylesheet" href="../styles/page.css" />
		<link rel="stylesheet" href="../styles/footer.css" />
	</head>
	<body>
		<nav class="navbar navbar-expand-lg nav-fix sticky-top navbar-light bg-light">
			<a class="navbar-brand" href="javascript:void(0);"><div class="nav-logo-wrap"><div class="nav-logo"></div> <span class="nav-text">E-LIBRARY</span></div> </a>
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="/project/interface/pages/user-profile.php">My profile<span class="sr-only">(current)</span></a>
				</li>
				<?php if($user->get_role()->get_role_title() === 'administrator' ){?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarAdminDropdown" role="button" data-toggle="dropdown">
						Admin options
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/project/interface/pages/address-management.php">Manage addresses</a>
						<a class="dropdown-item" href="/project/interface/pages/category-management.php">Manage categories</a>
						<a class="dropdown-item" href="/project/interface/pages/genre-management.php">Manage genres</a>
						<a class="dropdown-item" href="/project/interface/pages/user-management.php">Manage users</a>
					</div>
				</li>
				<?php
				}
				?>
				<?php if($user->get_role()->get_role_title() === 'librarian' ){?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarLibraryDropdown" role="button" data-toggle="dropdown">
						Library options 
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/project/interface/pages/author-management.php">Manage authors</a>
						<a class="dropdown-item" href="/project/interface/pages/book-management.php">Manage books</a>
						<a class="dropdown-item" href="/project/interface/pages/book-copy-management.php">Manage book copies</a>					<a class="dropdown-item" href="/project/interface/pages/book-lendings-management.php">Manage book lendings</a>
						<a class="dropdown-item" href="/project/interface/pages/membership-management.php">Manage members</a>	
						<a class="dropdown-item" href="/project/interface/pages/publisher-management.php">Manage publishers</a>
					</div>
				</li>
				<?php } ?>
				<?php if($user->get_role()->get_role_title() === 'user' and $helper->is_member($_SESSION["username"]) ){?>
				<li class="nav-item">
					<a class="nav-link" href="/project/interface/pages/user-book.php">My books </a>
				</li>
				<?php } ?>
				<li class="nav-item">
					<form id="logout" method="get" action="">
						<input type="hidden" name="logout" value="logout" /> 
						<a class="nav-link" href="javascript:void(0);" onclick="document.getElementById('logout').submit();">Log out</a>
					</form>
				</li>
			</ul>
			
		</div>
	</nav>
	
	<!--Page body-->
	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul id="tabs">
				<li id="tab-1" onclick="show_selected_view(this);" class="active-tab"><a href="javascript:void(0);">My info</a></li>
				<?php if($user->get_role()->get_role_title() === 'user' and $helper->is_member($_SESSION["username"]) ){?>
				<li id="tab-2" onclick="show_selected_view(this);"><a href="javascript:void(0);">My membership</a></li>
				<?php } ?>
			<ul>
			</div>
			<div id="views">
				<div id="tab1-view" >
					<div id="user-form" class="user-form-wrap">
						<form class="user-form" method="post" action="">
							
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
										<input type="email" class="form-control" id="email-input" name="email-input" placeholder="Enter your e-mail" value="<?php echo $user->get_e_mail();?>" readonly>
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
									<button type="submit" class="btn btn-primary form-button" name="save" value="save-user">Save</button>
								</div>
							</div>
							
						</form>
					</div>
				</div>
				<?php if($user->get_role()->get_role_title() === 'user' and $helper->is_member($_SESSION["username"]) ){?>
				<div id="tab2-view"  class="tab-view-hide" >
					<div id="member-form" class="user-form-wrap">
						<form class="user-form" method="post" action="">
							
							<div class="form-section left-section">
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="phone-input">Phone number</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="phone-input" name="phone-input" placeholder="Enter your phone number" value="<?php echo $member->get_member_phone(); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="mobile-input">Mobile number</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="mobile-input" name="mobile-input" placeholder="Enter your mobile phone number" value="<?php echo $member->get_member_mobile(); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="member-from-input">Member from</label>
									<div class="col-sm-10 user-col-fix">
										<input type="date" class="form-control" id="member-from-input" name="member-from-input" value="<?php echo $member->get_member_from(); ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="member-to-input">Member to</label>
									<div class="col-sm-10 user-col-fix">
										<input type="date" class="form-control" id="member-to-input" name="member-to-input" value="<?php echo $member->get_member_to(); ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="penality-input">Penality points</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="penality-input" name="penality-input" value="<?php echo $member->get_penality_points(); ?>" readonly>
									</div>
								</div>
								
							</div>
							<div class="form-section">
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="address-select">Select address:</label>					<div class="col-sm-10 user-col-fix">
										<select class="form-control" id="address-select" name="address-select">
											<?php foreach($addresses as $address){ ?>
											<option value="<?php echo $address->get_id_address();?>" <?php if($address->get_zip_code() === $member->get_member_address()->get_zip_code()){ ?> selected <?php } ?>><?php echo $address->get_street_address()." ".$address->get_zip_code()." ".$address->get_city(); ?></option>
											<?php } ?>
										</select>
									</div>
								</div> 
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="notes-input">Notes:</label>
									<div class="col-sm-10 user-col-fix">
										<textarea maxlength="300" class="form-control notes" rows="5" id="notes-input" name="notes-input" onkeyup="setCharCount(this)"><?php echo $member->get_notes();?></textarea>
										<div id="count-container" ><span id="char-text">Characters left:</span><span id="chars-count"><?php $result = 300-strlen($member->get_notes()); echo $result; ?></span></div>
									</div>
								</div> 
							</div>
							<div class="clear"></div>
							<div class="form-group">        
								<div class="col-sm-offset-2 col-sm-10 user-form-button-wrap">
									<button type="submit" class="btn btn-primary form-button" name="save" value="save-member">Save</button>
								</div>
							</div>
							
						</form>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
				
		
	</div>
	<div class="footer-container">
		<div class="row text-center text-xs-center text-sm-left text-md-left justify">
			<div class="col-xs-12 col-sm-4 col-md-4 links">
				<h5>Quick links</h5>
				<ul class="list-unstyled quick-links">
					<li><a href="/project/interface/pages/admin-manager-profile.php">Home</a></li>
					<li>
						<form id="log-out" method="get" action="">
							<input type="hidden" name="log-out" value="logout" /> 
							<a href="javascript:void(0);" onclick="document.getElementById('log-out').submit();">
								Log out
							</a>
					</form>
					</li>
				</ul>
			</div>
			
			<div class="footer-logo-wrap  text-center text-xs-center text-sm-left text-md-left "><div class="footer-logo"></div><div class="footer-logo-text">E-LIBRARY</div></div> 
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center col-spacing">
				<p class="h6">&copy 2018 E-Library - All rights reversed</p>
			</div>
			</hr>
		</div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="../scripts/index.js"></script>

</body>
</html>
