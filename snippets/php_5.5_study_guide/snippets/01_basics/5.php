<?php

echo 'phpinfo() =' . PHP_EOL;
phpinfo();

echo 'get_loaded_extensions() =' . PHP_EOL;
VAR_DUMP(get_loaded_extensions());

echo 'get_extension_funcs() =' . PHP_EOL;
VAR_DUMP(get_extension_funcs());

echo 'extension_loaded() =' . PHP_EOL;
VAR_DUMP(extension_loaded());