<?php
/*------------------------------------------------------------------------
 # VenusTheme Testimonial Module
 # ------------------------------------------------------------------------
 # author:    VenusTheme.Com
 # copyright: Copyright (C) 2012 http://www.venustheme.com. All Rights Reserved.
 # @license: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.venustheme.com
 # Technical Support:  http://www.venustheme.com/
-------------------------------------------------------------------------*/
class Ves_Testimonial_Block_List extends Mage_Core_Block_Template
{
	/**
	 * @var string $_config
	 *
	 * @access protected
	 */
	protected $_config = '';

	/**
	 * @var string $_config
	 *
	 * @access protected
	 */
	protected $_listDesc = array();

	/**
	 * @var string $_config
	 *
	 * @access protected
	 */
	protected $_show = 0;
	protected $_theme = "";

	/**
	 * Contructor
	 */
	public function __construct($attributes = array())
	{
		
		parent::__construct();
	}

	public function getConfig( $val, $default ="" ){
		return Mage::getStoreConfig( "ves_testimonial/module_setting/".$val );
	}

	public function getGeneralConfig( $val, $default = "" ){
		return Mage::getStoreConfig( "ves_testimonial/general_setting/".$val );
	}


}
