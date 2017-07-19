<?php

$array = array(array(1, 2), 'a' => array('b' => 1, 'c'));

echo 'Doing $array[] = 1' . PHP_EOL;
$array[] = 1;

echo 'Doing echo $array[5][2]' . PHP_EOL;
echo $array[5][2] . PHP_EOL;

echo 'Doing echo $array[5][2] = 2' . PHP_EOL;
echo ($array[5][2] = 2) . PHP_EOL;

echo 'Doing isset($array[7][3][1])' . PHP_EOL;
isset($array[7][3][1]);