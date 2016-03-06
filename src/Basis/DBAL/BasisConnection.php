<?php

namespace Cuantic\Basis\DBAL;

use Doctrine\DBAL\Driver\Connection;
use Psr\Log\LoggerInterface;

use Cuantic\Basis\BasisLowLevelConnector;

/**
 * Connection to a Basis database.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://bitbucket.org/Cuantic-api/dynamics-crm-dbal
 * @since  1.0
 */
class BasisConnection implements Connection
{
    use \Cuantic\Basis\Utility\Console;

    protected $params = [];
    protected $connecitonHandle = null;

    /**
     * Initializes a new instance of the Connection class.
     *
     * @param array                              $params       The connection parameters.
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct(array $params, LoggerInterface $logger = null)
    {
        $this->params = $params;
        $this->connecitonHandle = new BasisLowLevelConnector($params['driverOptions'], $logger);
    }

    /**
     * Prepares a statement for execution and returns a Statement object.
     *
     * @param string $prepareString
     *
     * @return \Cuantic\DynamicsStatement
     */
    function prepare($prepareString)
    {
        return $this->prepareStatement($prepareString);
    }

    protected function prepareStatement($prepareString)
    {
        return new BasisStatement($this->connecitonHandle, $prepareString);
    }

    /**
     * Executes an SQL statement, returning a result set as a Statement object.
     *
     * @return \Doctrine\DBAL\Driver\Statement
     */
    function query()
    {
        $args = func_get_args();
        $stmt = $this->prepare($args[0]);

        $stmt->execute();

        return $stmt;
    }

    /**
     * Quotes a string for use in a query.
     *
     * @param string  $value
     * @param integer $type
     *
     * @return string
     */
    function quote($value, $type = \PDO::PARAM_STR)
    {
        if (is_int($value)) {
            return $value;
        } elseif (is_float($value)) {
            return sprintf('%F', $value);
        }

        return mysql_escape_string($value);
    }

    /**
     * Executes an SQL statement and return the number of affected rows.
     *
     * @param string $statement
     *
     * @return integer
     */
    function exec($statement)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @param string|null $name
     *
     * @return string
     */
    function lastInsertId($name = null)
    {
    	return $this->connecitonHandle->lastInsertId();
    }

    /**
     * Initiates a transaction.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function beginTransaction()
    {
    	$this->to_do_implement(get_class(), __FUNCTION__);
        return true;
    }

    /**
     * Commits a transaction.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function commit()
    {
        $this->to_do_implement(get_class(), __FUNCTION__);
    	return true;
    }

    /**
     * Rolls back the current transaction, as initiated by beginTransaction().
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function rollBack()
    {
    	$this->to_do_implement(get_class(), __FUNCTION__);
        return true;
    }

    /**
     * Returns the error code associated with the last operation on the database handle.
     *
     * @return string|null The error code, or null if no operation has been run on the database handle.
     */
    function errorCode()
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns extended error information associated with the last operation on the database handle.
     *
     * @return array
     */
    function errorInfo()
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }
}