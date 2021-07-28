<?php

namespace UhppotePHP\Extensions\Filters;

class MySQL implements \Elegant\Sanitizer\Contracts\Filter
{
    public function apply($value, array $options = [])
    {
        $db = new \UhppotePHP\db();
        return $db->escapestring($value);
    }
}
