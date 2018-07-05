<?php

namespace Parse

interface ParserInterface
{
    public function getTags(): array;

    public function getMeta(): array;

}

interface DownloaderInterfase
{
    public function download(array $urls): Generator;
}
