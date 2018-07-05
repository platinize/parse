#!/usr/bin/php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Parse\Parse;
use App\Parse\Downloader;
use GuzzleHttp\Client;

$urls = [
    'http://www.11x11.ru/',
    'http://www.butsa.ru/',
    'http://hrunserzne.ru/'
];

$tagsArr = ['a', 'h1', 'h2'];

/*

$parse = new Parse(new Client());

$parse->startParse($urls, $tags);


$downloader = new Downloader(new Client);
$content = $downloader->getBodies();

$parser = new Parse();
$parser->getMetaTags($content);
*/

$load = new Downloader(new Client());
$parser = new Parse();

$bodies = $load->getBodies($urls);

$metas = $parser->getMeta($bodies);

foreach ($metas as $meta) {
    print_r($meta);
}

$load = new Downloader(new Client());
$parser = new Parse();

$bodies = $load->getBodies($urls);

$tags = $parser->getTags($bodies, $tagsArr);

foreach ($tags as $tag) {
    print_r($tag);
}

?>