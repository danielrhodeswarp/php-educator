<?php

$x = function func($a, $b, $c)
{
	print "$c|$b|$a" . PHP_EOL;
};

print $x(1, 2, 3) . PHP_EOL;