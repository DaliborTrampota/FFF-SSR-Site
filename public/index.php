<?php

$autoloader = require_once '../vendor/autoload.php';


$logger = new Log('../debug.log');

$base = \Base::instance();
$base->config('../app/configs/config.ini');
$base->set('DB', new \DB\SQL($base->get('db.dsn'),$base->get('db.username'),$base->get('db.password')));

$base->set('logger', $logger);

$base->run();