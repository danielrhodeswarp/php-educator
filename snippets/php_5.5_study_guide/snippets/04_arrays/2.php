<?php

$a = array(1, 2, 4, 8);

$b = array(0, 2, 4, 6, 8, 10);

echo count(array_merge(array_diff($a, $b), array_diff($b, $a))) . PHP_EOL;

