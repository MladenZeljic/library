<!DOCTYPE HTML>
<?php
	require_once __DIR__.'/../../data/data_access/userDAO.php';
	require_once __DIR__.'/../../data/data_access/authorDAO.php';
	require_once __DIR__.'/../../data/data_controllers/author_management_controller.php';

	$author_management_controller = new author_management_controller();
	$author_management_controller->do_action();
	$helper = new helpers();	
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	$id = 1;
	$current_page = 1;
	$authorDao = new authorDAO();
	$authors = $authorDao->get_all();
	
	$max_records = 5;
	
	if(isset($_GET["page"])){
		$page_number = $_GET["page"];
		$from = ($page_number*$max_records)-$max_records;
					
	}
	else{
		$from = 0;
	}
	if(isset($_GET["search"])){
		$authors = $authorDao->get_by_name_in_range($_GET["search-input"],$from,$max_records);
		$authors_count = $authorDao->count_by_name($_GET["search-input"]);
		
	}
	else{		
		
		$authors = $authorDao->get_all();
		$authors_count = count($authors);
		$authors = $authorDao->get_in_range($from,$max_records);
		
	}
	$pages_count = ceil($authors_count/$max_records);
	
?>
<html>
<head>
	<title>Author management</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/library-icon.ico" />
	<link rel="stylesheet" href="../styles/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../styles/bootstrap-nav-fix.css" />
	<link rel="stylesheet" href="../styles/author-management.css" />
	<link rel="stylesheet" href="../styles/bootstrap-form-fix.css" />
	<link rel="stylesheet" href="../styles/page.css" />
	<link rel="stylesheet" href="../styles/footer.css" />
</head>
<body>
	
	<nav class="navbar navbar-expand-lg nav-fix sticky-top navbar-light bg-light">
			<a class="navbar-brand" href="javascript:void();"><div class="nav-logo-wrap"><div class="nav-logo"></div> <span class="nav-text">E-LIBRARY</span></div> </a>
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/project/interface/pages/user-profile.php">My profile</a>
				</li>
				<!--There are only library options on this page, because only librarian can access this page-->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle active" href="javascript:void();" id="navbarLibraryDropdown" role="button" data-toggle="dropdown"><span class="sr-only">(current)</span>
						Library options
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item active" href="/project/interface/pages/author-management.php">Manage authors</a>
						<a class="dropdown-item" href="/project/interface/pages/book-management.php">Manage books</a>
						<a class="dropdown-item" href="#">Manage book lendings</a>
						<a class="dropdown-item" href="#">Manage members</a>	
						<a class="dropdown-item" href="#">Manage publishers</a>
					</div>
				</li>
				<li class="nav-item">
					<form id="logout" method="get" action="">
						<input type="hidden" name="logout" value="logout" /> 
						<a class="nav-link" href="javascript:void();" onclick="document.getElementById('logout').submit();">Log out</a>
					</form>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0" method="get">
				<input class="form-control mr-sm-2" type="search" name="search-input" placeholder="Search authors by name">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" value="search">Search</button>
			</form>
			
		</div>
	</nav>

	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul>
				<li class="available-tab active-tab"><a href="javascript:void();">Available authors</a></li>
			<ul>
			</div>
			<div class="table-container">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">First name</th>
							<th scope="col">Last name</th>
							<th scope="col">Short biography</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($authors as $author){ ?>
							<tr>
								<th scope="row"><?php echo $id?></th>
								<td><?php echo $author->get_firstname(); ?></td>
								<td><?php echo $author->get_lastname(); ?></td>
								<td><?php echo $helper->empty_manage($author->get_short_biography()); ?></td>
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
					echo " href=author-management.php";
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
	
	
	<div class="footer-container">
		<div class="row text-center text-xs-center text-sm-left text-md-left justify">
			<div class="col-xs-12 col-sm-4 col-md-4 links">
				<h5>Quick links</h5>
				<ul class="list-unstyled quick-links">
					<li><a href="/project/interface/pages/user-profile.php">Home</a></li>
					<li>
						<form id="log-out" method="get" action="">
							<input type="hidden" name="log-out" value="logout" /> 
							<a href="javascript:void();" onclick="document.getElementById('log-out').submit();">
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
