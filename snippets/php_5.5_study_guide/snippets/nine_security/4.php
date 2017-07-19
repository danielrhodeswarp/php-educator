<?php

echo htmlspecialchars($_GET['name']);

?>

<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Reload</a>

<?php

echo PHP_EOL;
