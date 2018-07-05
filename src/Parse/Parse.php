<?php

namespace App\Parse;

use Generator;
use GuzzleHttp\ClientInterface;

class Parse implements MetaInterface, TagsInterface
{
    const META_PATERN = '/\<meta.*"(?P<prop>.*)".*"(?P<value>.*)"[^>]*>/';

    /*const SNGLE_TAGS_PATERN = '/<'.$tag.'[^>]*>(?P<value>.*)"[^>]*>/'; */

    const PAIRED_TAGS_PATERN = '/<%s[^>]*>(?P<value>.*)<\/%s>/';

    public function getMeta($contents): Generator
    {
        foreach ($contents as $content) {
            preg_match_all(self::META_PATERN, $content, $matches);
            $meta = array_combine($matches['prop'], $matches['value']);
            yield $meta;
        }
    }

    public function getTags($contents, array $tags): Generator
    {
        foreach ($contents as $key => $content) {
            $result = [];
            foreach ($tags as $tag) {
                $pattern = sprintf(self::PAIRED_TAGS_PATERN, $tag, $tag);
                preg_match_all($pattern, $content, $matches);
                $result[$tag] = $matches['value'];
            }
            yield $result;
        }
    }




}