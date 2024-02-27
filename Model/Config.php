<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private SerializerInterface $serialize
    ) {
    }

    public function getInactiveUsersWhitelist(): array
    {
        $users = $this->scopeConfig->getValue(
            'admin/password_policy/inactive_user_whitelist',
            ScopeInterface::SCOPE_STORE
        );

        return $users ? explode(',', $users) : [];
    }

    public function getForbiddenWords(): array
    {
        $wordItems = $this->scopeConfig->getValue(
            'admin/password_policy/forbidden_words',
            ScopeInterface::SCOPE_STORE
        );

        if (empty($wordItems)) {
            return [];
        }

        $wordsData = $this->serialize->unserialize($wordItems);

        $words = [];
        foreach($wordsData as $data) {
            $words[] = $data['word'];
        }

        return $words;
    }
}
