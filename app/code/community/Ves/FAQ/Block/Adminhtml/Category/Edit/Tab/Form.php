<?php
/**
 * Venustheme
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Venustheme EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.venustheme.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.venustheme.com/ for more information
 *
 * @category   Ves
 * @package    Ves_FAQ
 * @copyright  Copyright (c) 2014 Venustheme (http://www.venustheme.com/)
 * @license    http://www.venustheme.com/LICENSE-1.0.html
 */

/**
 * Ves FAQ Extension
 *
 * @category   Ves
 * @package    Ves_FAQ
 * @author     Venustheme Dev Team <venustheme@gmail.com>
 */
class Ves_FAQ_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare tab form's information
     *
     * @return Ves_FAQ_Block_Adminhtml_Faq_Edit_Tab_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $config = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array(
                'add_widgets' => false,
                'add_variables' => false,
                'add_images' => true,
                'encode_directives'             => false,
                'directives_url'                => Mage::getSingleton('adminhtml/url')->getUrl('*/cms_wysiwyg/directive'),
                'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
                'files_browser_window_width' => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_width'),
                'files_browser_window_height'=> (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_height')
                )
            );

        if (Mage::getSingleton('adminhtml/session')->getFAQData()) {
            $data = Mage::getSingleton('adminhtml/session')->getFAQData();
            Mage::getSingleton('adminhtml/session')->setFAQData(null);
        } elseif (Mage::registry('category_data')) {
            $data = Mage::registry('category_data')->getData();
        }

        if (isset($data['image']) && $data['image']) {
            $imageName = $data['image'];
            $data['image'] = 'ves_faq' . '/' . $imageName;
        }

        $model = Mage::registry('category_data');

        $fieldset = $form->addFieldset('category_form', array(
            'legend'=>Mage::helper('ves_faq')->__('General information')
            ));

        $fieldset->addField('status', 'select', array(
            'label'    => Mage::helper('ves_faq')->__('Status'),
            'name'     => 'status',
            'values'   => array(
                1 => Mage::helper('ves_faq')->__('Enabled'),
                2 => Mage::helper('ves_faq')->__('Disabled'),
                )
            ));

        $fieldset->addField('name', 'text', array(
            'label'        => Mage::helper('ves_faq')->__('Name'),
            'class'        => 'required-entry',
            'required'    => true,
            'name'        => 'name',
            ));

        $fieldset->addField('identifier', 'text', array(
            'label'    => Mage::helper('ves_faq')->__('Url Key'),
            'name'     => 'identifier',
            'required' => true,
            ));

        $fieldset->addField('layout', 'select', array(
            'label'    => Mage::helper('ves_faq')->__('Layout Design'),
            'name'     => 'layout',
            'required' => true,
            'values'   => Mage::helper('ves_faq')->getLayoutList()
            ));

        $fieldset->addField('image', 'image', array(
            'label'     => Mage::helper('ves_faq')->__('Logo'),
            'name'      => 'image',
            ));

        $fieldset->addField('prefix', 'text', array(
            'label'        => Mage::helper('ves_faq')->__('Prefix Class'),
            'name'        => 'prefix',
            ));

        $fieldset->addField('description', 'editor', array(
            'label'     => Mage::helper('ves_faq')->__('Description'),
            'required'  => false,
            'name'      => 'description',
            'style'     => 'width:600px;height:300px;',
            'wysiwyg'   => true,
            'config'   => $config
            ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('ves_faq')->__('Store View'),
                'title' => Mage::helper('ves_faq')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')
                ->getStoreValuesForForm(false, true),
                ));
        }
        else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
                ));
        }

        $fieldset->addField('position', 'text', array(
            'label'        => Mage::helper('ves_faq')->__('Position'),
            'name'        => 'position',
            ));

        $fieldset->addField('include_in_sidebar', 'select', array(
            'label'    => Mage::helper('ves_faq')->__('Include the block FAQ Category on Sidebar'),
            'name'     => 'include_in_sidebar',
            'values'   => array(
                1 => Mage::helper('ves_faq')->__('Yes'),
                2 => Mage::helper('ves_faq')->__('No'),
                )
            ));

        $form->setValues($data);
        return parent::_prepareForm();
    }
}