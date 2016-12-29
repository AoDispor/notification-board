<?php

function sendPushNotification($data, $id) {
    // Insert real GCM API key from the Google APIs Console
    // https://code.google.com/apis/console/        

	$apiKey = 'AIzaSyDN5kBeRswvs1cdj415tZUnXUOcc1DTLC4';
	
    // Set POST request body
    $post = array(
                    'to'  => $id,
                    'notification' => $data
                 );

    // Set CURL request headers 
    $headers = array( 
                        'Authorization:key=' . $apiKey,
                        'Content-Type:application/json'
                    );

    // Initialize curl handle       
    $ch = curl_init();

    // Set URL to GCM push endpoint     
    curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');

    // Set request method to POST       
    curl_setopt($ch, CURLOPT_POST, true);

    // Set custom request headers       
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Get the response back as string instead of printing it       
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set JSON post data
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
	
	// Ignore certificate authenticity
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	
    // Actually send the request    
    $result = curl_exec($ch);

    // Handle errors
    if (curl_errno($ch)) {
        echo 'GCM error: ' . curl_error($ch);
    }

    // Close curl handle
    curl_close($ch);

    // Debug GCM response      	
    echo $result;
}

?>