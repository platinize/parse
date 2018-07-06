<?php

namespace App\Parse;

use Generator;

interface Downloader
{
    public function download(string ...$urls): Generator;
}