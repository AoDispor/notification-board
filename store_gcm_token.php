<?php
$data=(json_decode(file_get_contents('php://input')));
if(!isset($data))
{
	echo "INVALID REQUEST";
	exit;	
}

$postal_code = $data->{'postal_code'};
$gcm_token = $data->{'gcm_token'};

if(!isset($postal_code)||!isset($gcm_token))
{
	echo "INVALID REQUEST";
	exit;	
}

//after all validation is done connect to DB
$servername="localhost";
$dbname="aodispor";
$username="root";
$password="123456";
$port="3306";
$dbh = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//check if already exists and insert if not
$stmt = $dbh->prepare("SELECT COUNT(*) as count from clientTokens where gcmToken = :tok");
$stmt->bindParam(':tok', $gcm_token, PDO::PARAM_STR,160);
$stmt->execute();
$countTokens = $stmt->fetch();
$tokenExists = $countTokens['count'];
	
if($tokenExists<=0)	//create
	{
		$stmt = $dbh->prepare("INSERT INTO clientTokens VALUES(:tok,:cod)");
		$stmt->bindParam(':tok', $gcm_token, PDO::PARAM_STR,160);
		$stmt->bindParam(':cod', $postal_code, PDO::PARAM_INT);
		$stmt->execute();	
	}
else //update
	{
		$stmt = $dbh->prepare("UPDATE clientTokens SET postalCode = :cod where gcmToken = :tok");
		$stmt->bindParam(':cod', $postal_code, PDO::PARAM_INT);
		$stmt->bindParam(':tok', $gcm_token, PDO::PARAM_STR,160);
		$stmt->execute();	
	}
	
echo "OK";
?>