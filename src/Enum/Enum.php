<?php

namespace App\Enum;

class Enum extends \MyCLabs\Enum\Enum
{
    public static function getConstants()
    {
        $oClass = new \ReflectionClass(static::class);

        return $oClass->getConstants();
    }
}
