<?php

namespace Interfaces;

/**
 * Class RuleNotEmptyString
 * @package mvc\Dto\Validator
 */
interface ValidationRuleInterface
{
    /**
     * @return string
     */
    public function getFieldName(): string;

    /**
     * @return mixed
     */
    public function getFieldValue();

    /**
     * @return null|string
     */
    public function getErrorMessage();
}