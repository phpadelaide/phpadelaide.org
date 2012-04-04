<?php

$app = require __DIR__ . '/../src/bootstrap.php';

$app->get('/', function() use($app) { 
    $searchUrl = 'http://search.twitter.com/search.json?q=%23phpadelaide&rpp=100&include_entities=true&result_type=mixed';
    $twitterResponse = json_decode(file_get_contents($searchUrl), true);
    
    return $app['twig']->render('index.html.twig', array(
        'tweets' => $twitterResponse['results'],
    ));
});

$app->get('/test', function() use($app) { 
    $sql = 'SELECT * FROM tweets ORDER BY created_at DESC';
    $stmt = $app['db']->query($sql);
    $tweets = $stmt->fetchAll();

    return $app['twig']->render('index.html.twig', array(
        'tweets' => $tweets,
    ));
});

return $app;