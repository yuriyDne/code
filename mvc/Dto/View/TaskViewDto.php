<?php

namespace mvc\Dto\View;

use mvc\Dto\Html\PagerDto;
use mvc\Dto\SortOrder;
use mvc\Enum\Repository\SortDirection;
use mvc\Enum\Repository\TaskField;

/**
 * Class TaskViewDto
 * @package mvc\Dto\View
 */
class TaskViewDto
{
    /**
     * @var SortOrder
     */
    private $sortOrder;
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $paramSeparator = '?';
    /**
     * @var PagerDto
     */
    private $pagerDto;

    /**
     * TaskViewDto constructor.
     * @param SortOrder $sortOrder
     * @param PagerDto $pagerDto
     * @param string $baseUrl
     */
    public function __construct(
        SortOrder $sortOrder,
        PagerDto $pagerDto,
        string $baseUrl
    ) {
        $this->sortOrder = $sortOrder;
        $this->baseUrl = $baseUrl;
        if (strpos($this->baseUrl, '?') !== false) {
            $this->paramSeparator = '&';
        }
        $this->pagerDto = $pagerDto;
    }

    /**
     * @param TaskField $field
     * @return string
     */
    public function getOrderLink(TaskField $field)
    {
        $direction = $this->getOrderDirection($field);
        $fieldOrder = new SortOrder($field, $direction);

        return $this->baseUrl. $this->paramSeparator.'order='. $fieldOrder->toString();
    }

    public function getOrderArrow(TaskField $field)
    {
        $direction = $this->getOrderDirection($field);
        return $direction->getValue() === SortDirection::ASC
            ? '&darr;'
            : '&uarr;';
    }

    private function getOrderDirection(TaskField $field)
    {
        return ($this->sortOrder->getFieldName()->getValue() === $field->getValue())
            ? $this->sortOrder->getSortDirection()->getOppositeDirection()
            : SortDirection::DESC();

    }

    /**
     * @return PagerDto
     */
    public function getPagerDto(): PagerDto
    {
        return $this->pagerDto;
    }
}