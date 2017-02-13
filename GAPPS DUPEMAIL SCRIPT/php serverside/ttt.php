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

// Create connection
$conn = new mysqli($ip, $dbuser, $dbpass, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO 7c3_posts (post_title, post_author, post_content, post_excerpt) VALUES ('".$_POST["post_title"]."','".$_POST["post_author"]."','".$_POST["post_content"]."','".$_POST["post_excerpt"]."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>