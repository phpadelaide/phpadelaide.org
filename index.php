<?php

require_once __DIR__.'/silex.phar'; 

$app = new Silex\Application(); 

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));

$app->get('/', function() use($app) { 
    
    $searchUrl = 'http://search.twitter.com/search.json?q=%23phpadelaide&rpp=10&include_entities=true&result_type=mixed';
    $twitterResponse = json_decode(file_get_contents($searchUrl), true);
    
    return $app['twig']->render('index.html.twig', array(
        'tweets' => $twitterResponse['results'],
    ));
}); 

$app->run();