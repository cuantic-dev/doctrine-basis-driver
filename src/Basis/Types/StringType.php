<?php

namespace Cuantic\Basis\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType as BaseStringType;

class StringType extends BaseStringType
{
    const STRING = 'string';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return trim($value);
    }

    public function getName()
    {
        return self::STRING;
    }
}
