<?php

namespace Cuantic\Basis\DBAL;

use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Connection;

use Doctrine\DBAL\Types\Type;
use Psr\Log\LoggerInterface;

/**
 * BasisDriver implementation of Driver interface.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://bitbucket.org/Cuantic-api/dynamics-crm-dbal
 * @since  1.0
 */
class BasisDriver implements Driver
{
    use \Cuantic\Basis\Utility\Console;

    protected $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Attempts to create a connection with the database.
     *
     * @param array       $params        All connection parameters passed by the user.
     * @param string|null $username      The username to use when connecting.
     * @param string|null $password      The password to use when connecting.
     * @param array       $driverOptions The driver options to use when connecting.
     *
     * @return \Cuantic\BasisConnection The database connection.
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        $params['user'] = $username;
        $params['password'] = $password;
    	return new BasisConnection($params, $this->logger);
    }

    /**
     * Gets the DatabasePlatform instance that provides all the metadata about
     * the platform this driver connects to.
     *
     * @return \Cuantic\Basis\DBAL\BasisPlatform The database platform.
     */
    public function getDatabasePlatform()
    {
        return new BasisPlatform();
    }

    /**
     * Gets the SchemaManager that can be used to inspect and change the underlying
     * database schema of the platform this driver connects to.
     *
     * @param \Doctrine\DBAL\Connection $conn
     *
     * @return \Cuantic\BasisSchemaManager
     */
    public function getSchemaManager(Connection $conn)
    {
    	return new BasisSchemaManager();
    }

    /**
     * Gets the name of the driver.
     *
     * @return string The name of the driver.
     */
    public function getName()
    {
    	return 'basis';
    }

    /**
     * Gets the name of the database connected to for this driver.
     *
     * @param \Doctrine\DBAL\Connection $conn
     *
     * @return string The name of the database.
     */
    public function getDatabase(Connection $conn)
    {
    	$this->not_yet_implemented(get_class(), __FUNCTION__);
    }
}