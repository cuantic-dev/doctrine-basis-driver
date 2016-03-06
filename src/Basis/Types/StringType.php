<?php

namespace Cuantic\Basis\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType as BaseStringType;

class StringType extends BaseStringType
{
    const TRIMMED_STRING = 'trimmedString';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return trim($value);
    }

    public function getName()
    {
        return self::TRIMMED_STRING;
    }
}