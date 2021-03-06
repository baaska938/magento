<?php
class Ves_Base_Block_Widget_Addthis extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface{

	/**
	 * Contructor
	 */
	public function __construct($attributes = array())
	{
		parent::__construct( $attributes );
	}
	protected function _toHtml(){
		if(!Mage::getStoreConfig('ves_base/general_setting/show')) {
			return ;
		}
		$pubid = $this->getConfig("pubid");
		$pubid = !$pubid?$pubid:"ra-538d2d303ab3eaa0";
		$this->assign('pubid', $pubid);
		return parent::_toHtml();
	}
	/**
	 * get value of the extension's configuration
	 *
	 * @return string
	 */
	public function getConfig( $key, $default = ""){
	    $value = $this->getData($key);
	    //Check if has widget config data
	    if($this->hasData($key) && $value !== null) {

	      if($value == "true") {
	        return 1;
	      } elseif($value == "false") {
	        return 0;
	      }
	      
	      return $value;
	      
	    }
	    return $default;
	}
}