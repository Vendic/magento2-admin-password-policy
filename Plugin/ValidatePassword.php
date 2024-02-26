<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Plugin;

use Magento\Framework\Message\ManagerInterface;
use Magento\User\Model\ResourceModel\User as UserResource;
use Magento\User\Model\User;
use Vendic\AdminPasswordPolicy\Exception\InvalidPasswordException;
use Vendic\AdminPasswordPolicy\Rules\RuleInterface;

class ValidatePassword
{
    /**
     * @param ManagerInterface $messageManager
     * @param RuleInterface[] $rules
     */
    public function __construct(
        private ManagerInterface $messageManager,
        private array $rules = []
    ) {
    }

    public function beforeSave(
        UserResource $subject,
        User $user
    ): void {
        /** @var string|null $password */
        $password = $user->getPassword();
        if ($password === null) {
            return;
        }

        $messages= [];
        foreach ($this->rules as $rule) {
            $messages[] = $rule->validate($user);
        }

        $messages = array_filter($messages);
        if (empty($messages)) {
            return;
        }

        /** @var string $message */
        foreach ($messages as $message) {
            $this->messageManager->addErrorMessage($message);
        }

        throw new InvalidPasswordException(__('The provided password does not meet the validation criteria.'));
    }
}
