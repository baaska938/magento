<?php

class Ves_Testimonial_Model_System_Config_Source_ListTestimonial
{
    public function toOptionArray()
    {

        $collection = Mage::getModel( "ves_testimonial/testimonial" )->getCollection();
		$groups =  array( array("value"=>"0", "label"=>"--- None ---") );
        $last = '';
		foreach( $collection as $item ){
            $option = array();
            if( $last != $item->getLabel() ){
				$option = array("value"=>$item->getLabel(), "label"=>$item->getLabel() );
                $groups[$last] = $option;
                $last = $item->getLabel();
            }
		}

        return $groups;
    }
}