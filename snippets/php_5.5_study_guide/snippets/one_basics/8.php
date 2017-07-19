<?php

define('CONSTANT', 1);
define('_CONSTANT', 0);

define('EMPTY', '');

if(!empty(EMPTY))	//syntax error as empty() is for *variables*
{
	if(!((boolean)_CONSTANT))
	{
		print "One" . PHP_EOL;
	}
}

else if(constant('CONSTANT') == 1)
{
	print "Two" . PHP_EOL;
}