<?php

namespace Cuantic\Basis\Tests\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="TEMP")
 */
class Temp
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint", name="ID")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    public $id;
}