<?php

namespace mvc\Dto\Validator;

class RuleEmail extends  AbstractValidatorRule
{
    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return 'Invalid email format';
    }
}