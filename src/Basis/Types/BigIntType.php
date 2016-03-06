<?php

namespace Cuantic\Basis\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\BigIntType as BaseBigIntType;
use Doctrine\DBAL\Types\Type;

class BigIntType extends BaseBigIntType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : (float) $value;;
    }

    public function getName()
    {
        return Type::BIGINT;
    }
}