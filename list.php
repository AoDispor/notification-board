<?php
	//include(".php");
	
	if (isset($_GET['page'])){
		//$page=$_GET['page'];
		$page=filter_input(INPUT_GET,'page',FILTER_SANITIZE_NUMBER_INT);
	} else {
		$page=1;
	}
	
	//get number of pages
	$stmt = $dbh->prepare("SELECT COUNT(*) as count from notifications");
	$stmt->execute(array());
	$pages = $stmt->fetch();
	$npages= $pages['count']/5;
	$npages = ceil($npages); //ceil rounds float up
	
  //get notification
  $stmt = $dbh->prepare("SELECT * from notifications LIMIT 5 OFFSET ?")//order by id ORDER BY event_date LIMIT 5 OFFSET ?");
  $stmt->execute(array(5 * ($page - 1)));
  $events = $stmt->fetchAll();
  
?>