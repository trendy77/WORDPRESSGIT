<?php

function wpPostXMLRPC($title,$body,$categories=array(1)){
$categories = implode(",", $categories);
$XML = "<title>$title</title>".
"<category>$categories</category>".
$body;
$params = array('','','headlines','ExtJCJn%jRMzl1(5L5W*JBP#',$XML,1);
$request = xmlrpc_encode_request('blogger.newPost',$params);
$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
curl_setopt($ch, CURLOPT_URL, 'https://organisemybiz.com/xmlrpc.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
curl_exec($ch);
curl_close($ch);
}

?>