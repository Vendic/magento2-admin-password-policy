<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Test\Integration;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\TestFramework\ObjectManager as TestObjectManager;
use Magento\User\Model\ResourceModel\User as UserResource;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use PHPUnit\Framework\TestCase;
use Vendic\AdminPasswordPolicy\Exception\InvalidPasswordException;

/**
 * @property UserFactory $userFactory
 * @property ObjectManager $objectManager
 * @property UserResource $userResource
 *
 * @magentoAppArea adminhtml
 */
class ValidatePasswordTest extends TestCase
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
     * @var UserResource|mixed
     */
    private $userResource;

    protected function setUp(): void
    {
        $this->objectManager = TestObjectManager::getInstance();
        $this->userFactory = $this->objectManager->get(UserFactory::class);
        $this->userResource = $this->objectManager->get(UserResource::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testValidate(
        array $user,
        bool $exception
    ): void {
        $user = $this->userFactory->create(['data' => $user]);

        if ($exception) {
            $this->expectException(InvalidPasswordException::class);
        }

        $this->userResource->save($user);
    }

    private function dataProvider(): array
    {
        $username = 'someUser';
        $firstName = 'John';
        $lastName = 'Doe';
        $email = 'email@example.com';

        $dataProvider = [
            ['user' => ['password' => 'letmein'], 'exception' => true],
            ['user' => ['password' => 'LETMEIN'], 'exception' => true],
            ['user' => ['password' => 'Letmein'], 'exception' => true],
            ['user' => ['password' => 'Letmein123'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!john'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!doe'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!someuser'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!email@example.com'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!admin'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!qwerty'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!123456'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!password'], 'exception' => true],
            ['user' => ['password' => 'Letmein123!'], 'exception' => false],
        ];

        foreach ($dataProvider as &$data) {
            $data['user']['username'] = $username;
            $data['user']['firstname'] = $firstName;
            $data['user']['lastname'] = $lastName;
            $data['user']['email'] = $email;
        }

        return $dataProvider;
    }
}
