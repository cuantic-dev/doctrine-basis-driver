<?php

namespace Cuantic\Basis\Tests;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class TestsBootstrap
{
    static protected $entityManager;

    static public function initialize()
    {
        // Create a simple "default" Doctrine ORM configuration for Annotations
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $isSimpleMode = false;
        $config = Setup::createAnnotationMetadataConfiguration(
                        [],
                        $isDevMode,
                        $proxyDir,
                        $cache,
                        $isSimpleMode
                    );

        // basis configuration parameters
        $conn = array(
            'driverClass' => '\Cuantic\Basis\DBAL\BasisDriver',
            'driverOptions' => self::getConfig(),
        );

        self::$entityManager = EntityManager::create($conn, $config);        
    }

    static public function getDefaultEntityManager()
    {
        return self::$entityManager;
    }

    static public function getConfig()
    {
        return require __DIR__ . '/config.php';
    }
}

TestsBootstrap::initialize();