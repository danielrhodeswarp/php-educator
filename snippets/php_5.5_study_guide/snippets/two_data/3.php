<?php

$doc = new DOMDocument();

$doc->loadXML('<root />');

$el = $doc->createElement('test', 'some value');

echo $doc->saveXML();