<?php

namespace mvc\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class AssetType
 * @method static AssetType CORE
 * @method AssetType ADMIN
 * @package mvc\Enum
 */
class AssetType extends Enum
{
    const CORE = 'core';
    const ADMIN = 'Admin';
}