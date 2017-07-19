<?php

$streams = [
	'php://stdin',
	'php://stdout',
	'php://stderr',
	'php://input',
	'php://output',
	'php://error',
];

foreach($streams as $stream)
{

	echo "Attempting to open stream {$stream} for reading:" . PHP_EOL;

	fopen($stream, 'r');

	echo "Attempting to open stream {$stream} for writing:" . PHP_EOL;

	fopen($stream, 'w');
}