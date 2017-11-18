<?php

namespace mvc\Enum\Repository;

use MyCLabs\Enum\Enum;

/**
 * Class TaskField
 * @method static TaskField ID()
 * @package mvc\Enum\Repository
 */
class TaskField extends Enum
{
    const ID = 'id';
    const USER_NAME = 'userName';
    const EMAIL = 'email';
    const DESCRIPTION = 'description';
    const IMAGE = 'image';
    const STATUS = 'status';

}