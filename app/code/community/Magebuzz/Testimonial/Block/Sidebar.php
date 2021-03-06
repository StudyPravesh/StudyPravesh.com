<?php
/*
* Copyright (c) 2014 www.magebuzz.com
*/
class Magebuzz_Testimonial_Block_Sidebar extends Mage_Core_Block_Template {		
	public function __construct() {
		parent::__construct();			
		if(Mage::getStoreConfig('testimonial/general_option/testimonial_sidebar_slider')){
			$this->setTemplate('testimonial/sidebar/slider.phtml');		
		}			
		else {				
			$this->setTemplate('testimonial/testimonial_sidebar.phtml');		
		}		
	}
		
	protected function _prepareLayout() {
		if(Mage::getStoreConfig('testimonial/general_option/testimonial_sidebar_slider')){
			$this->getLayout()->getBlock('head')->addJs('magebuzz/testimonial/jquery/jquery.min.js');
			$this->getLayout()->getBlock('head')->addJs('magebuzz/testimonial/jquery/jquery.bxslider.js');
			$this->getLayout()->getBlock('head')->addJs('magebuzz/testimonial/jquery/testimonial_slider.js');
			$this->getLayout()->getBlock('head')->addCss('css/magebuzz/testimonial/testimonial_slider.css');
		}			
		return parent::_prepareLayout();
	}
		
  public function getTestimonialsLast(){
		$limit = Mage::helper('testimonial')->getMaxTestimonialsOnSidebar();
		$collection = Mage::getModel('testimonial/testimonial')->getCollection();
		$collection->addFieldToFilter('avatar_name', array('neq'=>''));		//	S:VA	load testimonials with images only
		//$collection->setOrder('created_time', 'DESC');
		$collection->getSelect()->order(new Zend_Db_Expr('RAND()'));
		$collection->addFieldToFilter('status',1);
		$collection->setPageSize($limit);
		//$collection->load(1);die;
		return $collection;
	}
		
	public function getContentTestimonialSidebar($_description, $count) {
		if ( strlen($_description) <= $count ) return $_description;
		$newstr = substr($_description, 0, $count);
		if ( substr($newstr,-1,1) != ' ' ) $newstr = substr($newstr, 0, strrpos($newstr, " ")).'...'; 
		return $newstr;
		
		/*$short_desc = substr($_description, 0, $count);
		echo strrpos($short_desc, ' ');die;
		if(substr($short_desc, 0, strrpos($short_desc, ' '))!='') {
			$short_desc = substr($short_desc, 0, strrpos($short_desc, ' '));
			$short_desc = $short_desc.'...';
		}
		return $short_desc;*/
	}
}