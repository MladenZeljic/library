<?php
	require_once __DIR__.'/../../data/data_access/bookDAO.php';
	require_once __DIR__.'/../../data/data_access/book_copyDAO.php';
	require_once __DIR__.'/../../data/data_access/publisherDAO.php';
	require_once __DIR__.'/../../data/data_access/userDAO.php';
	require_once __DIR__.'/../../data/data_controllers/book_copy_management_controller.php';

	$book_copy_management_controller = new book_copy_management_controller();
	$book_copy_management_controller->do_action();
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	$helper = new helpers();	
	$id = 1;
	
	$copyDao = new book_copyDAO();
	
	$bookDao = new bookDAO();
	$books = $bookDao->get_all();
	
	$publisherDao = new publisherDAO();
	$publishers = $publisherDao->get_all();
	
	$max_records = 5;
	
	if(isset($_GET["page"])){
		$page_number = $_GET["page"];
		$from = ($page_number*$max_records)-$max_records;
					
	}
	else{
		$from = 0;
	}
	if(isset($_GET["search"])){
		$copies = $copyDao->get_by_title_in_range($_GET["search-input"],$from,$max_records);
		$copies_count = $copyDao->count_by_title($_GET["search-input"]);
		
	}
	else{		
		
		$copies = $copyDao->get_all();
		$copies_count = count($copies);
		$copies = $copyDao->get_in_range($from,$max_records);
		
	}
	$pages_count = ceil($copies_count/$max_records);
	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Book copy management</title>
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
				<!--There are only library options on this page, because only librarian can access this page-->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle active" href="javascript:void(0);" id="navbarLibraryDropdown" role="button" data-toggle="dropdown"><span class="sr-only">(current)</span>
						Library options
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/project/interface/pages/author-management.php">Manage authors</a>
						<a class="dropdown-item" href="/project/interface/pages/book-management.php">Manage books</a>
						<a class="dropdown-item active" href="/project/interface/pages/book-copy-management.php">Manage book copies</a>					<a class="dropdown-item" href="/project/interface/pages/book-lendings-management.php">Manage book lendings</a>
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
				<input class="form-control mr-sm-2" id="search-input" type="search" name="search-input" placeholder="Search books by title">
				<button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="do_search('book-copy-management.php','search-input');" name="search" value="search">Search</button>
			</form>
			
		</div>
	</nav>

	
	<!--Page body-->
	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul id="tabs">
				<li  id="tab-1" onclick="show_selected_view(this);" class="active-tab"><a href="javascript:void(0);">Add book copy</a></li>
				<li  id="tab-2" onclick="show_selected_view(this);"><a href="javascript:void(0);">Available book copies</a></li>
			</ul>
			</div>
			<div id="views">
				<div id="tab1-view" >
					<div class="user-form-wrap">
						<form id="copy-form" class="user-form" method="post" onsubmit="return false;" action="">
							<div class="form-section left-section">
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="copy-book-select">Book</label>
									<div class="col-sm-10 user-col-fix">
										<select class="form-control" id="copy-book-select" name="copy-book-select" >
											<?php foreach($books as $book){ ?>
												<option value="<?php echo $book->get_id_book(); ?>"> <?php echo $book->get_book_title(); ?></option>
											<?php } ?>
										</select>
										<span></span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="year-of-publication-input">Year of publication</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="year-of-publication-input" name="year-of-publication-input" placeholder="Enter year of publication">
										<span></span>
									</div>
								</div>
							</div>
							<div class="form-section">
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="publisher-select">Book publisher</label>
									<div class="col-sm-10 user-col-fix">
										<select class="form-control" id="publisher-select" name="publisher-select" >
											<?php foreach($publishers as $publisher){ ?>
												<option value="<?php echo $publisher->get_id_publisher(); ?>"> <?php echo $publisher->get_publisher_name(); ?></option>
											<?php } ?>
										</select>
										<span></span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="number-of-pages-input">Number of pages</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="number-of-pages-input" name="number-of-pages-input" placeholder="Enter number of pages">
										<span></span>
									</div>
								</div>
							</div>
							<div class="clear"></div>
							<div class="form-group">        
								<div class="col-sm-offset-2 col-sm-10 user-form-button-wrap">
									<button type="button" onclick="validateAndSendCopyForm('copy-form')" class="btn btn-primary form-button" name="save" value="save">Save</button>
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
									<th scope="col">Book title</th>
									<th scope="col">Year of publication</th>
									<th scope="col">Number of pages</th>
									<th scope="col">Publisher name</th>
									<th scope="col">Copy available</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($copies as $copy){ 
									
								?>
									<tr>
										<th scope="row"><?php echo $id?></th>
										<td><?php echo $copy->get_book()->get_book_title(); ?></td>
										<td><?php echo $copy->get_year_of_publication(); ?></td>
										<td><?php echo $copy->get_number_of_pages(); ?></td>
										<td><?php echo $copy->get_publisher()->get_publisher_name(); ?></td>
										<td><?php echo $helper->get_available_text($copy->get_available()); ?></td>
									
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
									echo " onclick=mark_page_as_active('table-nums',this);change_page('book-copy-management.php',{$i},null,null);";
								} 
								else{
									echo " onclick=mark_page_as_active('table-nums',this);change_page('book-copy-management.php',{$i},'{$_GET["search-input"]}','search');"; 
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
	<script src="../scripts/index.js"></script>
	<script src="../scripts/copy-script.js"></script>
</body>
</html>
