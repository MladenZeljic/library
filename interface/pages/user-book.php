<?php
	require_once __DIR__.'/../../data/data_access/userDAO.php';
	require_once __DIR__.'/../../data/data_access/book_lendDAO.php';
	require_once __DIR__.'/../../data/data_controllers/user_book_controller.php';

	$user_book_controller = new user_book_controller();
	$user_book_controller->do_action();
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	$helper = new helpers();
	$id = 1;
	
	$lendDao = new book_lendDAO();
	$max_records = 5;

	$copyDao = new book_copyDAO();
	$copies = $copyDao->get_non_lended_copies();	
	
	if(isset($_GET["page"])){
		$page_number = $_GET["page"];
		$from = ($page_number*$max_records)-$max_records;
					
	}
	else{
		$from = 0;
	}
	if(isset($_GET["search"])){
		$lends = $lendDao->get_by_name_in_range_with_user($user, $_GET["search-input"],$from,$max_records);
		$lends_count = $lendDao->count_by_name_with_user($user, $_GET["search-input"]);
		
	}
	else{		
		
		$lends = $lendDao->get_all_with_user($user);
		$lends_count = count($lends);
		$lends = $lendDao->get_in_range_with_user($user,$from,$max_records);
		
	}
	$pages_count = ceil($lends_count/$max_records);	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>User books</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/library-icon.ico" />
		<link rel="stylesheet" href="../styles/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../styles/bootstrap-nav-fix.css" />
		<link rel="stylesheet" href="../styles/bootstrap-form-fix.css" />
		<link rel="stylesheet" href="../styles/bootstrap-table-fix.css" />
		<link rel="stylesheet" href="../styles/book-lend.css" />
		<link rel="stylesheet" href="../styles/page.css" />
		<link rel="stylesheet" href="../styles/footer.css" />
	</head>
	<body>
		<nav class="navbar navbar-expand-lg nav-fix sticky-top navbar-light bg-light">
			<a class="navbar-brand" href="javascript:void(0);"><div class="nav-logo-wrap"><div class="nav-logo"></div> <span class="nav-text">E-LIBRARY</span></div> </a>
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/project/interface/pages/user-profile.php">My profile<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="/project/interface/pages/user-book.php">My books</a>
				</li>
				<li class="nav-item">
					<form id="logout" method="get" action="">
						<input type="hidden" name="logout" value="logout" /> 
						<a class="nav-link" href="javascript:void(0);" onclick="document.getElementById('logout').submit();">Log out</a>
					</form>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0" method="get" onsubmit="return false;">
				<input class="form-control mr-sm-2" id="search-input" type="search" name="search-input" placeholder="Search your lends">
				<button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="do_search('user-book.php','search-input');" name="search" value="search">Search</button>
			</form>
			
		</div>
	</nav>
	
	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul id="tabs">
				<li id="tab-1" onclick="show_selected_view(this);" class="active-tab"><a href="javascript:void(0);">Lend a book</a></li>
				<li id="tab-2" onclick="show_selected_view(this);" ><a href="javascript:void(0);">Lended books</a></li>
			</ul>
			</div>
			<div id="views">
				<div id="tab1-view" >
					<div class="user-form-wrap">
						<form id="lend-form" class="user-form" method="post" onsubmit="return false;" action="">
							<div class="lend-form-section">
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="book-select">Book</label>
									<div class="col-sm-10 user-col-fix">
										<select class="form-control" id="book-select" name="book-select" >										<?php foreach($copies as $copy){ ?>
												<option value="<?php echo $copy->get_id_book_copy(); ?>"> <?php echo $copy->get_book()->get_book_title().", ".$copy->get_publisher()->get_publisher_name(); ?></option>
											<?php } ?>
										</select>
										<span></span>
									</div>
								</div>
								
							</div>
							<div class="form-group">        
								<div class="col-sm-offset-2 col-sm-10 user-form-button-wrap">
									<button type="button" onclick="validateAndSendLendForm('lend-form')" class="btn btn-primary form-button" name="save" value="save">Save</button>
								</div>
							</div>
							
						</form>
					</div>
				</div>
				<div id="tab2-view" class="tab-view-hide" >
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
									<tr id="<?php echo $lend->get_id_lend(); ?>" onclick="returnBook(this);">
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
									echo " onclick=mark_page_as_active('table-nums',this);change_page('user-book.php',{$i},null,null);";
								} 
								else{
									echo " onclick=mark_page_as_active('table-nums',this);change_page('user-book.php',{$i},'{$_GET["search-input"]}','search');"; 
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
	<script src="../scripts/page.js"></script>
	<script src="../scripts/user-book-script.js"></script>
</body>
</html>
