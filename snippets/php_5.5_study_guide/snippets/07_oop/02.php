<?php

interface myBaseClass1
{
	public function doSomething();
	public function specialFunction1();
}

interface myBaseClass2
{
	public function doSomething($special);
	public function specialFunction2();
}

class myClassA implements myBaseClass1, myBaseClass2
{
	function doSomething()
	{
		echo '...' . PHP_EOL;
	}

	function mySpecialFunction1()
	{
		echo '...' . PHP_EOL;
	}

	function mySpecialFunction2()
	{
		echo '...' . PHP_EOL;
	}
}

$a = new myClassA();
$a->doSomething();