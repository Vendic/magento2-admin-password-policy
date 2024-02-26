<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Rules;

use Magento\Framework\Phrase;
use Magento\User\Model\User;

class HasSpecialCharacter implements RuleInterface
{

    public function validate(User $user): ?Phrase
    {
        $password = $user->getPassword();
        if (preg_match('/^[A-Za-z0-9]+$/', $password)) {
            return __('Password should contain at least one special character.');
        }

        return null;
    }
}
