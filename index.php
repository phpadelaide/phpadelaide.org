<?php

require_once 'bootstrap.php';

$app->get('/', function() use($app) { 
    $sql = 'SELECT * FROM tweets ORDER BY created_at DESC';
    $stmt = $app['db']->query($sql);
    $tweets = $stmt->fetchAll();

    return $app['twig']->render('index.html.twig', array(
        'tweets' => $tweets,
    ));
}); 

$app->run();