<?php

function fibonacci($x1, $x2)
{
	return $x1 + $x2;
}

$x1 = 0;
$x2 = 1;

for($i = 0; $i < 10; $i++)
{
	echo fibonacci($x1, $x2) . ',';
}

echo PHP_EOL;