<?php

namespace mvc\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class TaskStatus
 * @method static NEW()
 * @method static COMPLETED()
 * @package mvc\Enum
 */
class TaskStatus extends Enum
{
    const NEW = 0;
    const COMPLETED = 1;
}