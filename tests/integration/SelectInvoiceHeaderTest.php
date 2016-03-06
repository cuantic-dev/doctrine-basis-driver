<?php

use Cuantic\Basis\Tests\TestsBootstrap;

class SelectInvoiceHeaderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
        /** @var \Doctrine\Common\Persistence\ObjectManager */
		$this->entityManager = TestsBootstrap::getDefaultEntityManager();
	}

    public function testSelectInvoiceHeader()
    {
        $purchaseOrder = $this->entityManager->getRepository('Cuantic\Basis\Tests\Models\PurchaseOrder')
            ->find(8526);

        var_dump($purchaseOrder);exit;

        $this->assertNotNull($invoiceHeader);
    }
}