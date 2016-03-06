<?php

namespace Cuantic\Basis\DBAL;

use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\EntityManager;


/**
 * Id generator for Basis.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://bitbucket.org/Cuantic-api/dynamics-crm-dbal
 * @since  1.0
 */
class BasisIdGenerator extends AbstractIdGenerator
{
    /**
     * The name of the sequence to pass to lastInsertId(), if any.
     *
     * @var string
     */
    private $sequenceName;

    /**
     * Constructor.
     *
     * @param string|null $sequenceName The name of the sequence to pass to lastInsertId()
     *                                  to obtain the last generated identifier within the current
     *                                  database session/connection, if any.
     */
    public function __construct($sequenceName = null)
    {
        $this->sequenceName = $sequenceName;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(
        EntityManager $em, $entity)
    {
        return $em->getConnection()->lastInsertId($this->sequenceName);
    }

    /**
     * {@inheritdoc}
     */
    public function isPostInsertGenerator()
    {
        return true;
    }
}