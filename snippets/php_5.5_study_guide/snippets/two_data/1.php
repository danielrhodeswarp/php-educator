<?php

$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<node>
	<?var type="string" ?>
	<leaf>Value</leaf>
</node>
<?xml version="1.0" encoding="UTF-8"?>
<node>
	<?var type="string" ?>
	<leaf>Value</leaf>
</node>
XML;

$nodes = new SimpleXMLElement($xml);
