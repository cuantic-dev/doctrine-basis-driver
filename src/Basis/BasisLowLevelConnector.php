<?php

namespace Cuantic\Basis;

use Cuantic\Basis\DBAL\BasisDatabase;

use Doctrine\DBAL\DBALException;

use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

use Psr\Log\LoggerInterface;

/**
 * The low level class that handles the connection to a Basis
 * database.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://github.com/mauroak/doctrine-basis-driver
 * @since  1.0
 */
class BasisLowLevelConnector
{
    use \Cuantic\Basis\Utility\Console;

	protected $config = null;
	protected $db = null;
	protected $lastInsertId = null;
	protected $entitiesMetadataCache = null;
	protected $logger = null;

	public function __construct($config, LoggerInterface $logger = null)
	{
		$this->config = $config;
		$this->logger = $logger;
		$this->validateConfig($config);
	}

	protected function validateConfig($config)
	{
		if(!array_key_exists('host', $config)) {
			throw new DBALException('BASIS host must be set in database config.');
		}
		if(!array_key_exists('database', $config)) {
			throw new DBALException('BASIS database name must be set in database config.');
		}
		if(!array_key_exists('username', $config)) {
			throw new DBALException('BASIS username must be set in database config.');
		}
		if(!array_key_exists('password', $config)) {
			throw new DBALException('BASIS password must be set in database config.');
		}
	}

	public function getLogger()
	{
		return $this->logger;
	}

	public function execute($statement)
	{
		$jarPath = './';
		$command = sprintf(
			'java -cp %sInterfazVPro.jar com.cuantic.interfaz.vpro.Query %s %s %s %s "%s"',
			$jarPath,
			$this->config['host'],
			$this->config['database'],
			$this->config['username'],
			$this->config['password'],
			$statement
		);

		$rawResult = $this->pipe_exec($command);

		$result = json_decode($rawResult['stdOut'], true);

		if(is_null($result)) {
			throw new DBALException('Error while connecting to BASIS: '.$rawResult['stdOut']);
		}

		if($result['success'] == 'false') {
			throw new DBALException(implode(', ', $result->error));
		}

		return $result['row'];
	}

	protected function pipe_exec($cmd, $input='') {
		$proc = proc_open(
			$cmd,
			[['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']],
			$pipes
		);
		fwrite($pipes[0], $input);
		fclose($pipes[0]);

		$stdout = stream_get_contents($pipes[1]);
		fclose($pipes[1]);

		$stderr = stream_get_contents($pipes[2]);
		fclose($pipes[2]);

		$return_code = (int)proc_close($proc);

		return [
			'returnCode' => $return_code,
			'stdOut' 	 => trim($stdout),
			'stdErr' 	 => $stderr
		];
	}

    /**
     * Answer the id of the last insert request executed.
     *
     * @return    string    The id of the last insert request executed.
     */
    public function lastInsertId()
    {
    	return $this->lastInsertId;
    }

    /**
     * Store the id of the last insert request executed.
     *
     * @param    string    $id    The id.
     */
    public function setLastInsertId($id)
    {
    	$this->lastInsertId = $id;
    }
}