
<?php 
	include("lib/xmlrpc.inc");
	$function_name = "wp.newPost";
	$url = "https://organisemybiz.com/xmlrpc.php";
	$client = new xmlrpc_client($url);
	$client->return_type = 'phpvals';

	$message = new xmlrpcmsg(
			$function_name, 
			array(
				new xmlrpcval(0, "int"), 
				new xmlrpcval("headlines", "string"), 
				new xmlrpcval("ExtJCJn%jRMzl1(5L5W*JBP#", "string"), 
				new xmlrpcval(
					array(
						"post_type" => new xmlrpcval("post", "string"), 
						"post_status" => new xmlrpcval("draft", "string"), 
						"post_title" => new xmlrpcval("Sitepoint is Awesome", "string"), 
						"post_author" => new xmlrpcval(1, "int"), 
						"post_excerpt" => new xmlrpcval("excerpt", "string"), 
						"post_content" => new xmlrpcval("content", "string")
						), 
					"struct"
					)
				)
			);

	$resp = $client->send($message);

	if ($resp->faultCode()) echo 'KO. Error: '.$resp->faultString(); else echo "Post id is: " . $resp->value();
?>
