<?php

//validate date	
$current_datetime = date("Y-m-d H:i:s");
 
if(strtotime($event_date) - strtotime($current_datetime)<0)
{
	header("Location: .php?errorMsg=".urlencode("Data de criação da notificação não é válida"));
	return '';
}

//validate username
// ???
$username = $_POST['usename'];

//validate postal code
// ???
$postalCodes= $_POST['postalCodes'];
//for{}
//$postalCode = ???;

//after all validation is done connect to DB
$dbh = new PDO('mysql:aodispor.db');//database???
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
//check if postal codes exist
foreach( $postalCodes as $postalCode ) {
	$stmt = $dbh->prepare("SELECT COUNT(*) as count from postalCode where postalCodeId = ?");
	$stmt->execute(array($postalCode));
	$countPostalCode = $stmt->fetch();
	$postalCodeExists = ceil($countPostalCode['count']);
	if(postalCodeExists<=0)	//if postal code does not exist, create a new entry
	{
		$stmt = $dbh->prepare("INSERT INTO postalCode VALUES(?)");
		$stmt->execute(array($postalCode));	
	}
}	

//insert new event
$stmt = $dbh->prepare("INSERT INTO notifications VALUES(NULL, ?,?)");
$stmt->execute(array($username,$current_datetime));
$notification_id = $dbh->lastInsertId();

//join postal codes notitication
foreach( $postalCodes as $postalCode ) {
	$stmt = $dbh->prepare("INSERT INTO joinPostalCodeNotifications VALUES(?,?)");
	$stmt->execute(array($notification_id,$postalCode));	
}	
?>