<?php declare(strict_types=1);
/**
 * @copyright   Copyright (c) Vendic B.V https://vendic.nl/
 */

namespace Vendic\AdminPasswordPolicy\Block\Adminhtml\System\Config\Form\Field;

use Exception;
use Hyva\Checkout\Block\Adminhtml\Element\FieldArray\TypeRenderer;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\BlockFactory;

class ForbiddenWords extends AbstractFieldArray
{
    protected BlockFactory $blockFactory;
    protected Json $serializer;

    public function __construct(
        Context $context,
        BlockFactory $blockFactory,
        Json $serializer,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->blockFactory = $blockFactory;
        $this->serializer = $serializer;
    }

    public function _prepareToRender()
    {
        $this->addColumn('word', [
            'label' => __('Word')
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add field');
    }
}
