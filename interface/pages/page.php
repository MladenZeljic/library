<?php
	include '../../data/data_models/address.php';
	require_once '../../data/data_access/addressDAO.php';
	require_once '../../data/data_access/authorDAO.php';
	require_once '../../data/data_access/bookDAO.php';
	require_once '../../data/data_access/book_copyDAO.php';
	require_once '../../data/data_access/book_lendDAO.php';
	require_once '../../data/data_access/categoryDAO.php';
	require_once '../../data/data_access/genreDAO.php';
	require_once '../../data/data_access/publisherDAO.php';
	require_once '../../data/data_access/memberDAO.php';
	require_once '../../data/data_access/userDAO.php';
	
	echo '<style>';
	include '../styles/page_style.css';
	echo '</style>';
	
	header('Content-Type: text/html; charset=utf-8');
	
		
	$address = new address(75249,'Pribojska b.b.','Priboj kod Lopara');
	$userDao = new userDAO();
	$memberDao = new memberDAO();
	$addressDao = new addressDAO();	
	$book_copyDao = new book_copyDAO();
	$bookDao = new bookDAO();
	$publisherDao = new publisherDAO();
	$book = $bookDao->get_by_id(9);
	$publisher = $publisherDao->get_by_id(1);
	$copy = $book_copyDao->get_by_id(1);
	//$book_copyDao->update($copy,$new_copy);
	//$user = new user("Firstname","Lastname","1998-10-11","mail@mail.com","uname","pass",1,0,0);
	//$userDao->insert($user);
	//$new_user = $user;
	//$new_user->set_status(1);
	//$userDao->update($user,$new_user);
	$user = $userDao->get_by_id(1);
	$address = $addressDao->get_by_id(1);
	//$member = new member("055/258-741","065/858-965","2017-11-10","2018-11-10",0,"notes",$address,$user);
	//$memberDao->insert($member);
	$member = $memberDao->get_by_id(1);	
	//$memberDao->update($member,$new_member);
	$book_lend = new book_lend("2018-09-10","2018-09-20",$copy,$member);
	$lendDao = new book_lendDAO();
	$lendDao->insert($book_lend);	
	$members = $memberDao->get_all();
	foreach($members as $member){
		echo $member->get_member_to();
		echo $member->get_penality_points();

		echo "<br>";
	}
	/*$publishers = $publisherDao->get_by_id(1);
	echo $publisher->get_publisher_name();
	echo $publisher->get_publisher_address()->get_city();
	echo "<br>";
	$new_publisher = $publishers;
	//$new_publisher->set_publisher_name("Grafo-print");
	//$publisherDao->update($publisher,$new_publisher);
	//$insert_publisher = new publisher("Publisher1",(new addressDAO())->get_by_id(1));
	//$publisherDao->insert($insert_publisher);

$authorDao = new authorDAO();
$new_genre = new genre("Drama");
$book = (new bookDAO())->get_by_id(12);
//$authorDao->insert(new author("author","mcauthor","1986-10-10","short"));
//$author = $authorDao->get_by_id(13);
//$new_book = $book;
//$new_book->add_author($author);
//(new bookDAO())->update($book, $new_book);	
$new_genre->add_book($book);
(new genreDAO())->insert($new_genre);	*/
	echo '<br> <a href = "../../index.php">Go back!</a>';
?>
