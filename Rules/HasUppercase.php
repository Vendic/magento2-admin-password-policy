<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Rules;

use Magento\Framework\Phrase;
use Magento\User\Model\User;
use Vendic\AdminPasswordPolicy\Rules\RuleInterface;

class HasUppercase implements RuleInterface
{

    public function validate(User $user): ?Phrase
    {
        $password = $user->getPassword();
        if (preg_match('/[A-Z]/', $password)) {
            return null;
        }

        return __('Password should contain at least one uppercase letter.');
    }
}
