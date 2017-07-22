<?php

/*
Null coalescing operator
Shortcut for $username = isset($_GET['user']) ? $_GET['user'] : 'nobody';
Ie. $username = $_GET['user'] ?? 'nobody';
Can also be chained:
$username = $_GET['user'] ?? $_POST['user'] ?? 'nobody';
*/