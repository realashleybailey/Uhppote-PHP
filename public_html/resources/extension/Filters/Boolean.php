<?php

namespace UhppotePHP\Extensions\Filters;

class Boolean implements \Elegant\Sanitizer\Contracts\Filter
{
    /**
     * Check if Boolean on value.
     *
     * @param bool $value
     * @param array $options
     * @return mixed
     */
    public function apply($value, array $options = [])
    {
        if (is_bool($value)) {
            return $value;
        } else if (is_string($value) === true && in_array($value, ['0', '1'])) {
            return (bool) $value;
        } else if (is_int($value) === true && in_array($value, [0, 1])) {
            return (bool) $value;
        }

        return null;
    }
}
