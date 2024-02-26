<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Rules;

use Magento\Framework\Phrase;
use Magento\User\Model\User;
use Vendic\AdminPasswordPolicy\Rules\RuleInterface;

class DoesNotHaveUsername implements RuleInterface
{

    public function validate(User $user): ?Phrase
    {
        $password = strtolower($user->getPassword());
        $username = strtolower($user->getUserName());

        if (!str_contains($password, $username)) {
            return null;
        }

        return __('Password should not contain your username.');
    }
}
