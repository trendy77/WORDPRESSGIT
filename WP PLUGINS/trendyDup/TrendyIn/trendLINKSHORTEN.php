<?php
/*
Plugin Name: TrendyIn2.0
Description: Site specific code changes 
*/
/* Start Adding Functions Below this Line */

  
add_filter( 'wp_insert_post_data' , 'filter_post_data' , '99', 2 );


function filter_post_data( $data , $postarr ) {
   $content = $data['post_content'];
$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
  if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
    foreach($matches as $match) {
		shst($match);
	}
  }

function shst($url){
    $key="e3d8f30095c3b5f56af57eba685359d5";//your key
    $curl_url = "https://api.shorte.st/s/".$key."/".$url;
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $curl_url); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $result = curl_exec($ch); 
    curl_close($ch); 
    $array = json_decode($result);
    $shortest = $array->shortenedUrl;
    return $shortest;
}

?>