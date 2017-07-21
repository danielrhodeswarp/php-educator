<?php

namespace myapp\utils\hello;

function world()
{
	echo "Hullo world" . PHP_EOL;
}

namespace myapp;

use utils\hello as summat;

summat\world();