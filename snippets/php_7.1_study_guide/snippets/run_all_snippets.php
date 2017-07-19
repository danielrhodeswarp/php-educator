<?php

//ini_set('error_reporting', 'E_ALL');

//http://stackoverflow.com/questions/1900208/php-custom-error-handler-handling-parse-fatal-errors#7313887
//catch parse and fatal errors
/*
register_shutdown_function("shutdownHandler");

function shutdownHandler() //will be called when php script ends.
{
	$lasterror = error_get_last();

	var_dump($lasterror);
}
*/

//this is cool but won't catch parse or fatal errors
function exception_error_handler($severity, $message, $file, $line) {
    
    /*
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        //echo 'YAddA';
        return;
    }
    */
    
    //throw new ErrorException($message, 0, $severity, $file, $line);
    
    echo '****' . PHP_EOL;
    echo '* Important! PHP was not happy with something:' . PHP_EOL;
	echo '* ' . get_error_type_name($severity) . ': ' . $message . PHP_EOL;
	echo '****' . PHP_EOL;
	
	//return;
}
set_error_handler("exception_error_handler");

//mine
function get_error_type_name($errorTypeValue)
{
	//error names (excludes the container error "E_ALL")
	$errors = [
		'E_ERROR',
		'E_WARNING',
		'E_PARSE',
		'E_NOTICE',
		'E_CORE_ERROR',
		'E_CORE_WARNING',
		'E_COMPILE_ERROR',
		'E_COMPILE_WARNING',
		'E_USER_ERROR',
		'E_USER_WARNING',
		'E_USER_NOTICE',
		'E_STRICT',
		'E_RECOVERABLE_ERROR',
		'E_DEPRECATED',
		'E_USER_DEPRECATED'
	];

	$map = [];

	foreach($errors as $error)
	{
		$map[constant($error)] = $error;
	}

	return $map[$errorTypeValue];
}

//from php.net comment wall
function FriendlyErrorType($type) 
{ 
    switch($type) 
    { 
        case E_ERROR: // 1 // 
            return 'E_ERROR'; 
        case E_WARNING: // 2 // 
            return 'E_WARNING'; 
        case E_PARSE: // 4 // 
            return 'E_PARSE'; 
        case E_NOTICE: // 8 // 
            return 'E_NOTICE'; 
        case E_CORE_ERROR: // 16 // 
            return 'E_CORE_ERROR'; 
        case E_CORE_WARNING: // 32 // 
            return 'E_CORE_WARNING'; 
        case E_COMPILE_ERROR: // 64 // 
            return 'E_COMPILE_ERROR'; 
        case E_COMPILE_WARNING: // 128 // 
            return 'E_COMPILE_WARNING'; 
        case E_USER_ERROR: // 256 // 
            return 'E_USER_ERROR'; 
        case E_USER_WARNING: // 512 // 
            return 'E_USER_WARNING'; 
        case E_USER_NOTICE: // 1024 // 
            return 'E_USER_NOTICE'; 
        case E_STRICT: // 2048 // 
            return 'E_STRICT'; 
        case E_RECOVERABLE_ERROR: // 4096 // 
            return 'E_RECOVERABLE_ERROR'; 
        case E_DEPRECATED: // 8192 // 
            return 'E_DEPRECATED'; 
        case E_USER_DEPRECATED: // 16384 // 
            return 'E_USER_DEPRECATED'; 
    } 
    return ""; 
}

$snippetsPerSection = [];
$snippetsPerSection['one_basics'] = [1, 2, '3c', 4, 5, /*8*/];	//8 parse errors (and this whole script dies)
$snippetsPerSection['two_data'] = [/*1,*/ 3, 6];
$snippetsPerSection['three_strings'] = [2, 3, 4, 5, 6, 7, 9];
$snippetsPerSection['four_arrays'] = [1, 2, 3, 4, 6];
$snippetsPerSection['five_io'] = [2, 4, 5];
$snippetsPerSection['six_functions'] = [1, 2, 3, 4, 5, /*6*/];	//6 parse errors
$snippetsPerSection['seven_oop'] = [/*2, 3,*/10];	//2 fatal errors (as does 3)
$snippetsPerSection['nine_security'] = [4, 9];

foreach($snippetsPerSection as $section => $snippets)
{
	foreach($snippets as $snippet)
	{
		$snippetName = "{$section}/{$snippet}.php";

		echo "Snippet {$snippetName} gives:" . PHP_EOL;

		try
		{
			require_once("./{$snippetName}");
		}

		catch(Exception $exception)
		{
			echo '*Important*, something goofed:' . PHP_EOL;
			var_dump($exception);
		}

		echo "-----------------" . PHP_EOL;
	}
}