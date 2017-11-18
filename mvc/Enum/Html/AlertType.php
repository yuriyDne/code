<?php

namespace mvc\Enum\Html;

use MyCLabs\Enum\Enum;

/**
 * @method AlertType SUCCESS()
 * @method AlertType INFO()
 * @method AlertType WARNING()
 * @method AlertType DANGER()
 * @package mvc\Enum\Html
 */
class AlertType extends Enum
{
    const SUCCESS = 'alert-success';
    const INFO = 'alert-info';
    const WARNING = 'alert-warning';
    const DANGER = 'alert-danger';
}


