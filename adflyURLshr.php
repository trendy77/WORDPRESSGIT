<?php

/* adf.ly url shortening... on the fly... */

function shortenMyLinks(){
	if(isset($_POST['submit'])){
		$uid = "15466373";
		$key = "52dd6931ee3effcf5cb5773ddf367012";
		$url = trim($_POST['url']);
		$return = adflyShortenURL($url, $uid, $key);
	}
}

	function adflyShortenURL($url, $uid, $key){
		$apiURL = 'http://api.adf.ly/api.php?';
		// api queries
		$query = array(
			'key' => $key,
			'uid' => $uid,
			'advert_type' => 'int',
			'domain' => 'j.gs'
		);
		// full api url with query string
		$apiURL = $apiURL . http_build_query($query).'&url='.$url;

		// get data
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );

		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	 	}
		}
?>
