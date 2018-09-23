<?php
	require_once __DIR__.'/../../data/data_access/bookDAO.php';
	require_once __DIR__.'/../../data/data_controllers/book_management_controller.php';

	$book_management_controller = new book_management_controller();
	$book_management_controller->do_action();
	
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	
	$helper = new helpers();	
	$id = 1;
	
	$bookDao = new bookDAO();
	$max_records = 5;
	
	if(isset($_GET["page"])){
		$page_number = $_GET["page"];
		$from = ($page_number*$max_records)-$max_records;
					
	}
	else{
		$from = 0;
	}
	if(isset($_GET["search"])){
		$books = $bookDao->get_by_title_in_range($_GET["search-input"],$from,$max_records);
		$books_count = $bookDao->count_by_title($_GET["search-input"]);
		
	}
	else{		
		
		$books = $bookDao->get_all();
		$books_count = count($books);
		$books = $bookDao->get_in_range($from,$max_records);
		
	}
	$pages_count = ceil($books_count/$max_records);
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Book management</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/library-icon.ico" />
		<link rel="stylesheet" href="../styles/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../styles/bootstrap-nav-fix.css" />
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
						<a class="dropdown-item  active" href="/project/interface/pages/book-management.php">Manage books</a>					<a class="dropdown-item" href="/project/interface/pages/book-copy-management.php">Manage book copies</a>					
						<a class="dropdown-item" href="/project/interface/pages/book-lendings-management.php">Manage book lendings</a>
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
			<form class="form-inline my-2 my-lg-0" method="get">
				<input class="form-control mr-sm-2" type="search" name="search-input" placeholder="Search authors by name">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" value="search">Search</button>
			</form>
			
		</div>
	</nav>


	

		<!--Page body-->
	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul id="tabs">
				<li id="tab-1" onclick="show_selected_view(this);" class="available-tab <?php $helper->print_active_tab_class() ?>"><a href="javascript:void(0);">Add book</a></li>
				<li id="tab-2" onclick="show_selected_view(this);" class="available-tab <?php $helper->print_active_tab_class(true) ?>"><a href="javascript:void(0);">Available books</a></li>
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
									<th scope="col">Book title</th>
									<th scope="col">Original book title</th>
									<th scope="col">Authors</th>
									<th scope="col">Genres</th>
									<th scope="col">Book category</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($books as $book){ 
									$authors = $book->get_authors();
									$genres = $book->get_genres();
									$authors_string = "";
									$genres_string = "";
								?>
									<tr>
										<th scope="row"><?php echo $id?></th>
										<td><?php echo $book->get_book_title(); ?></td>
										<td><?php echo $book->get_original_book_title(); ?></td>
										<td><?php $last_authors_key = count($authors) - 1;
											  foreach ($authors as $key => $value) {
												$authors_string = $authors_string." ".$authors[$key]->get_firstname()." ".$authors[$key]->get_lastname();
											  	if ($key != $last_authors_key) {
													$authors_string = $authors_string." and ";
												}
											  }
											echo $helper->empty_manage($authors_string);
											?>
										</td>
										<td><?php $last_genres_key = count($genres) - 1;
											  foreach ($genres as $key => $value) {
												$genres_string = $genres_string.$genres[$key]->get_genre_title();
											  	if ($key != $last_genres_key) {
													$genres_string = $genres_string." / ";
												}
											  }
											echo $helper->empty_manage($genres_string);
											?>
										</td>
										<td><?php echo $book->get_category()->get_category_title(); ?></td>
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
							echo " href=book-management.php";
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
	<script src="../scripts/index.js"></script>

</body>
</html>
