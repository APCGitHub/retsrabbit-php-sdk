<?php
require __DIR__.'/src/Anecka/retsrabbit/SplClassLoader.php';

$loader = new SplClassLoader('RetsRabbitClient', '../src/Anecka/retsrabbit');
$loader->register();
