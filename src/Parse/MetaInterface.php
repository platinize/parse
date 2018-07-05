<?php

namespace App\Parse;

use Generator;

interface MetaInterface
{
    public function getMeta(array $urls): Generator;
}

