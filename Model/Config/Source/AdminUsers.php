<?php declare(strict_types=1);

namespace Vendic\AdminPasswordPolicy\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\User\Model\ResourceModel\User\CollectionFactory;

class AdminUsers implements OptionSourceInterface
{
    public function __construct(
        private CollectionFactory $collectionFactory
    ) {
    }

    public function toOptionArray(): array
    {
        $adminUsers = $this->collectionFactory->create()
            ->addFieldToSelect('user_id')
            ->addFieldToSelect('username')
            ->addFieldToSelect('lastname')
            ->addFieldToSelect('firstname');

        $values = [];
        foreach ($adminUsers as $adminUser) {
            $values[] = [
                'value' => $adminUser->getUserId(),
                'label' => $adminUser->getFirstname() .
                    ' ' . $adminUser->getLastname() .
                    ' (' . $adminUser->getUsername() . ')'
            ];
        }

        return $values;
    }
}
