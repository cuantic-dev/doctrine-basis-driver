<?php

namespace Cuantic\Basis\DBAL;

use Doctrine\DBAL\Driver\Statement as DriverStatement;
use Cuantic\Basis\RequestBuilder;

/**
 * Statement interface.
 *
 * This resembles (a subset of) the PDOStatement interface.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://bitbucket.org/Cuantic-api/dynamics-crm-dbal
 * @since  1.0
 */
class BasisStatement implements \IteratorAggregate, DriverStatement
{
    use \Cuantic\Basis\Utility\Console;

    protected $connectionHandle = null;
    protected $requestBuilder = null;
    protected $params = [];
    protected $result = null;
    protected $fetchIndex = null;

    /**
     * Initializes a new instance of the Statement class.
     *
     * @param array    $params       The connection parameters.
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct($connectionHandle, $preparedSql)
    {
        $this->connectionHandle = $connectionHandle;
        $this->requestBuilder =  $this->newRequestBuilder($preparedSql);
    }

    protected function getLogger()
    {
        return $this->connectionHandle->getLogger();
    }

    protected function newRequestBuilder($preparedSql)
    {
        return new RequestBuilder($this->connectionHandle, $preparedSql, $this->getLogger());
    }

    /**
     * Binds a value to a corresponding named (not supported by mysqli driver, see comment below) or positional
     * placeholder in the SQL statement that was used to prepare the statement.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * @param mixed   $param Parameter identifier. For a prepared statement using named placeholders,
     *                       this will be a parameter name of the form :name. For a prepared statement
     *                       using question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed   $value The value to bind to the parameter.
     * @param integer $type  Explicit data type for the parameter using the PDO::PARAM_* constants.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function bindValue($param, $value, $type = null)
    {
        $this->params[$param] = [
            'value' => $value,
            'type' => $type,
        ];

        return true;
    }


    /**
     * Binds a PHP variable to a corresponding named (not supported by mysqli driver, see comment below) or question
     * mark placeholder in the SQL statement that was use to prepare the statement. Unlike PDOStatement->bindValue(),
     * the variable is bound as a reference and will only be evaluated at the time
     * that PDOStatement->execute() is called.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * Most parameters are input parameters, that is, parameters that are
     * used in a read-only fashion to build up the query. Some drivers support the invocation
     * of stored procedures that return data as output parameters, and some also as input/output
     * parameters that both send in data and are updated to receive it.
     *
     * @param mixed        $column   Parameter identifier. For a prepared statement using named placeholders,
     *                               this will be a parameter name of the form :name. For a prepared statement using
     *                               question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed        $variable Name of the PHP variable to bind to the SQL statement parameter.
     * @param integer|null $type     Explicit data type for the parameter using the PDO::PARAM_* constants. To return
     *                               an INOUT parameter from a stored procedure, use the bitwise OR operator to set the
     *                               PDO::PARAM_INPUT_OUTPUT bits for the data_type parameter.
     * @param integer|null $length   You must specify maxlength when using an OUT bind
     *                               so that PHP allocates enough memory to hold the returned value.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function bindParam($column, &$variable, $type = null, $length = null)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Fetches the SQLSTATE associated with the last operation on the statement handle.
     *
     * @see Doctrine_Adapter_Interface::errorCode()
     *
     * @return string The error code string.
     */
    function errorCode()
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Fetches extended error information associated with the last operation on the statement handle.
     *
     * @see Doctrine_Adapter_Interface::errorInfo()
     *
     * @return array The error info array.
     */
    function errorInfo()
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Executes a prepared statement
     *
     * If the prepared statement included parameter markers, you must either:
     * call PDOStatement->bindParam() to bind PHP variables to the parameter markers:
     * bound variables pass their value as input and receive the output value,
     * if any, of their associated parameter markers or pass an array of input-only
     * parameter values.
     *
     *
     * @param array|null $params An array of values with as many elements as there are
     *                           bound parameters in the SQL statement being executed.
     *
     * @return boolean TRUE on success or FALSE on failure.
     */
    function execute($params = null)
    {
        $this->requestBuilder->bindParameters( $this->params );

        $request = $this->requestBuilder->getStatement();

        $this->response = $this->doExecute($request);

        $this->fetchIndex = 0;

        return true;
    }

    /**
     * Executes a xml statement
     *
     * @param string $request The sql statement.
     *
     * @return array The response from Basis, an array of Sixdg\BasisConnector\Models\Entity.
     */
    protected function doExecute($request)
    {
        return $this->connectionHandle->execute($request);
    }

    /**
     * Returns the number of rows affected by the last DELETE, INSERT, or UPDATE statement
     * executed by the corresponding object.
     * Basis only supports updating and deleting 1 record at a time, so we
     * we answer always 1.
     *
     * @return integer The number of rows.
     */
    function rowCount()
    {
        $this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Required by interface IteratorAggregate.
     *
     * {@inheritdoc}
     */
    public function getIterator()
    {
        $this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Closes the cursor, freeing the database resources used by this statement.
     *
     * @return boolean TRUE on success, FALSE on failure.
     */
    public function closeCursor()
    {
        return true;
    }

    /**
     * Returns the number of columns in the result set.
     *
     * @return integer
     */
    public function columnCount()
    {
       $this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * {@inheritdoc}
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        return true;
    }

    /**
     * Fetches the next row from a result set.
     *
     * @param integer|null $fetchMode
     *
     * @return mixed The return value of this function on success depends on the fetch type.
     *               In all cases, FALSE is returned on failure.
     */
    public function fetch($fetchMode = null)
    {
        if( $this->fetchIndex >= count($this->response) ) {
            return false;
        }

        $object = $this->response[$this->fetchIndex];

        $this->fetchIndex += 1;

        return $object;
    }

    /**
     * Returns an array containing all of the result set rows.
     *
     * @param integer|null $fetchMode
     * @param mixed        $fetchArgument
     *
     * @return array An array containing all of the remaining rows in the result set.
     */
    public function fetchAll($fetchMode = null, $fetchArgument = 0)
    {
        $this->not_yet_implemented(get_class(), __FUNCTION__);
    }

    /**
     * Returns a single column from the next row of a result set.
     *
     * @param integer $columnIndex
     *
     * @return mixed A single column from the next row of a result set or FALSE if there are no more rows.
     */
    public function fetchColumn($columnIndex = 0)
    {
        $this->not_yet_implemented(get_class(), __FUNCTION__);
    }
}