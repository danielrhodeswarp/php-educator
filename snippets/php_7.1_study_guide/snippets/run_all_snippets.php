<?php

//using glob() as the fancy SPL DirectoryIterator stuff doesn't
//sort the matches!
$snippets = glob('./*/*.php');

foreach($snippets as $snippetName)
{
    echo "----------------" . PHP_EOL;
	echo "Snippet {$snippetName} gives:" . PHP_EOL;

    //passthru()?
    $output = [];
    exec("php {$snippetName}", $output, $return);

    echo implode(PHP_EOL, $output) . PHP_EOL;
}
