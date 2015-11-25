<?php
class CodeMasterz_Sarah_Helper_Data extends Mage_Core_Helper_Abstract{
	/**
	Global function to return all the active categories
	Usage	-	$categoryHelper = Mage::helper("sarah")->getCategoriesDropdown(); 
	**/
	public function getCategoriesDropdown() {
		$excludeCategoriesArray =	array(2);
		// Get category collection
		$categoriesArray = Mage::getModel('catalog/category')
								->getCollection()
								->addAttributeToSelect('name')
								->addAttributeToSort('path', 'asc')
								->addFieldToFilter('is_active', array('eq'=>'1'))
								->load()
								->toArray();
	
		// Arrange categories in required array
		foreach ($categoriesArray as $categoryId => $category) {
			if (isset($category['name']) && !in_array($categoryId,$excludeCategoriesArray)){
				$categories[] = array(
					'label' => $category['name'],
					'level'  =>$category['level'],
					'value' => $categoryId
				);
			}
		}
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
	
	public function getCssVersion()
    {
        return Mage::getStoreConfig('sarah/cache_settings/css_cache_version');		/*	module name / group name / field name	*/
    }
	
	public function getJsVersion()
    {
        return Mage::getStoreConfig('sarah/cache_settings/js_cache_version');
    }
	
	
	/*
		//	S:VA	
		//	Function to show the sorted products from category
		//	Calling	-	$_products = $this->getProductsFromCategory('71');
	*/
	public function getProductsFromCategory($categoryId, $noOfProducts=10){
		$_category 			= 	Mage::getModel('catalog/category')->load($categoryId); 		//	Where $category_id is the id of the category
		$collection 		= 	Mage::getResourceModel('catalog/product_collection');
		$collection->addCategoryFilter($_category); 										// 	Category filter
		$collection->addAttributeToFilter('status',1); 										// 	Include only enabled product
		$collection->addAttributeToFilter('visibility', 4);									// 	catalog, search
		$collection->addAttributeToSelect(array('name','short_description','url','small_image','price')); 		// 	Add product attribute to be fetched
		$collection->addAttributeToSort('cat_index_position', 'DESC');						//	Order by entity_id
		$limit 			= $noOfProducts;	
		$starting_from 	= '0';
		$collection->getSelect()->limit($limit,$starting_from);
		//echo '<pre>';print_r($collection->getData());die;
		$totalProducts		=	count($collection);
		if($totalProducts > 1){
			return $collection;
		}
	}
}
	 