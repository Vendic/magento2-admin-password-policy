<?php
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Rules;

use Magento\Framework\Phrase;
use Magento\User\Model\User;

interface RuleInterface
{
    public function validate(User $user): ?Phrase;
}
