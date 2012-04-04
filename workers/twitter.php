<?php

require_once __DIR__ . '/../bootstrap.php';

$app['db']->executeQuery("CREATE TABLE IF NOT EXISTS `tweets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_str` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `from_user` varchar(255) DEFAULT NULL,
  `from_user_name` varchar(255) DEFAULT NULL,
  `profile_image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;");

$searchUrl = 'http://search.twitter.com/search.json?q=%23phpadelaide&rpp=100&include_entities=true&result_type=mixed';
$twitterResponse = json_decode(file_get_contents($searchUrl), true);

foreach($twitterResponse['results'] as $r) {
    
    $sql = 'SELECT * FROM tweets WHERE id_str = :id_str';
    $stmt = $app['db']->prepare($sql);
    $stmt->bindValue('id_str', $r['id_str']);
    $stmt->execute();
    $tweets = $stmt->fetchAll();
    
    if(!count($tweets)) {
        $sql = 'INSERT INTO tweets 
            (id_str, text, from_user, from_user_name, profile_image_url, created_at) 
            VALUES (:id_str, :text, :from_user, :from_user_name, :profile_image_url, :created_at)';
            
        $insert = $app['db']->prepare($sql);

        $insert->bindValue('id_str', $r['id_str']);
        $insert->bindValue('text', $r['text']);
        $insert->bindValue('from_user', $r['from_user']);
        $insert->bindValue('from_user_name', $r['from_user_name']);
        $insert->bindValue('profile_image_url', $r['profile_image_url']);
        $insert->bindValue('created_at', date('Y-m-d H:i:s', strtotime($r['created_at'])));

        $insert->execute();
    }
}