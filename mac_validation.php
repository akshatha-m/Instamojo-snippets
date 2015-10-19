<?php

/*
Author: Ashwini Chaudhary
Program for validating MAC received with Webhook POST request.
 
What is MAC: http://support.instamojo.com/support/solutions/articles/139575-what-is-the-message-authentication-code-in-webhook-
*/

$data = $_POST;
$mac = $data['mac'];  // Get the MAC from the POST data
unset($data['mac']);  // Remove the MAC key from the data.

$ver = explode('.', phpversion());
$major = (int) $ver[0];
$minor = (int) $ver[1];

if($major >= 5 and $minor >= 4){
     ksort($data, SORT_STRING | SORT_FLAG_CASE);
}
else{
     uksort($data, 'strcasecmp');
}

// You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
$str = hash_hmac("sha1", implode("|", $data), "<YOUR_SALT>");

if($str == $mac){
    echo "MAC is fine";
    // Do something here
}


?>
