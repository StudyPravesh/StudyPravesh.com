<?php
class CodeMasterz_PostProduct_IndexController extends Mage_Core_Controller_Front_Action{
	
	protected function _getSession()
    {		
        return Mage::getSingleton('customer/session');
    }
	
    public function indexAction()
    {
        //Get current layout state
        $this->loadLayout();   
 
        $block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'CodeMasterz.postproduct',
            array(
                'template' => 'codemasterz/postproduct.phtml'
            )
        );
 
        $this->getLayout()->getBlock('content')->append($block);
        //$this->getLayout()->getBlock('right')->insert($block, 'catalog.compare.sidebar', true);
 
        $this->_initLayoutMessages('core/session');
 
        $this->renderLayout();
    }
	
	public function addProductAction(){
		//Fetch submited params
        $params 			= 	$this->getRequest()->getParams();
		//prd($params);
		$name				=	$params['name'];
		$sku				=	$name.rand(1,1000);	//	$params['sku'];
		$sku				=	str_replace(' ','-',$sku);
		$address			=	$params['institution_address'];
		$description		=	$name;	//$params['description'];
		$price				=	'100';	//$params['price'];
		$category			=	$params['category'];
		
		//	S:VA - Check if customer already posted the same data
		$collection = Mage::getModel('catalog/product')
							->getCollection()  
							->addAttributeToFilter('name',$name)
			                ->addAttributeToFilter('short_description',$short_description)
							->addAttributeToSort('created_at', 'desc');   
		$collection->getSelect()->limit(1);
		//$collection->load(1);die;
		//echo '<pre>';print_r($collection->getData());
		$previousRecordsCount	=	$collection->count();
		//	E:VA
		if($previousRecordsCount>=1){
			$message	=	'Oops! You have already listed the same institution. Please check the details once again and try relisting the institution.';
			Mage::getSingleton('core/session')->addError($message);
			echo Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('list-institution/'));die;	
		}
		
		//	Customer Details
		$customerName		=	$params['contact_person_name'];
		$customerEmail		=	$params['contact_person_email'];
		$telephone			=	$params['telephone'];
		$state				=	$params['state'];
		$city				=	$params['city'];
		$pincode			=	$params['pincode'];
		
		//echo '<pre>';print_r($params);die;
		//echo '<pre>';print_r($_FILES['product_image']);die;
		
		//	Start adding a new product
		$product = new Mage_Catalog_Model_Product();
		//echo time();
		// Build the required attributes for new Product
		$product->setAttributeSetId(4);// #4 is for default
		$product->setTypeId('simple');
		$product->setName($name);
		$product->setShortDescription($address);
		$product->setDescription($description);
		$product->setSku($sku);
		$product->setUrlKey($name);
		$product->setWeight(1.0000);
		//$product->setStatus(1);
		//$product->setStatus( Mage_Catalog_Model_Product_Status::STATUS_ENABLED );
		$product->setStatus( Mage_Catalog_Model_Product_Status::STATUS_DISABLED );
		$product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);//4
		//print_r(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
		
		$product->setPrice($price);// # Set some price
		$product->setTaxClassId(0);// # default tax class
		
		$product->setStockData(array(
			'is_in_stock' => 1,
			'qty' => 1
		));
		
		$product->setCategoryIds(array($category));
		$product->setWebsiteIDs(array(1));
		
		//	Default Magento attribute
		$product->setCreatedAt(strtotime('now'));
		
		//	Upload product image to media\import directory
		foreach ($_FILES['product_image']['size'] as $key => $fileSize) {
			if($fileSize>2097152){
				$message = $this->__('Uploaded file is too large. Please upload a valid file.');
				Mage::getSingleton('core/session')->addError($message);
				echo Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('*/*/index', array( 'param'=>$this->getRequest()->getParam('param'),'key'=>$this->getRequest()->getParam('order'))));die;
			}else{
				if(count($_FILES['product_image']['name'])>0){
					foreach ($_FILES['product_image']['name'] as $key => $image) {
						//	Check if file is valid
						/*echo '<pre>';print_r($_FILES['product_image']);
						echo '<pre>';print_r($key);
						echo '<pre>';print_r($image);
						die;*/
						$image	=	strtolower($image);
						if(!strpos($image,'.jpg') && !strpos($image,'.jpeg') && !strpos($image,'.png') && !strpos($image,'.gif') && !strpos($image,'.doc') && !strpos($image,'.pdf') && $image!=''){
							//echo 'not a valid extension';
							$message = $this->__('Uploaded file is not a valid Product Image as it doesnt match gif, jpg, png. Please upload a valid file.');
							Mage::getSingleton('core/session')->addError($message);
							echo Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('*/*/index', array( 'param'=>$this->getRequest()->getParam('param'),'key'=>$this->getRequest()->getParam('order'))));die;
						}else{
							//echo 'allowed extension';
							if($_FILES['product_image']['name']){
								try {
									$uploader = new Varien_File_Uploader(
										array(
											'name' 		=> str_replace(' ','',$_FILES['product_image']['name'][$key]),
											'type' 		=> $_FILES['product_image']['type'][$key],
											'tmp_name' 	=> $_FILES['product_image']['tmp_name'][$key],
											'error' 	=> $_FILES['product_image']['error'][$key],
											'size' 		=> $_FILES['product_image']['size'][$key]
										)
									);
									// Any extention would work
									//$orderIncrementId = Mage::helper('core')->urlDecode($this->getRequest()->getParam('order'));
									$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
									$uploader->setAllowRenameFiles(false);
									$uploader->setFilesDispersion(false);
									// We set media as the upload dir
									$path = Mage::getBaseDir('media') . DS . 'import' . DS . $sku . DS;
									//preg_replace('/[^a-zA-Z0-9 s]/', '-', $image);
									$image = strtolower(str_replace(array('    ','   ','  ', ' '), '', preg_replace('/[^a-zA-Z0-9. s]/', '-', trim($image))));
									if(strstr($image,'-')){
										$image	=	str_replace(array('---','--','-'), '_', $image);
									}
									//$newName    = time() .$image;
									$uploader->save($path, $image);
									$imageUrl = $path . $image;
									$imageResized = $path . $image;
									//echo $imageResized;die;
									if(strpos($images,'.jpg')!='' || strpos($images,'.jpeg')!='' || strpos($images,'.png')!='' || strpos($images,'.gif')!='' ):
										if (file_exists($imageResized) && file_exists($imageUrl)) :
											$imageObj = new Varien_Image($imageUrl);
											$imageObj->constrainOnly(TRUE);
											$imageObj->keepAspectRatio(TRUE);
											$imageObj->keepFrame(FALSE);
											//$imageObj->resize(150, 150);
											$imageObj->save($imageResized);
										endif;
									endif;
									$saveImageNameToDb[] .= $image;
									//$img = $uploader->save($path, $_FILES['product_image']['name'][$key]);
								} catch (Exception $e) {
									Mage::log($e->getMessage());
								}
							}
						}
					}
				}	
			}
		}
		//echo '<pre>';print_r($saveImageNameToDb);		echo count($saveImageNameToDb);die;
	// Add three image sizes to media gallery
		//$putPathHere	=	$saveImageNameToDb;			//	media\import\sku
		$mainImage		=	$saveImageNameToDb[0];
		$smallImage		=	$saveImageNameToDb[1];
		$thumbnailImage	=	$saveImageNameToDb[2];
		
		if(count($saveImageNameToDb) > 2){
			$mediaArray 	= 	array(
										'image'       => $mainImage,
										'small_image' => $smallImage,
										'thumbnail'   => $thumbnailImage,
									);
		}elseif(count($saveImageNameToDb) > 1){
			$mediaArray 	= 	array(
									'image'       => $mainImage,
									'small_image' => $smallImage,
									'thumbnail'   => $smallImage,
								);
		}else{
			$mediaArray 	= 	array(
									'image'       => $mainImage,
									'small_image' => $mainImage,
									'thumbnail'   => $mainImage,
								);	
		}
		
		// Remove unset images, add image to gallery if exists
		$importDir = Mage::getBaseDir('media') . DS . 'import'. DS . $sku. DS ;
		
		foreach($mediaArray as $imageType => $fileName) {
			$filePath = $importDir.$fileName;
			if ( file_exists($filePath) ) {
				try {
					$product->addImageToMediaGallery($filePath, $imageType, false);
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			} else {
				echo "Product does not have an image or the path is incorrect. Path was: {$filePath}<br/>";
			}
		}
		
		//print_r($product);die;
		try {
			$product->save();
			//	Delete product images from media import folder	
			array_map('unlink', glob("$importDir/*.*"));
			rmdir($importDir);
			
			
		// Transactional Email Template's ID
		$templateId 	= 	'postproduct_email_template';
		$emailTemplate  = 	Mage::getModel('core/email_template')->loadDefault($templateId);		
								
		// Set variables that can be used in email template
		$emailTemplateVariables 	= 	array(	'name' 					=> $name,
												'institution_address'	=> $address,
												'contact_person_name' 	=> $customerName,
												'contact_person_email' 	=> $customerEmail,
												'telephone' 			=> $telephone,
												'state' 				=> $state,
												'city' 					=> $city,
												'pincode' 				=> $pincode												
											 );
		$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
												
		
		$senderName 	= 	Mage::getStoreConfig('general/store_information/name');
		$senderEmail 	= 	Mage::getStoreConfig('trans_email/ident_general/email');
		
		$mail = Mage::getModel('core/email')
				->setToName($customerName)
				->setToEmail($customerEmail)
				//->setToEmail('vaseemansari007@gmail.com')
				->setBody($processedTemplate)
				->setSubject('Thank you for listing an institution at '.$senderName)
				->setFromEmail($senderEmail)
				->setFromName($senderName)
				->setType('html');					
				// Send Transactional Email
				try {	
					$mail->send();	
					//	Send email to admin
					$subject	=	'Acknowledgement : List your institution';
					$this->sendEmailToAdmin($customerName, $customerEmail, $subject, $emailTemplateVariables);
						
					$message	=	'Please check you email for the confirmation.';
					Mage::getSingleton('core/session')->addSuccess($message);
				}catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
				} catch (Exception $e) {
					$this->_getSession()->addError($this->__('Oops! There is some issue in sending an acknowledgement email to you. Please wait while we are working on it.'));
				}
				
				
			$message	=	'Congratulation. Your institution is added successfully. We will contact you very soon.';
			Mage::getSingleton('core/session')->addSuccess($message);
			echo Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('*/*/index', array( 'param'=>$this->getRequest()->getParam('param') )));die;
		}
		catch (Exception $ex) {
			print_r($ex);die;
			//Handle the error
			$message	=	'Sorry there is some error while adding the institution. Please try adding the institution again or call our customer support.';
			Mage::getSingleton('core/session')->addError($message);
			echo Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('*/*/index', array( 'param'=>$this->getRequest()->getParam('param') )));die;
							
		}
	}
 	
	
 	/*
		Sending email to admin
	*/
	public function sendEmailToAdmin($senderName, $senderEmail, $subject, $emailTemplateVariables)
    {
       	$adminName 		= 	Mage::getStoreConfig('general/store_information/name');		//	Store Name
		$adminEmail 	= 	'noreply@studypravesh.com';	
		//$adminEmail 	= 	Mage::getStoreConfig('trans_email/ident_general/email');	//	Store Email
		
		if(empty($senderEmail)){
			$senderName	=	$adminName;
			$senderEmail=	$adminEmail;
		}
		
		//	Creating email content/body
		$emailContent	=	'Hi '.$adminName.'<br><br>The following data has been submitted on website.<br>';
		
		$output = "";
		foreach ( $emailTemplateVariables as $key => $value ) {
			$output .= '<br>'.sprintf( "%s: %s\n" , ucfirst(str_replace('_',' ',$key)) , $value );
		}
		$emailContent.=	$output;
		$emailContent.=	'<br><br> Thanks and Regards<br>'.$adminName;
		//echo $emailContent;die;
 
        $mail = new Zend_Mail();
        //$mail->setBodyText($emailContent);
		$mail->setBodyHtml($emailContent);
        $mail->setFrom($senderEmail, $senderName);
        $mail->addTo($adminEmail, $adminName);
        $mail->setSubject($subject);
        try {
            $mail->send();
			Mage::log('Email sent to admin.', null, 'email.log');
        }catch(Exception $ex) {
            Mage::log('Unable to send email to admin.', null, 'email.log');
        }
    }
} 
?>