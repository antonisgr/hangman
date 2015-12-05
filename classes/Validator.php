<?php

class Validator
{
    /**
     * Checks if value is not empty
     *
     * @param $value
     * @return bool
     */
    public static function notEmpty($value)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        }
        return true;
    }

    /**
     * Checks if value is alphabetic character.
     *
     * @param $value
     * @return bool
     */
    public static function isAlpha($value)
    {
        return (bool) preg_match('/^\pL+$/u', $value);
    }

    /**
     * Checks if value is numeric.
     *
     * @param $value
     * @return bool
     */
    public static function isNumeric($value)
    {
        return is_numeric($value);
    }

    /**
     * Checks if string is suitable for username (lower/uppercase english letters, numbers, or '_').
     *
     * @param $value
     * @return bool
     */
    public static function isUsername($value)
    {
        return (bool) preg_match('/^[A-Za-z0-9_]+$/', $value);
    }

    /**
     * Checks if value <= maxLength.
     *
     * @param $value
     * @param $maxLength
     * @return bool
     */
    public static function maxLength($value, $maxLength)
    {
        $length = static::stringLength($value);

        return ($length !== false) && $length <= $maxLength;
    }

    /**
     * Returns string's length.
     *
     * @param $value
     * @return bool|int
     */
    private static function stringLength($value) {
        if (!is_string($value)) {
            return false;
        }
        return mb_strlen($value, 'UTF-8');
    }
}
