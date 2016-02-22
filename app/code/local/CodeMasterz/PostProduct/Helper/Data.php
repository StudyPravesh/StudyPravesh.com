<?php
class CodeMasterz_PostProduct_Helper_Data extends Mage_Core_Helper_Abstract{
//class Mage_Postproduct_Helper_Data extends Mage_Core_Helper_Abstract{
	/**
     * Send email to recipient
     *
     * @param string $templateId template identifier (see config.xml to know it)
     * @param array  $sender sender name with email ex. array('name' => 'John D.', 'email' => 'email@ex.com')
     * @param string $email recipient email address
     * @param string $name recipient name
     * @param string $subject email subject
     * @param array  $params data array that will be passed into template
     */
    public function sendEmail($templateId, $sender, $email, $name, $subject, $params = array())
    {
        $this->setDesignConfig(array('area' => 'frontend', 'store' => $this->getDesignConfig()->getStore()))
            ->setTemplateSubject($subject)
            ->sendTransactional(
                $templateId,
                $sender,
                $email,
                $name,
                $params
        );
    }
	
	
	/**
	Global function to return all the active categories
	Usage	-	$categoryHelper = Mage::helper("postproduct")->getCategoriesDropdown(); 
	**/
	public function getCategoriesDropdown() {
		$excludeCategoriesArray =	array(2);
		// Get category collection
		$categoriesArray = Mage::getModel('catalog/category')
								->getCollection()
								->addAttributeToSelect('name')
								->addAttributeToSort('path', 'asc')
								->addFieldToFilter('is_active', array('eq'=>'1'))
								//->load();
								->load(1);die;
								//->toArray();	
		echo '<pre>';print_r($categoriesArray);die;
		// Arrange categories in required array
		foreach ($categoriesArray as $categoryId => $category) {
			echo $categoryId;echo '<pre>';print_r($category);die;
			if ( isset($category['name']) && !in_array($categoryId,$excludeCategoriesArray) ) {
				$categories[] = array(
					'label' => $category['name'],
					'level'  =>$category['level'],
					'value' => $categoryId
				);
			}
		}
		echo '<pre>';print_r($categories);die;
		return $categories;
	}
	
	
	public function getUserName()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            return '';
        }
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        return trim($customer->getName());
    }

    public function getUserEmail()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            return '';
        }
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        return $customer->getEmail();
    }
	
	
}
	 