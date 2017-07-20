<?php

namespace myapp\utils\hello;

function world()
{
	echo "Hullo world" . PHP_EOL;
}

namespace myapp;

use myapp\utils\hello\world as summat;

summat\world();