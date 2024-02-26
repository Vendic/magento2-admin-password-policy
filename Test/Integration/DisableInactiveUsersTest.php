<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Test\Integration;

use Magento\Framework\App\ObjectManager;
use Magento\TestFramework\ObjectManager as TestObjectManager;
use Magento\User\Model\ResourceModel\User as UserResource;
use Magento\User\Model\UserFactory;
use PHPUnit\Framework\TestCase;
use Vendic\AdminPasswordPolicy\Cron\DisableInactiveUsers;

/**
 * @property UserFactory $userFactory
 * @property ObjectManager $objectManager
 * @property UserResource $userResource
 * @property DisableInactiveUsers $subject
 */
class DisableInactiveUsersTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var UserFactory|mixed
     */
    private $userFactory;

    /**
     * @var mixed|DisableInactiveUsers
     */
    private $subject;

    protected function setUp(): void
    {
        $this->objectManager = TestObjectManager::getInstance();
        $this->userFactory = $this->objectManager->get(UserFactory::class);
        $this->subject = $this->objectManager->get(DisableInactiveUsers::class);
    }

    /**
     * @magentoDataFixture Vendic_AdminPasswordPolicy::Test/Integration/_files/dummy_user_with_valid_password.php
     */
    public function testCron(): void
    {
        $this->subject->execute();
        $user = $this->userFactory->create();

        $user->loadByUsername('expired_dummy_user');
        $this->assertEquals(0, $user->getIsActive());

        $user->loadByUsername('recently_used_dummy_user');
        $this->assertEquals(1, $user->getIsActive());
    }
}
