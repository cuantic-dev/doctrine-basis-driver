<?php

namespace Cuantic\Basis;

use Psr\Log\LoggerInterface;

use Cuantic\Basis\BasisRequest;

use Doctrine\DBAL\DBALException;

/**
 * RequestBuilder implementors convert a sql statement into a \Cuantic\DBAL\PublicInterface\Request
 * to be passed to a Cuantic\DBAL\PublicInterface\LowLevelConnector.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://github.com/mauroak/doctrine-basis-driver
 * @since  1.0
 */
class RequestBuilder
{
	use \Cuantic\Basis\Utility\Console;

    protected $connector = null;
	protected $preparedSql = null;
	protected $logger = null;

    /**
     * Initializes the instance with a Sql statement.
     *
     * @param string    $sql	The Sql statement.
     */
	public function __construct(BasisLowLevelConnector $connector, $preparedSql, LoggerInterface $logger = null)
	{
        $this->connector = $connector;
		$this->logger = $logger;
		$this->preparedSql = $preparedSql;
	}

    /**
     * Bind the parameters to the sql parameters placeholders.
     *
     * @return array   The parameters array.
     */
	public function bindParameters($params=[])
	{
		$this->preparedSql = $this->replaceSqlParametersWithValues($params);
	}

	public function getStatement()
	{
		return $this->preparedSql;
	}

    /**
     * Replace the parameters placeholders by their values in the sql 
     * statement.
     *
     * @param string    $sql  The sql statement.
     *
     * @param string    $params  The expression parameters values.
     *
     * @return string   The Sql statement with its placeholders replaced
     * by their values.
     */
    protected function replaceSqlParametersWithValues($params)
    {
        $replacer = new StatementParametersReplacer();
        return $replacer->replaceWithParameters($this->preparedSql, $params);
    }
}