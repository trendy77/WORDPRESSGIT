<?php
//fakenews
//$dbuser = ‘organli6_t77’;
//$dbpass = 'queenLizisa10!';
//$dbname = 'organli6_fake';
//$ip='66.147.244.89';
//$table_prefix = '7c3_  **/

// orgbiz
$dbuser = 'organ_remote';
$dbpass = 'Hello1212!';
$dbname = 'organ151_72f';
$ip = '192.249.127.115';
//$table_prefix = '7c3_  **/

//orgbizESP   //$table_prefix = 'dd7' **/
//$dbuser = 'organ151_77esf';
//$dbpass = 'Joker999!';
//$dbname = 'organ151_77es';


//vapedirectory
//$dbuser = ‘organ151_vape’;
//$dbpass = 't0mzdez2!';
//$dbname = 'organ151_vape';
//$table_prefix = '_7' **/
//CKWW
// define variables and set to empty values
$post_title = $post_content = $post_excerpt = $post_author = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$post_title = test_input($_POST["post_title"]);
  $post_content = test_input($_POST["post_content"]);
  $post_excerpt = test_input($_POST["post_excerpt"]);
}
 
 function test_input($data) {
  $data = htmlspecialchars($data);
  return $data;
} 
  
// Create connection
$conn = mysqli_connect("localhost", "ckww_77c", "t0mzdez2!", "ckww_77");
// Check connection
if (mysqli_connect_errno) {
echo "Connection failed: " . mysqli_connect_error();
} 
mysqli_query($conn,"INSERT INTO 7c3_posts (post_title, post_author, post_content, post_excerpt)
VALUES ($post_title,$post_content,$post_excerpt)";

// Commit transaction
mysqli_commit($conn);
echo "success";
// Close connection
mysqli_close($conn);

?>