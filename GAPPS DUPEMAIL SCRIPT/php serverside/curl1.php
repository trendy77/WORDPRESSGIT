<?php
//extract data from the post
//set POST variables
$url = 'http://customkitsworldwide.com/xmlrpc.php';
$fields = array(
	'post_title' => urlencode($_POST['post_title']),
	'post_content' => urlencode($_POST['post_content']),
	'post_excerpt' => urlencode($_POST['post_excerpt']),
//	#'company' => urlencode($_POST['institution']),
//	#'age' => urlencode($_POST['age']),
//	#'email' => urlencode($_POST['email']),
//	#'phone' => urlencode($_POST['phone'])
);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);