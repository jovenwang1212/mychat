<meta http-equiv="Cache-control" content="public">
<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
opcache_reset();
	$a=array();
	$b=array(
		"1",
		"2"=>2222
	);
	$c=array('sam');
	$b[]=$c[0];
	$a=$b;
	$a=array_reverse($a); 
	var_dump($a);
	
