<?php
require_once 'vendor/autoload.php';
require_once '/var/www/php-crawler/Functions.php';

use \GuzzleHttp\Client;
use \GuzzleHttp\Cookie\CookieJar;
use Sunra\PhpSimple\HtmlDomParser;

$url = 'http://applicant-test.us-east-1.elasticbeanstalk.com/';
$useragent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.75 Safari/537.36';

$client = new Client(['cookies' => true]);
$jar = new CookieJar();
$response = $client->request('GET', $url, ['cookies' => $jar]);

$html = HtmlDomParser::str_get_html($response->getBody());
$token = $html->find('//input[@name="token"]')[0]->attr['value'];
$decodedToken = Functions::getResult($token);
var_dump([
    "original-token: {$token}",
    "decoded-token: {$decodedToken}"
]);

$response = $client->request('POST', $url, [
    'form_params' => ['token' => $token],
    'cookies' => $jar,
    'debug' => true
]);
echo $response->getBody();
var_dump($response);