<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Rules;

use Magento\Framework\Phrase;
use Magento\User\Model\User;
use Vendic\AdminPasswordPolicy\Rules\RuleInterface;

class DoesNotHaveLastName implements RuleInterface
{

    public function validate(User $user): ?Phrase
    {
        $password = strtolower($user->getPassword());
        $lastName = strtolower($user->getLastName());

        if (!str_contains($password, $lastName)) {
            return null;
        }

        return __('Password should not contain your last name.');
    }
}
