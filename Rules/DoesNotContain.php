<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Rules;

use Magento\Framework\Phrase;
use Magento\User\Model\User;
use Vendic\AdminPasswordPolicy\Rules\RuleInterface;

class DoesNotContain implements RuleInterface
{
    /**
     * @param string[] $forbiddenWords
     */
    public function __construct(private array $forbiddenWords)
    {
    }

    public function validate(User $user): ?Phrase
    {
        $password = strtolower($user->getPassword());
        foreach ($this->forbiddenWords as $forbiddenWord) {
            $forbiddenWord = strtolower($forbiddenWord);
            if (str_contains($password, $forbiddenWord)) {
                return __("Password is not allowed to contain the following word: '%1'", [$forbiddenWord]);
            }
        }

        return null;
    }
}
