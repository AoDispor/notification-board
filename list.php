<?php
	//include(".php");
	
	$servername="localhost";
	$dbname="aodispor";
	$username="root";
	$password="123456";
	$port="3306";
	
	//after all validation is done connect to DB

	$dbh = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
	$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//$dbh=$conn = new mysqli("localhost", "root", "123456", "aodispor");
	
	$page=1;
	
	if (isset($_GET['page'])){
		//$page=$_GET['page'];
		$page=filter_input(INPUT_GET,'page',FILTER_SANITIZE_NUMBER_INT);
	} else {
		$page=1;
	}
	
	//get number of pages
	$stmt = $dbh->prepare("SELECT COUNT(*) as count from notifications");
	$stmt->execute();
	$pages = $stmt->fetch();
	$npages= $pages['count']/50;
	$npages = ceil($npages); //ceil rounds float up
	
  //get notification
  $stmt = $dbh->prepare("SELECT * from notifications LIMIT 50 OFFSET  :offs");//order by id ORDER BY event_date LIMIT 5 OFFSET ?");
  if(!$stmt) return;
  $offset=50 * ($page - 1);
  $stmt->bindParam(':offs', $offset, PDO::PARAM_INT);
  $stmt->execute();
  $notifications = $stmt->fetchAll();
  $notifications = array_reverse($notifications);
?>