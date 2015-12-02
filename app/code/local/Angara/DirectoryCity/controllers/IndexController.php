<?php
class Angara_DirectoryCity_IndexController extends Mage_Core_Controller_Front_Action{
    
	public function getCitiesAction(){
		$params 	= 	$this->getRequest()->getParams();
		$stateId	=	$params['state_id'];
        echo $result=	Mage::helper('directorycity')->getCitiesAsDropdown($stateId);
    }
}