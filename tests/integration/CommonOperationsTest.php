<?php

use Cuantic\Basis\Tests\TestsBootstrap;
use Cuantic\Basis\Tests\Models\Temp;

class CommonOperationTest extends PHPUnit_Framework_TestCase
{
    /** @var \Doctrine\Common\Persistence\ObjectManager */
    protected $entityManager;

	public function setUp()
	{
		$this->entityManager = TestsBootstrap::getDefaultEntityManager();
	}

    public function testSelectPurchaseOrder()
    {
        $purchaseOrder = $this->entityManager->getRepository('Cuantic\Basis\Tests\Models\PurchaseOrder')
            ->findById([8526, 8517]);

        $this->assertNotNull($purchaseOrder);
        $this->assertArrayHasKey(0, $purchaseOrder);
        $this->assertArrayHasKey(1, $purchaseOrder);
    }

    public function testInsertTemp()
    {
        $testObject = $this->entityManager->getRepository('Cuantic\Basis\Tests\Models\Temp')
            ->findOneBy([], ['id' => 'desc'], 1);

        $temp = new Temp();
        $temp->id = ($testObject) ? $testObject->id + 1 : 1;

        $this->entityManager->persist($temp);
        $this->entityManager->flush();

        $isPersisted = \Doctrine\ORM\UnitOfWork::STATE_MANAGED ===
            $this->entityManager->getUnitOfWork()->getEntityState($temp);

        $this->assertTrue($isPersisted);

        $this->assertUpdateTemp($temp->id);
    }

    protected function assertUpdateTemp($tempId)
    {
        if(!$tempId) {
            $this->markTestSkipped('Skipping test because select previous failed.');
            return;
        }

        $temp = $this->entityManager->getRepository('Cuantic\Basis\Tests\Models\Temp')
            ->find($tempId);

        $temp->id = $temp->id + 10;
        $this->entityManager->persist($temp);
        $this->entityManager->flush();

        $isPersisted = \Doctrine\ORM\UnitOfWork::STATE_MANAGED ===
            $this->entityManager->getUnitOfWork()->getEntityState($temp);

        $this->assertTrue($isPersisted);

        $this->assertDeleteTemp($temp->id);
    }

    protected function assertDeleteTemp($tempId)
    {
        if(!$tempId) {
            $this->markTestSkipped('Skipping test because select previous failed.');
            return;
        }

        $temp = $this->entityManager->getRepository('Cuantic\Basis\Tests\Models\Temp')
            ->find($tempId);

        $this->entityManager->remove($temp);
        $this->entityManager->flush();

        $isPersisted = \Doctrine\ORM\UnitOfWork::STATE_MANAGED ===
            $this->entityManager->getUnitOfWork()->getEntityState($temp);

        $this->assertFalse($isPersisted);
    }
}
