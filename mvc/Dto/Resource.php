<?php

namespace mvc\Dto;

use mvc\Enum\FileType;

class Resource
{
    /**
     * @var FilePath
     */
    private $path;
    /**
     * @var FileType
     */
    private $type;

    /**
     * Resource constructor.
     * @param FilePath $path
     * @param FileType $type
     */
    public function __construct(
        FilePath $path,
        FileType $type
    ) {

        $this->path = $path;
        $this->type = $type;
    }

    /**
     * @return FilePath
     */
    public function getPath(): FilePath
    {
        return $this->path;
    }

    /**
     * @return FileType
     */
    public function getType(): FileType
    {
        return $this->type;
    }
}