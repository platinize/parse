<?php

namespace App\Parser;

use RuntimeException;

class MetaParser implements ParserInterface
{
    const PAIRED_TAGS_PATERN = '/<%s[^>]*>(?P<value>.*)<\/%s>/';

    public function __invoke(string $content)
    {
        preg_match_all(static::PAIRED_TAGS_PATERN, $content, $matches);

        ['props' => $props, 'values' => $values] = $matches;

        return $this->combine($props, $this->filterValues($values));
    }

    protected function filterValues(array $values): array
    {
        return array_map(function (?string $value) {
            return empty($value) && $value !== '0' ? null : $value;
        }, $values);
    }

    protected function combine(array $props, array $values): array
    {
        if (count($props) < count($values)) {
            throw $this->numberOfPropsIsLessThanNumberOfValues($props, $values);
        }

        $values = array_pad($values, count($props), null);

        return array_combine($props, $values);
    }
    
    protected function numberOfPropsIsLessThanNumberOfValues(array $props, array $values): RuntimeException
    {
        return new RuntimeException(sprintf(
            'The number of props is less than the number of values. Props: [`%s`]. Values: [`%s`].',
            implode('`, `', $props),
            implode('`, `', $values)
        ));
    }
}