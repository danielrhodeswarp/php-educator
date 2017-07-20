<?php

$str = '12345';

echo 'String is "' . $str . '"' . PHP_EOL;

echo 'Doing (A) sscanf($str, "%d") on string:' . PHP_EOL;
var_dump(sscanf($str, "%d"));

echo 'Doing (B) sscanf($str, "%d%d%d%d%d") on string:' . PHP_EOL;
var_dump(sscanf($str, "%d%d%d%d%d"));

echo 'Doing (C) sscanf($str, "%1d%1d%1d%1d%1d") on string:' . PHP_EOL;
var_dump(sscanf($str, "%1d%1d%1d%1d%1d"));