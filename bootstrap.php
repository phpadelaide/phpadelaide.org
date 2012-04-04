<?php

if(!isset($_SERVER['APP_MYSQL_HOST']))        $_SERVER['APP_MYSQL_HOST'] = '127.0.0.1';
if(!isset($_SERVER['APP_MYSQL_DB']))          $_SERVER['APP_MYSQL_DB'] = 'phpadelaide';
if(!isset($_SERVER['APP_MYSQL_PASSWORD']))    $_SERVER['APP_MYSQL_PASSWORD'] = '';
if(!isset($_SERVER['APP_MYSQL_USER']))        $_SERVER['APP_MYSQL_USER'] = 'root';

require_once __DIR__.'/silex.phar'; 

$app = new Silex\Application(); 

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
        'driver'    => 'pdo_mysql',
        'host'      => $_SERVER['APP_MYSQL_HOST'],
        'dbname'    => $_SERVER['APP_MYSQL_DB'],
        'user'      => $_SERVER['APP_MYSQL_USER'],
        'password'  => $_SERVER['APP_MYSQL_PASSWORD'],
    ),
    'db.dbal.class_path'    => __DIR__.'/vendor/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__.'/vendor/doctrine-common/lib',
));
