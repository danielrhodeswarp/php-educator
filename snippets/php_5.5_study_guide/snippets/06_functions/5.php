<?php

function func($x, $x = 1, $x = 2)
{
	return $x;
}

print func(3) . PHP_EOL;