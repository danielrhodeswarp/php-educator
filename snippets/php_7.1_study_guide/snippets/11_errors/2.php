<?php

function doSomething($a, $b) {
	return $a / $b;
}

try {
	doSomething(1);
} catch (Exception $ex) {
	echo 1 . PHP_EOL;
} catch (ArgumentCountError $ace) {
	echo 2 . PHP_EOL;
} catch (DivisionByZeroError $dbze) {
	echo 3 . PHP_EOL;
}