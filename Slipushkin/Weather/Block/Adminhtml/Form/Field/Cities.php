<?php

namespace Slipushkin\Weather\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Cities extends AbstractFieldArray
{
    /**
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn('city', ['label' => __('City'), 'class' => 'required-entry']);
        $this->addColumn('country', ['label' => __('Country Code'), 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add New City');
    }
}
