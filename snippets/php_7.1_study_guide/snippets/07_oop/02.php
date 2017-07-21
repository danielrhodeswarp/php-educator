<?php

interface Interface1
{
	public function getFoo();
	public function setFoo($value);
}

interface Interface2
{
	public function getFoo();
	public function setBar();
}

class Baz implements Interface1, Interface2
{
	public function getFoo()
	{
		return 'foo';
	}

	function setFoo($value)
	{
		$this->foo = $value;
	}

	function setBar($value)
	{
		$this->bar = $bar;
	}
}

$baz = new Baz();
$baz->getFoo();