<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Cron;

use DateTime;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime as MagentoDateTime;
use Vendic\AdminPasswordPolicy\Model\Config;
use Zend_Db_Expr;

class DisableInactiveUsers
{
    private const USER_TABLE = 'admin_user';
    private const DAYS = 90;

    public function __construct(
        private ResourceConnection $resourceConnection,
        private MagentoDateTime $dateTime,
        private Config $config
    ) {
    }

    public function execute(): void
    {
        $now = new DateTime();
        $expiredDate = $now->modify(
            sprintf('-%s days', self::DAYS)
        );
        $expiredDate = $this->dateTime->formatDate($expiredDate);

        $bind = ['is_active' => new Zend_Db_Expr('0')];
        $where = ['logdate <= ?' => $expiredDate];

        $inactiveAdminUsersWhitelistIds = $this->config->getInactiveAdminUsersWhitelistIds();
        if (!empty($inactiveAdminUsersWhitelistIds)) {
            $where['user_id NOT IN (?)'] = $inactiveAdminUsersWhitelistIds;
        }

        $connection = $this->resourceConnection->getConnection();
        $connection->update(self::USER_TABLE, $bind, $where);
    }
}
