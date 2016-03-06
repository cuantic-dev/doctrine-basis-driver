<?php

use Cuantic\Basis\Tests\TestsBootstrap;

class SelectPurchaseOrderTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
        /** @var \Doctrine\Common\Persistence\ObjectManager */
		$this->entityManager = TestsBootstrap::getDefaultEntityManager();
	}

    public function testSelectInvoiceHeader()
    {
        $purchaseOrder = $this->entityManager->getRepository('Cuantic\Basis\Tests\Models\PurchaseOrder')
            ->findById([8526, 8517]);

        $this->assertArrayHasKey(0, $purchaseOrder);
        $this->assertArrayHasKey(1, $purchaseOrder);
    }
}