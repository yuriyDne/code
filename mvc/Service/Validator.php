<?php

namespace Service;

use Interfaces\ValidationRuleInterface;
use mvc\Dto\Validator\RuleEmail;
use mvc\Dto\Validator\RuleNotEmptyString;

/**
 * Class Validator
 * @package Service
 */
class Validator
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param ValidationRuleInterface[] ...$rules
     * @return bool
     */
    public function validate(ValidationRuleInterface ...$rules)
    {
        $this->errors = [];
        foreach ($rules as $rule) {
            try {
                if ($rule instanceof RuleNotEmptyString) {
                    $this->notEmptyString(
                        $rule->getFieldName(),
                        $rule->getFieldValue()
                    );
                } elseif ($rule instanceof RuleEmail) {
                    $this->validateEmail($rule->getFieldValue());
                }
            } catch (\InvalidArgumentException $e) {
                $this->errors[$rule->getFieldName()] = $rule->getErrorMessage();
            }
        }

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param $email
     */
    public function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format');
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function notEmptyString($name, $value)
    {
        $this->validateString('name', $name);
        try {
            $this->validateString($name, $value);
            $this->validateNotEmpty($name, $value);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException("$name must be not empty string");
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function validateString($name, $value)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException("$name must be string");
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function validateNotEmpty($name, $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("$name must be not empty");
        }
    }

}