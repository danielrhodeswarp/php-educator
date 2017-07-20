<?php

$a = array(1, 2, 3);

foreach($a as $x)
{
	$x *= 2;
}

echo $a[0] * $a[1] * $a[2] . PHP_EOL;