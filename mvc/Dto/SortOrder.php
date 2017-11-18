<?php

namespace mvc\Dto;

use mvc\Enum\Repository\SortDirection;
use MyCLabs\Enum\Enum;

class SortOrder
{
    /**
     * @var Enum
     */
    private $fieldName;
    /**
     * @var SortDirection
     */
    private $sortDirection;

    /**
     * SortOrder constructor.
     * @param Enum $fieldName
     * @param SortDirection $sortDirection
     */
    public function __construct(Enum $fieldName, SortDirection $sortDirection)
    {
        $this->fieldName = $fieldName;
        $this->sortDirection = $sortDirection;
    }

    /**
     * @return Enum
     */
    public function getFieldName(): Enum
    {
        return $this->fieldName;
    }

    /**
     * @return SortDirection
     */
    public function getSortDirection(): SortDirection
    {
        return $this->sortDirection;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->getFieldName()->getValue().'|'.$this->getSortDirection()->getValue();
    }
}