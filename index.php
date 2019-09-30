<?php
require_once 'vendor/autoload.php';
require_once '/var/www/php-crawler/Functions.php';

use \Goutte\Client;
use \GuzzleHttp\Client as GuzzleClient;
use \GuzzleHttp\Cookie\CookieJar;
use \Symfony\Component\DomCrawler\Crawler;

$url = 'http://applicant-test.us-east-1.elasticbeanstalk.com/';
$useragent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.75 Safari/537.36';
$headers = [
    'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
    'Accept-Encoding' => 'gzip, deflate, sdch', 
    'Accept-Language' => 'en-US,en;q=0.9,pt-BR;q=0.8,pt;q=0.7', 
    'Cache-Control'   => 'no-cache',
    'Connection' => 'keep-alive',
    'Content-Type' => 'application/x-www-form-urlencoded',
    'Pragma' => 'no-cache',
    'Referer' => 'http://applicant-test.us-east-1.elasticbeanstalk.com/',
    'User-Agent' => $useragent,
    'Origin' => 'http://applicant-test.us-east-1.elasticbeanstalk.com/',
];


$client = new Client();
$guzzleClient = new GuzzleClient([
    'timeout' => 60,
    'cookies' => true,
    'allow-redirects' => true,
    'keep-alive' => 300,
    'headers' => $headers
]);
$client->setClient($guzzleClient);
$crawler = $client->request('GET', $url);
$content = $client->getResponse()->getContent();
var_dump($content);

$node = $crawler->filter('#token')->first();
$token = $crawler->filter('#token')->first()->attr('value');

$crawler->filter('#token')->each(function(Crawler $crawler){ 
    foreach ($crawler as $node) {
        $node->parentNode->removeChild($node);
    }
});
$decodedToken = Functions::getResult($token);
var_dump([
    "original-token: {$token}",
    "decoded-token: {$decodedToken}"
]);

$content = preg_replace('/id="token"\s*value="(.*)"/', "id=\"token\" value=\"{$decodedToken}\"", $content);
$crawler->clear();
$crawler->addHtmlContent($content);

$submitButton = $crawler->selectButton('Descobrir resposta');
$form = $submitButton->form();
$crawler = $client->submit($form, ['token' => $decodedToken]);
var_dump($crawler->html());
