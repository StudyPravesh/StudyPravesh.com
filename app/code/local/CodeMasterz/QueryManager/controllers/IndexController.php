<?php
class CodeMasterz_QueryManager_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Titlename"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Titlename"),
                "title" => $this->__("Titlename")
		   ));

      $this->renderLayout(); 
	  
    }
	
	
	public function getCitiesAction($selectedCity = '',$stateId){
		$params 	= 	$this->getRequest()->getParams();
		$stateId	=	$params['state_id'];
		$selectedCity	=	$params['default_city'];
        $result		=	array();
        $result['mycities']=Mage::helper('querymanager')->getCitiesAsDropdown($selectedCity,$stateId);
		//echo '<pre>';print_r($result);
        $this->getResponse()->setHeader('Content-type','application/json', true);
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		//$this->getResponse()->setBody($result);
		
		/*$responseData['message'] = $this->__('Coupon code is not valid.');
		$this->getResponse()->setHeader('Content-type','application/json', true);
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($responseData));*/
		//return;
		
		
    }
}