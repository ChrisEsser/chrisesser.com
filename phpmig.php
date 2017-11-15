<?php

use Phpmig\Adapter;
use Pimple\Container;


// load the environment variables
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();


// setup the migrations container
$container = new Container();

$container['db'] = function() {
    $dbh = new PDO('mysql:dbname=' . getenv('DB_NAME') . ';host=' . getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
};

$container['phpmig.adapter'] = function ($c) {
    return new Adapter\PDO\Sql($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;