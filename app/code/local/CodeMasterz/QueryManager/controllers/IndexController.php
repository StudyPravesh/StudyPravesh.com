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
	
	
	/*
		Process the form data on ajax form submit
	*/
	public function AjaxPostAction() {
		$params = 	$this->getRequest()->getParams();
		//echo '<pre>';print_r($params);die;
		$model 	= 	Mage::getModel('querymanager/querymanager');
		$model->setData('query_type', 	'Query for Apply');
		$model->setData('name', 		$params['name']);
		$model->setData('email', 		$params['email']);
		$model->setData('mobile', 		$params['mobile']);
		$model->setData('state', 		$params['state']);
		$model->setData('city', 		$params['city']);
		$model->setData('course_applied_for', 	$params['course_applied_for']);
		$model->setData('message', 		$params['message']);

		try {
			$model->save();
			echo 'Thank you for your query :)';
		} catch (Exception $e) {
			Mage::log($e->getMessage());
			echo 'Sorry! There is some issue submiting the query.';
		}
	}
	
	
	public function getCitiesAction(){
		$params 	= 	$this->getRequest()->getParams();
		$stateId	=	$params['state_id'];
        //$result		=	array();
        $result	=	Mage::helper('querymanager')->getCitiesAsDropdown($stateId);
		echo $result;
		//return $result;
		//echo '<pre>';print_r($result);die;
		
        //$this->getResponse()->setHeader('Content-type','application/json', true);
		//$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		//$this->getResponse()->setBody($result);
		
		/*$responseData['message'] = $this->__('Coupon code is not valid.');
		$this->getResponse()->setHeader('Content-type','application/json', true);
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($responseData));*/
		//return;		
    }
}