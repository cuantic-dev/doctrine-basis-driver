<?php

use Cuantic\Basis\Tests\TestsBootstrap;
use Cuantic\Basis\BasisLowLevelConnector;
use Cuantic\Basis\BasisRequest;

class BasisLowLevelConnectorTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->api = new BasisLowLevelConnector( $this->BasisConfig() );
	}

	protected function BasisConfig()
	{
        return TestsBootstrap::getConfig();
	}

    public function testMissingUsernameInConfig()
    {
        $this->setExpectedException(
            '\Doctrine\DBAL\DBALException',
            'BASIS host must be set in database config.'
        );

    	new BasisLowLevelConnector([]);
    }

    public function testMissingPasswordInConfig()
    {
        $this->setExpectedException(
            '\Doctrine\DBAL\DBALException',
            'BASIS host must be set in database config.'
        );

        new BasisLowLevelConnector([]);
    }
}