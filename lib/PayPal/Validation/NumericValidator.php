<?php

namespace PayPal\Validation;

use InvalidArgumentException;
/**
 * Class NumericValidator
 *
 * @package PayPal\Validation
 */
class NumericValidator
{

    /**
     * Helper method for validating an argument if it is numeric
     *
     * @param string|null $argumentName
     * @return bool
     */
    public static function validate(mixed $argument, $argumentName = null)
    {
        if (trim($argument) != null && !is_numeric($argument)) {
            throw new InvalidArgumentException("$argumentName is not a valid numeric value");
        }
        return true;
    }
}
