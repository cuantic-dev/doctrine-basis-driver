<?php

namespace Cuantic\Basis\DBAL;

use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;


/**
 * Id generator for Basis.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://github.com/mauroak/doctrine-basis-driver
 * @since  1.0
 */
class BasisIdGenerator extends AbstractIdGenerator
{
    /**
     * {@inheritDoc}
     */
    public function generate(EntityManager $em, $entity)
    {
        throw new \Exception('Id generator is not yet implemented');
        $meta = $em->getClassMetadata(get_class($entity));
        $identifier = $meta->getSingleIdentifierFieldName();

        /** @var QueryBuilder */
        $qb = $em->createQueryBuilder();
        $lastInsertedObject = $qb
            ->select($qb->expr()->max($identifier))
            ->from(get_class($entity))
            ->getQuery()
            ->execute();

        return (int)$lastInsertedObject->$identifier + 1;
    }

    /**
     * {@inheritdoc}
     */
    public function isPostInsertGenerator()
    {
        return true;
    }
}