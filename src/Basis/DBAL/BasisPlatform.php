<?php

namespace Cuantic\Basis\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * DatabasePlatforms implementation for Basis.
 * The DatabasePlatforms are the central point of abstraction of platform-specific behaviors, 
 * features and SQL dialects.
 * They are a passive source of information.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://bitbucket.org/Cuantic-api/dynamics-crm-dbal
 * @since  1.0
 */
class BasisPlatform extends AbstractPlatform
{
    use \Cuantic\Basis\Utility\Console;

    public function __construct()
    {
        Type::overrideType('bigint', 'Cuantic\\Basis\\Types\\BigIntType');
        Type::overrideType('string', 'Cuantic\\Basis\\Types\\StringType');
    }

    /**
     * Returns the SQL snippet that declares a boolean column.
     *
     * @param array $columnDef
     *
     * @return string
     */
    public function getBooleanTypeDeclarationSQL(array $columnDef)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns the SQL snippet that declares a 4 byte integer column.
     *
     * @param array $columnDef
     *
     * @return string
     */
    public function getIntegerTypeDeclarationSQL(array $columnDef)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns the SQL snippet that declares an 8 byte integer column.
     *
     * @param array $columnDef
     *
     * @return string
     */
    public function getBigIntTypeDeclarationSQL(array $columnDef)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns the SQL snippet that declares a 2 byte integer column.
     *
     * @param array $columnDef
     *
     * @return string
     */
    public function getSmallIntTypeDeclarationSQL(array $columnDef)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns the SQL snippet that declares common properties of an integer column.
     *
     * @param array $columnDef
     *
     * @return string
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Lazy load Doctrine Type Mappings.
     *
     * @return void
     */
    protected function initializeDoctrineTypeMappings()
    {
        $this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns the SQL snippet used to declare a CLOB column type.
     *
     * @param array $field
     *
     * @return string
     */
    public function getClobTypeDeclarationSQL(array $field)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns the SQL Snippet used to declare a BLOB column type.
     *
     * @param array $field
     *
     * @return string
     */
    public function getBlobTypeDeclarationSQL(array $field)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Gets the name of the platform.
     *
     * @return string
     */
    public function getName()
    {
    	return 'basis';
    }

    /**
     * Gets the name of the platform.
     *
     * @return string
     */
    public function _getPortableTableColumnDefinition()
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeFormatString()
    {
        $this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * {@inheritdoc}
     */
    public function getDateFormatString()
    {
        return 'dmy';
    }
}