<?php

namespace App\Parse;

use Generator;
use GuzzleHttp\Client;

class Parse
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    protected function getUrls(array $urls): Generator
    {
        foreach ($urls as $url) {
            yield $this->client->get($url);
        }
    }

    protected function getBodies(array $urls): Generator
    {
        $urls = $this->getUrls($urls);
        foreach ($urls as $url) {
            yield $url->getBody();
        }
    }

    protected function getMeta(array $urls): Generator
    {
        $pattern = '/\<meta.*"(?P<prop>.*)".*"(?P<value>.*)"[^>]*>/';
        $contents = $this->getBodies($urls);
        foreach ($contents as $content) {
            preg_match_all($pattern, $content, $matches);
            $meta = array_combine($matches['prop'], $matches['value']);
            yield $meta;
        }
    }

    protected function getTags(array $urls, array $tags): Generator
    {
        $contents = $this->getBodies($urls);
        foreach ($contents as $key => $content) {
            $result = [];
            foreach ($tags as $tag) {
                $pattern = '/<' . $tag . '[^>]*>(?P<value>.*)<\/' . $tag . '>/';
                preg_match_all($pattern, $content, $matches);
                $result[$tag] = $matches['value'];
                if (!$result[$tag]) {
                    $pattern = '/<' . $tag . '[^>]*>(?P<value>.*)"[^>]*>/';
                    preg_match_all($pattern, $content, $matches);
                    $result[$tag] = $matches['value'];
                }
            }
            yield $result;
        }
    }

    public function startParse(array $urls, array $tags)
    {
        $metas = $this->getMeta($urls);
        $tags = $this->getTags($urls, $tags);
        foreach ($metas as $key => $meta) {
            echo $urls[$key].PHP_EOL;
            echo 'meta'.PHP_EOL;
            print_r((array)$meta);
        }
        foreach ($tags as $key => $tag) {
            echo $urls[$key].PHP_EOL;
            echo 'tags'.PHP_EOL;
            print_r((array)$tag);
        }
    }




}