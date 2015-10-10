<?php
namespace Dropbox;

/**
 * Helper functions to validate arguments.
 *
 * @internal
 */
class Checker
{
    static function throwError($argName, $argValue, $expectedTypeName)
    {
        if ($argValue === null) throw new \InvalidArgumentException("'$argName' must not be null");

        $argTypeName = is_object($argValue) ? get_class($argValue) : gettype($argValue);

        throw new \InvalidArgumentException("'$argName' has bad type; expecting $expectedTypeName, got $argTypeName");
    }

    static function __callStatic($methodName, $arguments)
    {
        $argValue = $arguments[1];
        $argName = $arguments[0];
        $methodName = strtolower(substr($methodName, 3));
        if (!call_user_func('is_' . $methodName, $argValue)) self::throwError($argName, $argValue, $methodName);
    }

    static function argStringOrNull($argName, $argValue)
    {
        if ($argValue === null) return;
        if (!is_string($argValue)) self::throwError($argName, $argValue, "string");
    }

    static function argStringNonEmpty($argName, $argValue)
    {
        if (!is_string($argValue)) self::throwError($argName, $argValue, "string");
        if (strlen($argValue) === 0) throw new \InvalidArgumentException("'$argName' must be non-empty");
    }

    static function argStringNonEmptyOrNull($argName, $argValue)
    {
        if ($argValue === null) return;
        if (!is_string($argValue)) self::throwError($argName, $argValue, "string");
        if (strlen($argValue) === 0) throw new \InvalidArgumentException("'$argName' must be non-empty");
    }

    static function argNat($argName, $argValue)
    {
        if (!is_int($argValue)) self::throwError($argName, $argValue, "int");
        if ($argValue < 0) throw new \InvalidArgumentException("'$argName' must be non-negative (you passed in $argValue)");
    }

    static function argNatOrNull($argName, $argValue)
    {
        if ($argValue === null) return;
        if (!is_int($argValue)) self::throwError($argName, $argValue, "int");
        if ($argValue < 0) throw new \InvalidArgumentException("'$argName' must be non-negative (you passed in $argValue)");
    }

    static function argIntPositive($argName, $argValue)
    {
        if (!is_int($argValue)) self::throwError($argName, $argValue, "int");
        if ($argValue < 1) throw new \InvalidArgumentException("'$argName' must be positive (you passed in $argValue)");
    }

    static function argIntPositiveOrNull($argName, $argValue)
    {
        if ($argValue === null) return;
        if (!is_int($argValue)) self::throwError($argName, $argValue, "int");
        if ($argValue < 1) throw new \InvalidArgumentException("'$argName' must be positive (you passed in $argValue)");
    }
}
