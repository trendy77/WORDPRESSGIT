<?php
include "/home/ckww/public_html/IXRLib.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$post_title = $post_content = $post_excerpt = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$post_title = test_input($_POST["post_title"]);
  $post_content = test_input($_POST["post_content"]);
  $post_excerpt = test_input($_POST["post_excerpt"]);
}
 
 function test_input($data) {
  $data = htmlspecialchars($data);
  return $data;
} 
$XmlRpc_result = null;
$url= 'http://customkitsworldwide.com/xmlrpc.php'; // Your XMLRPC Url
$XmlRpc_client = new IXR_Client ($url);
$date = new IXR_Date(strtotime("now")); // writing publish date
$encoding='UTF-8';
$title=$post_title; // your post title
$body=$post_content; // the article content
$category="category1, category2"; // Post category can be seperated by comma seperated. Ensure that these categories exists in your site.
$keywords="double, iikeyword2, keyword3";  // This is tag post
$customfields=array('key'=>'My Xmlrpc', 'value'=>'metaWeblog.newPost'); // Custom field
 
$title = htmlentities($title,ENT_NOQUOTES,$encoding);
$keywords = htmlentities($keywords,ENT_NOQUOTES,$encoding); 
 
$content = array(
             'title'=>$title,
             'description'=>$body,
             'mt_allow_comments'=>0, // 1 to allow comments
             'mt_allow_pings'=>0, // 1 to allow trackbacks
             'post_type'=>'post',
             'mt_keywords'=>$keywords,
             'categories'=>array($category),
             'date_created_gmt' => $date
          );
$params = array(1,'customkits','t0mzdez2!',$content,true); // set true if you need to publish post, set false if you need set your post as draft
 try{
    $XmlRpc_result = $XmlRpc_client->query(
        'metaWeblog.newPost',$params
    );
    $data = $XmlRpc_client->getResponse();
    print_r( $data );
}
 catch (Exception $e){
     var_dump ( $e->getMessage ());
}
 