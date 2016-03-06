<?php

namespace Cuantic\Basis;

use PDO;

use Doctrine\DBAL\DBALException;


/**
 * This object replaces the parameters of a Sql statement. The
 * parameters can be in the form of an indexed placeholder '?'
 * or as a named placeholder ':someValue'.
 *
 * @author Martin Rubi <martin.rubi@fdvsolutions.com>
 * @link   https://github.com/mauroak/doctrine-basis-driver
 * @since  1.0
 */
class StatementParametersReplacer
{
    use \Cuantic\Basis\Utility\Console;

    protected $indexedParams = [];

    /**
     * Replace the placeholders in a sql statement with the parameters
     * values.
     *
     * @param string    $sql  The sql statement, with placeholders
     * for the value.
     *
     * @param array    $params  An array with the values to replace the
     * placeholders.
     *
     * @return string   The sql statement with the values instead of the
     * placeholders.
     */
    public function replaceWithParameters($sql, array $params)
    {
        $this->prepareParams($params);

        $sqlWithValues = $this->replaceWithIndexedParameters($sql);
        $sqlWithValues = $this->replaceWithNamedParameters($sqlWithValues);

        return $sqlWithValues;
    }

    /**
     * Replace the indexed placeholders in a sql statement with the parameters
     * values. The indexed placeholders has the form '?'.
     *
     * @param string    $sql  The sql statement, with placeholders
     * for the value.
     *
     * @return string   The sql statement with the indexed values replaced
     * instead of the placeholders.
     */
    protected function replaceWithIndexedParameters($sql)
    {
        $parts = explode('?', $sql);

        if( count($parts) - 1 != count($this->indexedParams) ) {
            throw new DBALException("Different number of indexed parameters in query: \"{$sql}\"");
        }

        $sqlWithValues = $parts[0];

        for($i=1; $i <= count($this->indexedParams); $i++ ) {
            if( !isset($this->indexedParams[$i]) ) {
                throw new DBALException("Missing parameter at index {$i}");
            }
            $sqlWithValues .= $this->getSqlValueFor( $this->indexedParams[$i] );
            $sqlWithValues .= $parts[$i];
        }

        return $sqlWithValues;
    }

    /**
     * Replace the named placeholders in a sql statement with the
     * parameters values. The named parameters has the form ':paramName'.
     *
     * @param string    $sql  The sql statement, with placeholders
     * for the value.
     *
     * @return string   The sql statement with the values named
     * placeholders replaced by its values.
     */
    protected function replaceWithNamedParameters($sql)
    {
        foreach($this->namedParams as $name => $valueAndType) {
            $value = $this->getSqlValueFor($valueAndType);
            $sql = preg_replace("/{$name}/m", $value, $sql);
        }
        return $sql;
    }

    /**
     * Separate the indexed parameters from the named parameters and keep
     * them in instance variables for later use.
     *
     * @param array    $params  The parameters array with indexed and/or
     * named parameters.
     */
    protected function prepareParams($params)
    {
        $this->indexedParams = $this->collectIndexedParameters($params);
        $this->namedParams = $this->collectNamedParameters($params);
    }

    /**
     * Answer a collection of the indexed parameters in the $params
     * array.
     *
     * @param array    $params  The parameters array with indexed and/or
     * named parameters.
     *
     * @return array   The indexed parameters.
     */
    protected function collectIndexedParameters($params)
    {
        $indexParams = [];
        foreach($params as $index => $valueAndType) {
            if( is_integer($index) ) {
                $indexParams[$index] = $valueAndType;
            }
        }
        return $indexParams;
    }

    /**
     * Answer a collection of the named parameters in the $params
     * array.
     *
     * @param array    $params  The parameters array with indexed and/or
     * named parameters.
     *
     * @return array   The named parameters.
     */
    protected function collectNamedParameters($params)
    {
        $namedParams = [];
        foreach($params as $name => $valueAndType) {
            if( is_string($name) && $name[0] == ':' ) {
                $namedParams[$name] = $valueAndType;
            }
        }
        return $namedParams;
    }

    /**
     * Answer the value string to insert into the sql statement for a
     * value and its type.
     *
     * @param array    $valueAndType  An array of the form
     * ['type'=> ..., 'value' => ...]. The type is one of PDO types.
     *
     * @return string   The sql statement with the values named
     * placeholders replaced by its values.
     */
    protected function getSqlValueFor($valueAndType)
    {
        $type = $valueAndType['type'];
        switch($type) {
            case PDO::PARAM_INT:
                return (int) $valueAndType['value'];
                break;
            case PDO::PARAM_STR:
                return "'{$valueAndType['value']}'";
                break;
            case PDO::PARAM_BOOL:
            case PDO::PARAM_LOB:
            case PDO::PARAM_NULL:
                throw new DBALException('Unhandled type: ' . $type);
                break;
            default:
                throw new DBALException('Unknown type: ' . $type);
        }
    }
}