<?php
	require_once __DIR__.'/../../data/data_access/book_lendDAO.php';
	require_once __DIR__.'/../../data/data_controllers/book_lendings_management_controller.php';

	$book_lendings_management_controller = new book_lendings_management_controller();
	$book_lendings_management_controller->do_action();
	
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	
	$helper = new helpers();	
	$id = 1;
	
	$lendDao = new book_lendDAO();
	$max_records = 5;
	
	if(isset($_GET["page"])){
		$page_number = $_GET["page"];
		$from = ($page_number*$max_records)-$max_records;
					
	}
	else{
		$from = 0;
	}
	if(isset($_GET["search"])){
		$lends = $lendDao->get_by_name_in_range($_GET["search-input"],$from,$max_records);
		$lends_count = $lendDao->count_by_name($_GET["search-input"]);
		
	}
	else{		
		
		$lends = $lendDao->get_all();
		$lends_count = count($lends);
		$lends = $lendDao->get_in_range($from,$max_records);
		
	}
	$pages_count = ceil($lends_count/$max_records);
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Book lending management</title>
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
				<!--There are only library options on this page, because only librarian can access this page-->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle active" href="javascript:void(0);" id="navbarLibraryDropdown" role="button" data-toggle="dropdown"><span class="sr-only">(current)</span>
						Library options
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/project/interface/pages/author-management.php">Manage authors</a>
						<a class="dropdown-item" href="/project/interface/pages/book-management.php">Manage books</a>
						<a class="dropdown-item" href="/project/interface/pages/book-copy-management.php">Manage book copies</a>						
						<a class="dropdown-item active" href="/project/interface/pages/book-lendings-management.php">Manage book lendings</a>
						<a class="dropdown-item" href="/project/interface/pages/membership-management.php">Manage members</a>	
						<a class="dropdown-item" href="/project/interface/pages/publisher-management.php">Manage publishers</a>
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
				<input class="form-control mr-sm-2" id="search-input" type="search" name="search-input" placeholder="Search book lendings">
				<button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="do_search('book-lendings-management.php','search-input');" name="search" value="search">Search</button>
			</form>
			
		</div>
	</nav>


	

	<!--Page body-->
	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
				<ul id="tabs">
					<li id="tab-1" onclick="show_selected_view(this);" class="active-tab"><a href="javascript:void(0);">Available book lendings</a></li>
				</ul>
			</div>
			<div id="views">
				<div id="tab1-view" >
					<div id="datagrid" class="table-container">
						<table id="table" class="table table-striped">
						
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Full member name</th>
									<th scope="col">Book title</th>
									<th scope="col">Lend date</th>
									<th scope="col">Return date</th>
									<th scope="col">Approved</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($lends as $lend){ 
									$book = $lend->get_book_copy()->get_book();
									$user_member = $lend->get_member()->get_user();
								?>
									<tr id="<?php echo $lend->get_id_lend(); ?>" data-toggle="modal" data-target="#bookLendEditModal" onclick='setModalValues("bookLendEditModal",this);'>
										<th scope="row"><?php echo $id?></th>
										<td><?php echo $user_member->get_firstname()." ".$user_member->get_lastname(); ?></td>
										<td><?php echo $book->get_book_title(); ?></td>
										<td><?php echo date('d.m.Y.',strtotime($lend->get_lend_date())); ?></td>
										<td><?php echo date('d.m.Y.',strtotime($lend->get_return_date())); ?></td>
										<td><?php echo $helper->get_approval_text($lend->get_approved()); ?></td>
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
									echo " onclick=mark_page_as_active('table-nums',this);change_page('book-lendings-management.php',{$i},null,null);";
								} 
								else{
									echo " onclick=mark_page_as_active('table-nums',this);change_page('book-lendings-management.php',{$i},'{$_GET["search-input"]}','search');"; 
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
	<div class="modal fade" id="bookLendEditModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="bookLendEditLabel">Edit book lend</h4>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="user-form-wrap">
						<div class="form-section">
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="book-id-edit-input">Book id</label>
								<div class="col-sm-10 user-col-fix">
									<input type="text" class="form-control" id="book-id-edit-input" name="book-id-edit-input">
									<span></span>
								</div>
							</div>
							<div class="form-check inline-check">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox">
										<input type="checkbox" class="form-check-input" id="approved-lend-check" onclick="changeCheckValue(this);">
										<label class="form-check-label" for="approved-lend-check">Approve</label>
									</div>
								</div>
							</div>
							
							
						</div>
							
						<div class="form-section">
							
														
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" onclick="deleteData('bookLendEditModal','book-lendings-management.php');" class="btn btn-danger" data-dismiss="modal">Delete</button>
					<button type="button" onclick="sendUpdatedLendData('bookLendEditModal');" class="btn btn-primary" data-dismiss="modal">Save changes</button>
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
	<script src="../scripts/lend-script.js"></script>
</body>
</html>
