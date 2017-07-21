<?php

$one = array('one', 'two', 'three');

$two = array(1, 2, 3);

echo 'array_combine($one, $two) =' . PHP_EOL;
VAR_DUMP(array_combine($one, $two));

echo 'array_merge($one, $two) =' . PHP_EOL;
VAR_DUMP(array_merge($one, $two));

echo 'array_values($two) =' . PHP_EOL;
VAR_DUMP(array_values($two));

echo 'array_flip($one) =' . PHP_EOL;
VAR_DUMP(array_flip($one));