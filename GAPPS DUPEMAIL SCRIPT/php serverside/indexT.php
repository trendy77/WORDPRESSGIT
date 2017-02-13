// send in the header like this:
//@slug: this-is-my-slug
//@tags: Just, A, Few, Tags
//@categories: My Category One, My Category Two
//@excerpt: This is my excerpt where I sum up the article's major points.
//# My Blogpost's Headline

<?php
require_once 'inc/newTPost.php';
$htmlString = $_SERVER['KMVAR_blogString'];
$identifier = $_SERVER['KMVAR_blogIdentifier'];
$obj = new EnnoAutoPost($htmlString, $identifier);
$obj->setMetadata();
$obj->replaceImageMarkup();
echo $obj->createPost();