<?php

namespace mvc\Dto\Validator;

use Interfaces\ValidationRuleInterface;

/**
 * Class AbstractRule
 * @package mvc\Dto\Validator
 */
abstract class AbstractValidatorRule implements ValidationRuleInterface
{
    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var null|string
     */
    protected $value;

    /**
     * RuleNotEmptyString constructor.
     * @param string $fieldName
     * @param string|null $value
     */
    public function __construct(
        string $fieldName,
        string $value = null
    ) {
        $this->fieldName = $fieldName;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @return null|string
     */
    public function getFieldValue()
    {
        return $this->value;
    }

    /**
     * @return null|string
     */
    abstract public function getErrorMessage();
}