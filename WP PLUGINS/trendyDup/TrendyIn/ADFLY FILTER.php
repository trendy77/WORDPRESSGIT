<?php
   /*
   Plugin Name: TrendPonential
   Plugin URI: http://organisemybiz.com
   Description: actions to admin menu, shorten url @ post time ...
   Author: RevDr T.D.A.Mos-Def Fisher, Esq
   Author URI: http://organisemybiz.com
   License: GPL2
   */

 add_filter('content', 'adflyShorten')

function adflyShorten(){
  $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
if (preg_match_all("/$regexp/siU", $the_content, $matches, PREG_SET_ORDER)){
   foreach($matches as $match) {
	$match = 'http://adf.ly/15466373/' + $match;
	}
  }
 }

?>