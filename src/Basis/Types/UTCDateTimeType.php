<?php

namespace Cuantic\Basis\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

class UTCDateTimeType extends DateTimeType
{
    protected function utc()
    {
        return new \DateTimeZone('UTC');
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value instanceof \DateTime) {
            $value->setTimezone( $this->utc() );
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if(null === $value || $value instanceof \DateTime) {
            return $value;
        }

        $converted = \DateTime::createFromFormat(
            $platform->getDateTimeFormatString(),
            $value,
            $this->utc()
        );

        if( !$converted ) {
            throw ConversionException::conversionFailedFormat(
                $value,
                $this->getName(),
                $platform->getDateTimeFormatString()
            );
        }

        return $converted;
    }
}