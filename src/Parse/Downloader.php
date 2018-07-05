<?php

namespace App\Parse;

use Generator;
use GuzzleHttp\ClientInterface;

class Downloader
{
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getUrls(array $urls): Generator
    {
        foreach ($urls as $url) {
            yield $this->client->get($url);
        }
    }

    public function getBodies(array $urls): Generator
    {
        $urls = $this->getUrls($urls);

        foreach ($urls as $url) {
            yield $url->getBody();
        }
    }

}