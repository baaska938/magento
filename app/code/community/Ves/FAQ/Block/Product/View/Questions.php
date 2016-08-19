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
class Ves_FAQ_Block_Product_View_Questions extends Mage_Core_Block_Template
{
	/**
	 * Question collection
	 *
	 * @var Ves_FAQ_Model_Mysql4_Question_Collection
	 */
	protected $_collection = null;

	public function __construct(){
		if(!$this->getConfig('enable', 'general_setting'))
			return;
		if(!$this->getConfig('enable_faq', 'product_page'))
			return;
		parent::__construct();

		if(isset($attributes['template']) && $attributes['template']) {
			$my_template = $attributes['template'];
		} elseif ($this->hasData("template")) {
			$my_template = $this->getData("template");
		} else {
			$my_template = "ves/faq/product/view/questions.phtml";
		}

		$this->setTemplate($my_template);

		$product = $this->getProduct();
		$questions = $this->getQuestions($product->getId());
		$show_pager = $this->getConfig('show_pager', 'product_page');
		if(!$show_pager){
			$questions_count = (int)$this->getConfig('questions_count', 'product_page');
			if($questions_count){
				$questions->setPageSize($questions_count);
			}else{
				$questions->setPageSize(5);
			}
		}
		if($questions){
			$this->setCollection($questions);
		}

	}

	protected function _prepareLayout()
	{
		if(!$this->getConfig('enable', 'general_setting'))
			return;
		if(!$this->getConfig('enable_faq', 'product_page'))
			return;
		
		parent::_prepareLayout();

		$show_pager = $this->getConfig('show_pager', 'product_page');
		if($show_pager){
			$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
			$pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
			$pager->setCollection($this->getCollection());
			$this->setChild('pager', $pager);
			$this->getCollection()->load();
		}
		return $this;
	}

	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}

	public function getProduct(){
		return Mage::registry('current_product');
	}

	/**
	 * Set collection to block
	 *
	 * @param Varien_Data_Collection $collection
	 * @return Ves_FAQ_Block_Questions
	 */
	public function setCollection($collection){
		$this->_collection = $collection;
		return $this;
	}

	/**
	 * Return question collection instance
	 *
	 * @return Ves_FAQ_Model_Mysql4_Question_Collection
	 */
	public function getCollection(){
		return $this->_collection;
	}

	/**
	 * Retrive question list
	 * @param int $categoryId
	 * @return Ves_FAQ_Model_Mysql4_Question_Collection
	 */
	public function getQuestions($categoryId){
		$store = Mage::app()->getStore();
		$collection = Mage::getModel('ves_faq/question')->getCollection()
		->addFieldToFilter('product_id',array( 'eq'=> $categoryId ))
		->addFieldToFilter('status', array( 'eq' => 1 ))
		->addVisibilityFilter()
		->addStoreFilter()
		->setOrder('position','ASC')
		->setOrder('question_id','DESC');
		return $collection;
	}

	/**
	 * Retrive list category
	 */
	public function getListCategory(){
		$store = Mage::app()->getStore();
		$collection = Mage::getModel('ves_faq/category')->getCollection()
		->addFieldToFilter('status', array('eq'=>1))
		->addStoreFilter($store)
		->setOrder('position','ASC');
		return $collection;
	}

	public function getSaveUrl(){
		return Mage::getUrl('venusfaq/index/save');
	}

	/**
	 * get value of the extension's configuration
	 *
	 * @return string
	 */
	public function getConfig( $key, $panel='module_setting', $default = ""){
		$return = "";
		$value = $this->getData($key);
		if($this->hasData($key) && $value !== null) {
			return $value;
		} else {

			$return = Mage::getStoreConfig("ves_faq/$panel/$key");

			if($return == "" && $default) {
				$return = $default;
			}
		}
		return $return;
	}

	public function getReCaptcha(){
		return Mage::helper('ves_faq/recaptcha')
		->setKeys( $this->getConfig('private_key','recaptcha'), $this->getConfig('public_key','recaptcha') )
		->setTheme( $this->getConfig('theme','recaptcha') )
		->setLang( $this->getConfig('lang','recaptcha') )
		->getReCapcha();
	}
}