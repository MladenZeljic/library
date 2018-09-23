<?php
	require_once __DIR__.'/../../data/data_access/userDAO.php';
	require_once __DIR__.'/../../data/data_controllers/address_management_controller.php';

	$address_management_controller = new address_management_controller();
	$address_management_controller->do_action();
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	$helper = new helpers();	
	$id = 1;
	
	$addressDao = new addressDAO();
	$max_records = 5;
	
	if(isset($_GET["page"])){
		$page_number = $_GET["page"];
		$from = ($page_number*$max_records)-$max_records;
					
	}
	else{
		$from = 0;
	}
	if(isset($_GET["search"])){
		$addresses = $addressDao->get_by_param_in_range($_GET["search-input"],$from,$max_records);
		$addresses_count = $addressDao->count_by_param($_GET["search-input"]);
		
	}
	else{		
		
		$addresses = $addressDao->get_all();
		$addresses_count = count($addresses);
		$addresses = $addressDao->get_in_range($from,$max_records);
		
	}
	$pages_count = ceil($addresses_count/$max_records);	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Address management</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/library-icon.ico" />
		<link rel="stylesheet" href="../styles/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../styles/bootstrap-nav-fix.css" />
		<link rel="stylesheet" href="../styles/admin-manager.css" />
		<link rel="stylesheet" href="../styles/bootstrap-form-fix.css" />
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
					<a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarAdminDropdown" role="button" data-toggle="dropdown">
						Admin options
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item active" href="/project/interface/pages/address-management.php">Manage addresses</a>
						<a class="dropdown-item" href="/project/interface/pages/category-management.php">Manage categories</a>
						<a class="dropdown-item" href="/project/interface/pages/genre-management.php">Manage genres</a>
						<a class="dropdown-item" href="/project/interface/pages/user-management.php">Manage users</a>
					</div>
				</li>
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
				<li  id="tab-1" onclick="show_selected_view(this);" class="available-tab <?php $helper->print_active_tab_class() ?>"><a href="javascript:void(0);">Add address</a></li>
				<li  id="tab-2" onclick="show_selected_view(this);" class="available-tab <?php $helper->print_active_tab_class(true) ?>"><a href="javascript:void(0);">Available addresses</a></li>
			<ul>
			</div>
			<div id="views">
				<div id="tab1-view" class="<?php $helper->print_hide_view_class(); ?>" >
				</div>
				<div id="tab2-view" class="<?php $helper->print_hide_view_class(true); ?>" >
			
					<div class="table-container">
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Street name</th>
									<th scope="col">Zip code</th>
									<th scope="col">City</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($addresses as $address){ 
									
								?>
									<tr>
										<th scope="row"><?php echo $id?></th>
										<td><?php echo $address->get_street_address(); ?></td>
										<td><?php echo $address->get_zip_code(); ?></td>
										<td><?php echo $address->get_city(); ?></td>
									
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
							}
							echo " onclick=mark_page_as_active('table-nums',this);"; 
							echo " href=address-management.php";
							if(!isset($_GET["search"])){ 
								echo "?page=".$i;
							} 
							else{ 
								echo "?page=".$i."&search-input=".$_GET["search-input"]."&search=search";
							}
							echo ">".$i; 
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