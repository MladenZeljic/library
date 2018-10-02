<?php
	require_once __DIR__.'/data/data_access/bookDAO.php';
	require_once __DIR__.'/data/data_access/userDAO.php';
	require_once __DIR__.'/data/data_controllers/index_controller.php';
	

	$index_controller = new index_controller();
	
	$helper = new helpers();	
	$id = 1;
	
	$index_controller->do_action();	
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
		<title>Welcome page</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="resources/images/library-icon.ico" />
		<link rel="stylesheet" href="interface/styles/css/bootstrap.min.css" />
		<link rel="stylesheet" href="interface/styles/bootstrap-nav-fix.css" />
		<link rel="stylesheet" href="interface/styles/bootstrap-table-fix.css" />
		<link rel="stylesheet" href="interface/styles/bootstrap-form-fix.css" />
		<link rel="stylesheet" href="interface/styles/modal.css" />
		<link rel="stylesheet" href="interface/styles/page.css" />
		<link rel="stylesheet" href="interface/styles/index.css" />
		<link rel="stylesheet" href="interface/styles/footer.css" />
  
	</head>
	<body>
		<nav class="navbar navbar-expand-lg nav-fix sticky-top navbar-light bg-light">
			<a class="navbar-brand" href="javascript:void(0);"><div class="nav-logo-wrap"><div class="nav-logo"></div> <span class="nav-text">E-LIBRARY</span></div> </a>
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link active" href="">Welcome<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="interface/pages/login-register.php">Sign in/ sign up</a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0" method="get" onsubmit="return false;">
				<input class="form-control mr-sm-2" id="search-input" type="search" name="search-input" placeholder="Search books by title">
				<button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="do_search('index.php','search-input');" name="search" value="search">Search</button>
			</form>
		</div>
	</nav>

	

	<!--Page body-->
	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul id="tabs">
				<li id="tab-1" onclick="show_selected_view(this);" class="active-tab"><a href="javascript:void(0);">Available books</a></li>
			</ul>
			</div>
			<div id="views">
				<div id="tab1-view">
					<div class="index-text-wrap">
						<div class="index-text-title">Welcome!</div> 
						<small>Here you can search for books that are currently available in our library. To do more please sign in or sign up.</small>
					</div>
					<div id="datagrid" class="table-container">
						<table id="table" class="table table-striped">
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
									else{
										echo "class=page";	
									}
								}
								if(!isset($_GET["search"])){ 
									echo " onclick=mark_page_as_active('table-nums',this);change_page('index.php',{$i},null,null);";
								} 
								else{
									echo " onclick=mark_page_as_active('table-nums',this);change_page('index.php',{$i},'{$_GET["search-input"]}','search');"; 
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
			<div class="index-footer-logo-wrap text-center text-xs-center text-sm-left text-md-left"><div class="footer-logo"></div><div class="footer-logo-text">E-LIBRARY</div></div> 
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
	<script src="interface/scripts/index.js"></script>
</body>
</html>
