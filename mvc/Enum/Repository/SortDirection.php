<?php

namespace mvc\Enum\Repository;

use MyCLabs\Enum\Enum;

/**
 * Class SortDirection
 * @method static SortDirection ASC()
 * @method static SortDirection DESC()
 * @package mvc\Enum\Repository
 */
class SortDirection extends Enum
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * @return SortDirection
     */
    public function getOppositeDirection()
    {
        return $this->value === self::ASC
            ? self::DESC()
            : self::ASC();
    }
}