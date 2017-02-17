<?php

$post_title = $post_content = $post_excerpt = $post_author = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$post_title = test_input($_POST["post_title"]);
  $post_content = test_input('$_POST["post_content"]');
  $post_excerpt = test_input('$_POST["post_excerpt"]');
  wpPostXMLRPC($post_title, $post_content, 'footballBlog')
}
 
function test_input($data) {
  $data = htmlspecialchars($data);
  return $data;
} 

function wpPostXMLRPC($title,$body,$categories=array(1)){
$categories = implode('','', $categories);
$XML = "<title>$title</title>".
"<category>$categories</category>".
$body;
$params = array('','','customkits','t0mzdez2!',$XML,1);
$request = xmlrpc_encode_request('blogger.newPost',$params);
$ch = curl_init();
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
curl_setopt($ch, CURLOPT_URL, 'http://customkitsworldwide/xmlrpc.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
curl_exec($ch);
curl_close($ch);
}

?>