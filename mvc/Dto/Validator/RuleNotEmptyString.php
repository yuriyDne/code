<?php

namespace mvc\Dto\Validator;

use Interfaces\ValidationRuleInterface;

/**
 * Class RuleNotEmptyString
 * @package mvc\Dto\Validator
 */
class RuleNotEmptyString extends AbstractValidatorRule
{
    /**
     * @var null|string
     */
    private $customErrorMessage;

    /**
     * RuleNotEmptyString constructor.
     * @param string $fieldName
     * @param string|null $value
     * @param string|null $customErrorMessage
     */
    public function __construct(
        string $fieldName,
        string $value = null,
        string $customErrorMessage = null
    ) {
        parent::__construct($fieldName, $value);
        $this->customErrorMessage = $customErrorMessage;
    }

    /**
     * @return null|string
     */
    public function getErrorMessage()
    {
        return $this->customErrorMessage ?? "{$this->fieldName} required";
    }

}