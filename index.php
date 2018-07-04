#!/usr/bin/php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Parse\Parse;

$urls = [
    'http://www.11x11.ru/',
    'http://www.butsa.ru/',
    'http://hrunserzne.ru/'
];

$tags = ['a', 'h1', 'h2'];

$parse = new Parse();

$parse->startParse($urls, $tags);

?>