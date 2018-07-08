<?php

namespace App\Parser;

use RuntimeException;

class TagParser implements ParserTagInterface
{
    const PAIRED_TAGS_PATERN = '/<%s\s*(?P<attributes>[^"]+[^>]*)>(?P<values>.*)<\/%s>/';

    public function __invoke(string $content, string $tag)
    {
        preg_match_all(sprintf(static::PAIRED_TAGS_PATERN, $tag, $tag), $content, $matches);

        ['attributes' => $attributes, 'values' => $values] = $matches;

        return $this->combine($attributes, $this->filterValues($values));
    }

    protected function filterValues(array $values): array
    {
        return array_map(function (?string $value) {
            return empty($value) && $value !== '0' ? null : $value;
        }, $values);
    }

    protected function combine(array $attributes, array $values): array
    {
        if (count($attributes) < count($values)) {
            throw $this->numberOfPropsIsLessThanNumberOfValues($attributes, $values);
        }

        $values = array_pad($values, count($attributes), null);

        return array_combine($attributes, $values);
    }

    protected function numberOfPropsIsLessThanNumberOfValues(array $attributes, array $values): RuntimeException
    {
        return new RuntimeException(sprintf(
            'The number of attribute is less than the number of values. Attribute: [`%s`]. Values: [`%s`].',
            implode('`, `', $attributes),
            implode('`, `', $values)
        ));
    }

}