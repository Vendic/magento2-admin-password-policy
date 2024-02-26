<?php declare(strict_types=1);

/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    public function getInactiveAdminUsersWhitelistIds(): array
    {
        $methods = $this->scopeConfig->getValue(
            'admin_password_policy/general/admin_users_whitelist_ids',
            ScopeInterface::SCOPE_STORE
        );

        return $methods ? explode(',', $methods) : [];
    }
}
