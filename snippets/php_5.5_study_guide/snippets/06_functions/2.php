<?php

function myFunctionA(&$a)
{
	$a++;
}

$b = 1;

myFunctionA($b);

echo 'A) After myFunction($b) [where $b is 1], $b = ' . $b . PHP_EOL;



function myFunctionB($a)
{
	$a += 2;
}

$b = 1;

myFunctionB($b);

echo 'B) After myFunction($b) [where $b is 1], $b = ' . $b . PHP_EOL;



function myFunctionC($a)
{
	$a *= 2;
}

$b = 1;

myFunctionC($b);

echo 'C) After myFunction($b) [where $b is 1], $b = ' . $b . PHP_EOL;


//fatal errors
/*
function myFunctionD($a)
{
	$a *= 2;
}

$b = 1;

myFunctionD(&$b);

echo 'D) After myFunction($b) [where $b is 1], $b = ' . $b . PHP_EOL;
*/