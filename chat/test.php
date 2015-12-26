<?php
/*
$arr = array('a'=>"snake","b"=>'dog','c'=>'rabbit');
extract($arr);
var_dump($arr);
echo $a." ".$b." ".$c."\n";

$d="people";
$list = compact("a","b","c","d");
var_dump($list);
*/
/* 
function callback($callback) {

	$callback();

}

callback(function() {

	print "This is a anonymous function.<br />\n";

});
	 */
$arr =array(
		"a"=>"111",
		"b"=>"222",
);

$arr=array_reverse($arr);
var_dump($arr);
$arr=array_shift($arr);
var_dump($arr);


