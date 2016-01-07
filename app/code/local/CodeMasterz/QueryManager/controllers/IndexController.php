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
		$this->save();
	}
	
	
	/*
		Function to save the form data in db
	*/
	public function save(){
		$params = 	$this->getRequest()->getParams();
		//echo '<pre>';print_r($params);
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
			$this->sendQueryForApplyEmail();		//	send email to admin
			echo '<div class="full-width qr-thanks">Thank you for your query :). Our executive will contact you very soon.</div>';
		} catch (Exception $e) {
			Mage::log($e->getMessage());
			echo '<div class="full-width qr-thanks">Sorry! There is some issue submiting the query:(</div>';
		}
	}
	
	
	/*
		Function to send email to admin with the contents submitted on the form
	*/
	public function sendQueryForApplyEmail(){
		$post			=	$this->getRequest()->getPost();
		//echo '<pre>';print_r($post);
		
		// Transactional Email Template's ID
		$templateId 	= 	'query_for_apply_email_template';	//here you can use template id defined in config.xml or you can use template ID in database (would be 1,2,3,4 .....etc)
		
		$stateName		=	Mage::helper('querymanager')->getStateName($post['state']);
		$cityName		=	Mage::helper('querymanager')->getCityName($post['city']);
		$courseName		=	Mage::helper('querymanager')->getCourseName($post['course_applied_for']);
		
		// Set variables to use them in email template
		$emailTemplateVariables 	= 	array(	'visitor_name' 	=> $post['name'],
												'visitor_email' => $post['email'],
												'state' 		=> $stateName,
												'city' 			=> $cityName,
												'mobile' 		=> $post['mobile'],
												'course' 		=> $courseName,
												'message' 		=> $post['message']
										);
		// Set recipient information
		$receiverEmail 	= 	Mage::getStoreConfig('trans_email/ident_general/email');
		//$receiverEmail 	= 	'info@studypravesh.com';
		$receiverName 	= 	Mage::getStoreConfig('general/store_information/name');
		
		$storeId 		= 	Mage::app()->getStore()->getId();
		$sender 		= 	array(	'name' 	=> $post['name'],
									'email' => 'noreply@studypravesh.com'//$post['email']
							);
				
		Mage::getModel('core/email_template')
				->addBcc('vaseemansari007@gmail.com')		//	Adding BCC by Vaseem
				->sendTransactional($templateId, $sender, $receiverEmail, $receiverName, $emailTemplateVariables, $storeId);
	}
	
	
	public function getCoursesAction(){
		$params 	= 	$this->getRequest()->getParams();
		$categoryId	=	$params['category_id'];
		if(empty($categoryId)){
			$categoryId	=	1;	//	load schools courses by default	
		}
        $result		=	Mage::helper('querymanager')->getCoursesAsDropdown($categoryId);
		echo $result;
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