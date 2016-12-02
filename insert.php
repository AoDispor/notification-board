<?php

//validate date	
$current_datetime = date("Y-m-d H:i:s");

//validate username
// ???
$phoneid = $_POST['phone-id'];

//validate postal code
// ???
$postalCodes= $_POST['postalCodes'];
//for{}
//$postalCode = ???;

//after all validation is done connect to DB
$servername="localhost";
$dbname="aodispor";
$username="root";
$password="123456";
$port="3306";
$dbh = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
//check if postal codes exist
foreach( $postalCodes as $postalCode ) {
	$stmt = $dbh->prepare("SELECT COUNT(*) as count from postalCode where postalCodeId = :cod");
	$stmt->bindParam(':cod', $postalCode, PDO::PARAM_INT);
	$stmt->execute();
	$countPostalCode = $stmt->fetch();
	$postalCodeExists = $countPostalCode['count'];
	echo $postalCodeExists;
	if($postalCodeExists<=0)	//if postal code does not exist, create a new entry
	{
		$stmt = $dbh->prepare("INSERT INTO postalCode VALUES(:cod)");
		$stmt->bindParam(':cod', $postalCode, PDO::PARAM_INT);
		$stmt->execute();
	}
}	

//insert new event
$stmt = $dbh->prepare("INSERT INTO notifications VALUES(NULL, ?,?)");
$stmt->execute(array($phoneid,$current_datetime));
$notification_id = $dbh->lastInsertId();

//join postal codes notitication
foreach( $postalCodes as $postalCode ) {
	$stmt = $dbh->prepare("INSERT INTO joinPostalCodeNotifications VALUES(:notif,:cod)");
	$stmt->bindParam(':notif', $notification_id, PDO::PARAM_INT);
	$stmt->bindParam(':cod', $postalCode, PDO::PARAM_INT);
	$stmt->execute();	
}	

header( "Location: index.php" );
?>