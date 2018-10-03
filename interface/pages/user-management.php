<?php
	require_once __DIR__.'/../../data/data_access/roleDAO.php';
	require_once __DIR__.'/../../data/data_access/userDAO.php';
	require_once __DIR__.'/../../data/data_controllers/user_management_controller.php';

	$user_management_controller = new user_management_controller();
	$user_management_controller->do_action();
	
	$userDao = new userDAO();
	$this_user = $userDao->get_by_username($_SESSION["username"]);

	$roleDao = new roleDAO();
	$roles = $roleDao->get_all();

	$helper = new helpers();	
	$id = 1;
	
	$max_records = 5;
	
	if(isset($_GET["page"])){
		$page_number = $_GET["page"];
		$from = ($page_number*$max_records)-$max_records;
					
	}
	else{
		$from = 0;
	}
	if(isset($_GET["search"])){
		$users = $userDao->get_by_param_in_range($_GET["search-input"],$from,$max_records);
		$users_count = $userDao->count_by_param($_GET["search-input"]);
		
	}
	else{		
		
		$users = $userDao->get_all();
		$users_count = count($users);
		$users = $userDao->get_in_range($from,$max_records);
		
	}
	$pages_count = ceil($users_count/$max_records);
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>User management</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/library-icon.ico" />
		<link rel="stylesheet" href="../styles/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../styles/bootstrap-nav-fix.css" />
		<link rel="stylesheet" href="../styles/bootstrap-form-fix.css" />
		<link rel="stylesheet" href="../styles/bootstrap-table-fix.css" />
		<link rel="stylesheet" href="../styles/modal.css" />
		<link rel="stylesheet" href="../styles/page.css" />
		<link rel="stylesheet" href="../styles/footer.css" />
	</head>
	<body>
		<nav class="navbar navbar-expand-lg nav-fix sticky-top navbar-light bg-light">
			<a class="navbar-brand" href="javascript:void(0);"><div class="nav-logo-wrap"><div class="nav-logo"></div> <span class="nav-text">E-LIBRARY</span></div> </a>
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/project/interface/pages/user-profile.php">My profile</a>
				</li>
				<!--There are only admin options on this page, because only admin can access this page-->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle active" href="javascript:void(0);" id="navbarAdminDropdown" role="button" data-toggle="dropdown">
						Admin options
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/project/interface/pages/address-management.php">Manage addresses</a>
						<a class="dropdown-item" href="/project/interface/pages/category-management.php">Manage categories</a>
						<a class="dropdown-item" href="/project/interface/pages/genre-management.php">Manage genres</a>
						<a class="dropdown-item active" href="/project/interface/pages/user-management.php">Manage users</a>
					</div>
				</li>
				
				
				<li class="nav-item">
					<form id="logout" method="get" action="">
						<input type="hidden" name="logout" value="logout" /> 
						<a class="nav-link" href="javascript:void(0);" onclick="document.getElementById('logout').submit();">Log out</a>
					</form>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0" method="get" onsubmit="return false;">
				<input class="form-control mr-sm-2" id="search-input" type="search" name="search-input" placeholder="Search user by name">
				<button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="do_search('user-management.php','search-input');" name="search" value="search">Search</button>
			</form>
			
		</div>
	</nav>

	<!--Page body-->
	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul id="tabs">
				<li  id="tab-1" onclick="show_selected_view(this);" class="active-tab"><a href="javascript:void(0);">Available users</a></li>
			</ul>
			</div>
			<div id="views">
				<div id="tab1-view" >
			
					<div id="datagrid" class="table-container">
						<table id="table" class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Firstname</th>
									<th scope="col">Lastname</th>
									<th scope="col">Date of birth</th>
									<th scope="col">E-mail</th>
									<th scope="col">Username</th>
									<th scope="col">Approved</th>
									<th scope="col">Status</th>
									<th scope="col">Role</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($users as $user){ 
									
								?>
									<tr id="<?php echo $user->get_id_user(); ?>" data-toggle="modal" data-target="#userEditModal" onclick="setModalValues('userEditModal',this,'<?php echo $this_user->get_username(); ?>','<?php echo $this_user->get_role()->get_role_title(); ?>');">
										<th scope="row"><?php echo $id?></th>
										<td><?php echo $user->get_firstname(); ?></td>
										<td><?php echo $user->get_lastname(); ?></td>
										<td><?php echo $user->get_date_of_birth(); ?></td>
										<td><?php echo $user->get_e_mail(); ?></td>
										<td><?php echo $user->get_username(); ?></td>
										<td><?php echo $helper->get_approval_text($user->get_approval()); ?></td>
										<td><?php echo $helper->get_status_text($user->get_status()); ?></td>
										<td><?php echo $user->get_role()->get_role_title(); ?></td>
										
									</tr>
								<?php	$id = $id + 1; 
								} 
								?>
							</tbody>
						</table>
						<div id="table-nums" class="table-nums"><?php
							$i = 1;
							echo "<span>";
							while($i <= $pages_count){
								echo "<a id='a".$i."' "; 
								if(isset($_GET["page"])){ 
									if($i==$_GET["page"]){ 
										echo "class=page-active" ;
									} 
								} 
								else{ 
									if($i==1){ 
										echo "class=page-active";
									}
									else{
										echo "class=page";	
									}
								}
								if(!isset($_GET["search"])){ 
									echo " onclick=mark_page_as_active('table-nums',this);change_page('user-management.php',{$i},null,null);";
								} 
								else{
									echo " onclick=mark_page_as_active('table-nums',this);change_page('user-management.php',{$i},'{$_GET["search-input"]}','search');"; 
								}
								echo ' href="javascript:void(0);">'.$i; 
								$i = $i+1; ?>
								</a><?php
							}
							?>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="userEditModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="userEditLabel">Edit user</h4>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="user-form-wrap">
						<div class="genre-form-section">
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="user-id-edit-input">User id</label>
								<div class="col-sm-10 user-col-fix">
									<input type="text" class="form-control" id="user-id-edit-input" name="user-id-edit-input">
									<span></span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="role-select">Role</label>
								<div class="col-sm-10 user-col-fix">
									<select class="form-control" id="role-select" name="role-select" >										<?php foreach($roles as $role){ ?>
											<option value="<?php echo $role->get_id_role(); ?>"> <?php echo $role->get_role_title(); ?></option>
											<?php } ?>
									</select>
									<span></span>
								</div>
							</div>
							<div class="form-check inline-check">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox">
										<input type="checkbox" class="form-check-input" id="approved-check" onclick="changeCheckValue(this);">
										<label class="form-check-label" for="approved-check">Approve</label>
									</div>
								</div>
							</div>
							<div class="form-check inline-check">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox">
										<input type="checkbox" class="form-check-input" id="active-check" onclick="changeCheckValue(this);">
										<label class="form-check-label" for="active-check">Active</label>
									</div>
								</div>
							</div>	
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" onclick="deleteData('userEditModal','user-management.php');" class="btn btn-danger" data-dismiss="modal">Delete</button>
					<button type="button" onclick="sendUpdatedUserData('userEditModal');" class="btn btn-primary" data-dismiss="modal">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="footer-container">
		<div class="row text-center text-xs-center text-sm-left text-md-left justify">
			<div class="col-xs-12 col-sm-4 col-md-4 links">
				<h5>Quick links</h5>
				<ul class="list-unstyled quick-links">
					<li><a href="/project/interface/pages/user-profile.php">Home</a></li>
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
	<script src="../scripts/page.js"></script>
	<script src="../scripts/user-management-script.js"></script>
</body>
</html>
