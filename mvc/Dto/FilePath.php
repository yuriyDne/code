<?php

namespace mvc\Dto;

use lib\Exception\FileNotFoundException;

class FilePath
{
    /**
     * @var string
     */
    private $path;

    /**
     * FilePath constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        if (!is_file($path)) {
            throw new FileNotFoundException($path);
        }
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}