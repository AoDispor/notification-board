<?php
session_start();
include('note_sender.php');

//validate date	
$current_datetime = date("Y-m-d H:i:s");

//validate notification
//???
$notification = $_POST['notification'];

//validate username
// ???
$phoneid = $_POST['phone-id'];

//validate postal code
// ???
$postalCodes= $_POST['postalCodes'];

//data to be sent
$data = array('body' => $notification, 'title' => 'Ao Dispor');


//after all validation is done connect to DB
$servername="localhost";
$dbname="aodispor";
$username="root";
$password="123456";
$port="3306";
$dbh = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//get all zones and send notification
foreach( $postalCodes as $postalCode ) {
	$stmt = $dbh->prepare("SELECT gcmToken FROM clientTokens where postalCode = :cod");
	$stmt->bindParam(':cod', $postalCode, PDO::PARAM_INT);
	$stmt->execute();
	$tokens = $stmt->fetchAll();

	foreach( $tokens as $token ) 	
		if(sendPushNotification($data, $token['gcmToken']) === false)
		{
			$_SESSION["info_msg"] = "GCM notification failed to send to all (may have sent to some)";
			header("Location: index.php");
			exit();
		}
}

//insert new notification
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

$_SESSION["info_msg"] = "Notification sent and stored";
header( "Location: index.php" );
?>