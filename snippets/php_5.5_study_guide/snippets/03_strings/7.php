<?php

$data = 'ĥello woild';

$matches = [];

preg_match('/./u', $data, $matches);

echo $matches[0] . PHP_EOL;