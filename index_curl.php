<?php
require_once 'vendor/autoload.php';
require_once '/var/www/php-crawler/Functions.php';

use Sunra\PhpSimple\HtmlDomParser;

$url = 'http://applicant-test.us-east-1.elasticbeanstalk.com/';
$useragent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.75 Safari/537.36';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT,$useragent);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); 
$response = curl_exec($ch);

$html = HtmlDomParser::str_get_html($response);
$token = $html->find('//input[@name="token"]')[0]->attr['value'];

$decodedToken = Functions::getResult($token);
var_dump([
    "original-token: {$token}",
    "decoded-token: {$decodedToken}"
]);
$postFields = ["token" => $decodedToken];
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
echo dirname(__FILE__) . '/cookie.txt';

$response = curl_exec($ch);


var_dump($ch);
var_dump($response);

curl_close($ch);
