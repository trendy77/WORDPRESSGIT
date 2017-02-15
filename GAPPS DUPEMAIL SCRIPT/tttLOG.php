<?php

$dbuser = ‘root’;
$dbpass = 'Hello1212!';
$dbname = 'organ151_72f';

// Create connection
$conn = new mysqli('192.249.127.115', organ151_7, 'Hello1212!', 'organ151_72f');
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO 7c3_posts (post_title, post_author, post_content, post_excerpt, post_tags) VALUES ('".$_POST["post_title"]."','".$_POST["post_author"]."','".$_POST["post_content"]."','".$_POST["post_excerpt"]."','".$_POST["post_tags"]."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>