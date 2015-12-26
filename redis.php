<?php
echo "hello";
$redis= new Redis();
$redis->connect("localhost");
$key="person:name";
$n=$redis->lSize($key);
for($i=0;$i<$n;$i++){
	$val=$redis->lGet($key,$i);
	echo "\n";
	echo "value_".$i."=".$val;
}
echo "\n";