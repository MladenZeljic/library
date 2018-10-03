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
	<link rel="stylesheet" href="../styles/bootstrap-form-fix.css" />
	<link rel="stylesheet" href="../styles/bootstrap-table-fix.css" />
	<link rel="stylesheet" href="../styles/modal.css" />
	<link rel="stylesheet" href="../styles/author.css" />
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
						<a class="dropdown-item active" href="/project/interface/pages/author-management.php">Manage authors</a>
						<a class="dropdown-item" href="/project/interface/pages/book-management.php">Manage books</a>
						<a class="dropdown-item" href="/project/interface/pages/book-copy-management.php">Manage book copies</a>					<a class="dropdown-item" href="/project/interface/pages/book-lendings-management.php">Manage book lendings</a>
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
				<input class="form-control mr-sm-2" id="search-input" type="search" name="search-input" placeholder="Search author by name">
				<button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="do_search('author-management.php','search-input');" name="search" value="search">Search</button>
			</form>
			
		</div>
	</nav>

	<div class="page-body-wrap">
		<div class="page-body">
			<div class="body-nav">
			<ul id="tabs">
				<li id="tab-1" onclick="show_selected_view(this);" class="active-tab"><a href="javascript:void(0);">Add author</a></li>
				<li id="tab-2" onclick="show_selected_view(this);" ><a href="javascript:void(0);">Available authors</a></li>
			</ul>
			</div>
			<div id="views">
				<div id="tab1-view" >
					<div class="user-form-wrap">
						<form id="author-form" class="user-form" method="post" onsubmit="return false;" action="">
							<div class="form-section left-section">
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="author-firstname-input">Author firstname</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="author-firstname-input" name="author-firstname-input" placeholder="Enter author firstname">
										<span></span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="author-lastname-input">Author lastname</label>
									<div class="col-sm-10 user-col-fix">
										<input type="text" class="form-control" id="author-lastname-input" name="author-lastname-input" placeholder="Enter author lastname">
										<span></span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="author-birth-date-input">Author birth date</label>
									<div class="col-sm-10 user-col-fix">
										<input type="date" class="form-control" id="author-birth-date-input" name="author-birth-date-input" >
										<span></span>
									</div>
								</div>
							</div>
							<div class="form-section">
								<div class="form-group">
									<label class="control-label col-sm-2 user-col-fix" for="author-biography-input">Author biography</label>
									<div class="col-sm-10 user-col-fix">
										<textarea maxlength="300" class="form-control" id="author-biography-input" name="author-biography-input" placeholder="You can enter author biography here" onkeyup="setCharCount(this)"></textarea>
										<div id="count-container" ><span id="char-text">Characters left:</span><span id="chars-count">300</span></div>
									</div>
								</div>
							</div>
							<div class="clear"></div>
							<div class="form-group">        
								<div class="col-sm-offset-2 col-sm-10 user-form-button-wrap">
									<button type="button" onclick="validateAndSendAuthorForm('author-form')" class="btn btn-primary form-button" name="save" value="save">Save</button>
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
									<th scope="col">First name</th>
									<th scope="col">Last name</th>
									<th scope="col">Date of birth</th>
									<th scope="col">Short biography</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($authors as $author){ ?>
									<tr id="<?php echo $author->get_id_author(); ?>" data-toggle="modal" data-target="#authorEditModal" onclick="setModalValues('authorEditModal',this);">
										<th scope="row"><?php echo $id?></th>
										<td><?php echo $author->get_firstname(); ?></td>
										<td><?php echo $author->get_lastname(); ?></td>
										<td><?php echo date('d.m.Y.',strtotime($author->get_date_of_birth())); ?></td>
										<td class="text-description"><?php echo $helper->empty_manage($author->get_short_biography()); ?></td>
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
									echo " onclick=mark_page_as_active('table-nums',this);change_page('author-management.php',{$i},null,null);";
								} 
								else{
									echo " onclick=mark_page_as_active('table-nums',this);change_page('author-management.php',{$i},'{$_GET["search-input"]}','search');"; 
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
	<div class="modal fade" id="authorEditModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="authorEditLabel">Edit author</h4>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="user-form-wrap">
						<div class="form-section left-section">
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="author-id-edit-input">Author id</label>
								<div class="col-sm-10 user-col-fix">
									<input type="text" class="form-control" id="author-id-edit-input" name="author-id-edit-input">
									<span></span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="author-edit-firstname-input">Author firstname</label>
								<div class="col-sm-10 user-col-fix">
									<input type="text" class="form-control" id="author-edit-firstname-input" name="author-edit-firstname-input" placeholder="Enter author firstname">
									<span></span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="author-edit-lastname-input">Author lastname</label>
								<div class="col-sm-10 user-col-fix">
									<input type="text" class="form-control" id="author-edit-lastname-input" name="author-edit-lastname-input" placeholder="Enter author lastname">
									<span></span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="author-edit-birth-date-input">Author birth date</label>
								<div class="col-sm-10 user-col-fix">
									<input type="date" class="form-control" id="author-edit-birth-date-input" name="author-edit-birth-date-input" >
									<span></span>
								</div>
							</div>
						</div>
						<div class="form-section">
							<div class="form-group">
								<label class="control-label col-sm-2 user-col-fix" for="author-edit-biography-input">Author biography</label>
								<div class="col-sm-10 user-col-fix">
									<textarea maxlength="300" class="form-control" id="author-edit-biography-input" name="author-edit-biography-input" placeholder="You can enter author biography here" onkeyup="setCharCount(this)"></textarea>
									<div id="count-edit-container"><span id="char-edit-text">Characters left:</span><span id="chars-edit-count">300</span></div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" onclick="deleteData('authorEditModal','author-management.php');" class="btn btn-danger" data-dismiss="modal">Delete</button>
					<button type="button" onclick="sendUpdatedAuthorData('authorEditModal');" class="btn btn-primary" data-dismiss="modal">Save changes</button>
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
	<script src="../scripts/author-script.js"></script>

</body>
</html>
