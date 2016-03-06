<?php

namespace Cuantic\Basis\Tests\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ZOC")
 */
class PurchaseOrder
{
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint", name="NROOC")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @ORM\Column(type="integer", name="CDGOPROV")
     */
    public $zipCode;

    /**
     * @ORM\Column(type="smallint", name="CONDCOMPRA")
     */
    public $paymentTerm;

    /**
     * @ORM\Column(type="string", name="EMITIDOPOR")
     */
    public $user;

    /**
     * @ORM\Column(type="date", name="FECHAENTREGA")
     */
    public $deliveryDate;

    /**
     * @ORM\Column(type="date", name="FECHAPEDIDO")
     */
    public $orderDate;

    /**
     * @ORM\Column(type="string", name="LUGARENTREGA")
     */
    public $deliveryLocation;
}