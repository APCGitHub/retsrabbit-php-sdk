<?php
require __DIR__.'/src/Anecka/retsrabbit/SplClassLoader.php';

$loader = new SplClassLoader('Anecka', array('../vendor', '../src'));
$loader->register();
