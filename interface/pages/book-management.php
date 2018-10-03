<?php
	require_once __DIR__.'/../../data/data_access/authorDAO.php';
	require_once __DIR__.'/../../data/data_access/bookDAO.php';
	require_once __DIR__.'/../../data/data_access/categoryDAO.php';
	require_once __DIR__.'/../../data/data_access/genreDAO.php';
	require_once __DIR__.'/../../data/data_controllers/book_management_controller.php';

	$book_management_controller = new book_management_controller();
	$book_management_controller->do_action();
	
	$userDao = new userDAO();
	$user = $userDao->get_by_username($_SESSION["username"]);
	
	$helper = new helpers();	
	$id = 1;
	
	$authorDao = new authorDAO();
	$authors = $authorDao->get_all();

	$genreDao = new genreDAO();
	$genres = $genreDao->get_all();	
	
	$categoryDao = new categoryDAO();
	$categories = $categoryDao->get_all();	
	
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
			<form class="form-inline my-2 my-lg-0" method="get" onsubmit="return false;">
				<input class="form-control mr-sm-2" id="search-input" type="search" name="search-input" placeholder="Search books by title">
				<button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="do_search('book-management.php','search-input');" name="search" value="search">Search</button>
			</form>
			
		</div>
	</nav>


	

		<!--Page body-->
	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul id="tabs">
				<li id="tab-1" onclick="show_selected_view(this);" class="active-tab"><a href="javascript:void(0);">Add book</a></li>
				<li id="tab-2" onclick="show_selected_view(this);"><a href="javascript:void(0);">Available books</a></li>
			</ul>
			</div>
			<div id="views">
				<div id="tab1-view" >
					<div class="user-form-wrap">
						<form id="book-form" class="user-form" method="post" onsubmit="return false;" action="">
							<div class="form-section left-section">
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="book-title-input">Book title</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="book-title-input" name="book-title-input" placeholder="Enter book title">
										<span></span>
									</div>
								</div>
								<div class="form-group book-title-fix">
									<label class="control-label col-sm-2 user-col-fix" for="original-book-title-input">Original title</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="original-book-title-input" name="original-book-title-input" placeholder="Enter original book title">
										<span></span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="category-select">Category title</label>
									<div class="col-sm-10 user-col-fix">
										<select class="form-control select-values">
											<?php foreach($categories as $category){ ?>
												<option value=<?php echo $category->get_id_category();?>><?php echo $category->get_category_title();?></option>
												<?php } ?>
										</select>
										<span></span>
									</div>
								</div>
							</div>
							
							<div class="form-section">
								<div class="form-group">
									<div class="container input-select-container">
										<label>Book authors</label>
										<div id="author-input-field" class="input-field">
											<ul id="input-content">
											</ul>
										</div>
										<span></span>
										<div class="input-container">
											<div class="form-group select-box">
												<select class="form-control select-values">
													<?php foreach($authors as $author){ ?>
														<option value="<?php echo $author->get_id_author();?>"><?php echo $author->get_firstname()." ".$author->get_lastname();?></option>
													<?php } ?>
												</select>
											</div>
											<div class="add-button-wrap">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="button"  onclick="add_selection_box_element('author-input-field');" class="btn btn-primary form-button add-button">+</button>
											</div>
											</div>
											<div class="clear"></div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="container input-select-container">
										<label>Book genres</label>
										<div id="genre-input-field" class="input-field">
											<ul id="input-content">
											</ul>
										</div>
										<span></span>
										<div class="input-container">
											<div class="form-group select-box">
												<select class="form-control select-values">
													<?php foreach($genres as $genre){ ?>
														<option value="<?php echo $genre->get_id_genre();?>"><?php echo $genre->get_genre_title();?></option>
													<?php } ?>
												</select>
											</div>
											<div class="add-button-wrap"> 
											<div class="col-sm-offset-2 col-sm-10">
												<button type="button"  onclick="add_selection_box_element('genre-input-field');" class="btn btn-primary form-button add-button">+</button>
											</div>
											</div>
											<div class="clear"></div>
										</div>
									</div>
								</div>
								
							</div>
							<div class="clear"></div>
							<div class="form-group">        
								<div class="col-sm-offset-2 col-sm-10 user-form-button-wrap">
									<button type="button" onclick="validateAndSendBookForm('book-form')" class="btn btn-primary form-button" name="save" value="save">Save</button>
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
									$authors_json = addslashes(json_encode($authors));
									$genres_json = addslashes(json_encode($genres));
								?>
									<tr id="<?php echo $book->get_id_book(); ?>" data-toggle="modal" data-target="#bookEditModal" onclick='setModalValues("bookEditModal",this,null,null,"<?php echo $authors_json; ?>","<?php echo $genres_json; ?>");'>
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
									echo " onclick=mark_page_as_active('table-nums',this);change_page('book-management.php',{$i},null,null);";
								} 
								else{
									echo " onclick=mark_page_as_active('table-nums',this);change_page('book-management.php',{$i},'{$_GET["search-input"]}','search');"; 
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
	<?php 
		
		$authors = $authorDao->get_all();
		$categories = $categoryDao->get_all();
		$genres = $genreDao->get_all();	
	?>
	<div class="modal fade" id="bookEditModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="bookEditLabel">Edit book</h4>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="user-form-wrap">
						<div class="form-section left-section">
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="book-id-edit-input">Book id</label>
								<div class="col-sm-10 user-col-fix">
									<input type="text" class="form-control" id="book-id-edit-input" name="book-id-edit-input">
									<span></span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="book-title-edit-input">Book title</label>
								<div class="col-sm-10 user-col-fix">
									<input type="text" class="form-control" id="book-title-edit-input" name="book-title-edit-input" placeholder="Enter book title">
									<span></span>
								</div>
							</div>
							<div class="form-group book-title-fix">
								<label class="control-label col-sm-2 user-col-fix" for="original-book-title-edit-input">Original title</label>
								<div class="col-sm-10 user-col-fix">
									<input type="text" class="form-control" id="original-book-title-edit-input" name="original-book-title-edit-input" placeholder="Enter original book title">
									<span></span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="category-edit-select">Category title</label>
								<div class="col-sm-10 user-col-fix">
									<select class="form-control select-values">
										<?php foreach($categories as $category){ ?>
											<option value=<?php echo $category->get_id_category();?>><?php echo $category->get_category_title();?></option>
										<?php } ?>
									</select>
									<span></span>
								</div>
							</div>
							
						</div>
							
						<div class="form-section">
							
							<div class="form-group">
								<div class="container input-select-container">
									<label>Book authors</label>
									<div id="author-edit-input-field" class="input-field">
										<ul id="input-content">
										</ul>
									</div>
									<span></span>
									<div class="input-container">
										<div class="form-group select-box">
											<select class="form-control select-values">
												<?php foreach($authors as $author){ ?>
													<option value="<?php echo $author->get_id_author();?>"><?php echo $author->get_firstname()." ".$author->get_lastname();?></option>
												<?php } ?>
											</select>
										</div>
										<div class="add-button-wrap">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="button"  onclick="add_selection_box_element('author-edit-input-field');" class="btn btn-primary form-button add-button">+</button>
											</div>
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="container input-select-container">
									<label>Book genres</label>
									<div id="genre-edit-input-field" class="input-field">
										<ul id="input-content">
										</ul>
									</div>
									<span></span>
									<div class="input-container">
										<div class="form-group select-box">
											<select class="form-control select-values">
												<?php foreach($genres as $genre){ ?>
													<option value="<?php echo $genre->get_id_genre();?>"><?php echo $genre->get_genre_title();?></option>
												<?php } ?>
											</select>
										</div>
										<div class="add-button-wrap"> 
											<div class="col-sm-offset-2 col-sm-10">
												<button type="button"  onclick="add_selection_box_element('genre-edit-input-field');" class="btn btn-primary form-button add-button">+</button>
											</div>
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
														
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" onclick="deleteData('bookEditModal','book-management.php');" class="btn btn-danger" data-dismiss="modal">Delete</button>
					<button type="button" onclick="sendUpdatedBookData('bookEditModal');" class="btn btn-primary" data-dismiss="modal">Save changes</button>
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
	<script src="../scripts/book-script.js"></script>

</body>
</html>
