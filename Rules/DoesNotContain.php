<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Rules;

use Magento\Framework\Phrase;
use Magento\User\Model\User;
use Vendic\AdminPasswordPolicy\Model\Config;
use Vendic\AdminPasswordPolicy\Rules\RuleInterface;

class DoesNotContain implements RuleInterface
{
    /**
     * @param Config $config
     */
    public function __construct(
        private Config $config
    )
    {
    }

    public function validate(User $user): ?Phrase
    {
        $password = strtolower($user->getPassword());

        $forbiddenWords = $this->config->getForbiddenWords();

        foreach ($forbiddenWords as $forbiddenWord) {
            $forbiddenWord = strtolower($forbiddenWord);
            if (str_contains($password, $forbiddenWord)) {
                return __("Password is not allowed to contain the following word: '%1'", [$forbiddenWord]);
            }
        }

        return null;
    }
}
