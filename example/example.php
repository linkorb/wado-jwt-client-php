<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

$url = getenv('URL');
$key = getenv('JWT_KEY');
$algo = getenv('JWT_ALGO');
if (!$url || !$key || !$algo) {
    throw new RuntimeException("Missing required environment variables about the client");
}
$client = new \WadoJwt\Client\Client($url, $key, $algo);


$studyUid = getenv('STUDY_UID');
$seriesUid = getenv('SERIES_UID');
$objectUid = getenv('OBJECT_UID');
$contentType = getenv('CONTENT_TYPE');
if (!$studyUid || !$seriesUid || !$objectUid || !$contentType) {
    throw new RuntimeException("Missing required environment variables about the object");
}

$url = $client->getUrl($studyUid, $seriesUid, $objectUid, $contentType);
echo "URL: $url" . PHP_EOL;
