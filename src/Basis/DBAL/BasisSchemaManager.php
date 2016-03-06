 <?php

namespace Cuantic\Basis\DBAL;

use Doctrine\DBAL\Schema\AbstractSchemaManager;

/**
 * Dynamics schema manager. Schema managers are used to inspect and/or
 * modify the database schema/structure.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://bitbucket.org/Cuantic-api/dynamics-crm-dbal
 * @since  1.0
 */
class BasisSchemaManager extends AbstractSchemaManager
{
    use \Cuantic\Basis\Utility\Console;

    /**
     * Gets Table Column Definition.
     *
     * @param array $tableColumn
     *
     * @return \Doctrine\DBAL\Schema\Column
     */
    protected function _getPortableTableColumnDefinition($tableColumn)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }
}