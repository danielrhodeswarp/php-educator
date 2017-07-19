<?php

$dh = opendir(".");

while($file = readdir($dh))
{
	echo $file . PHP_EOL;
}