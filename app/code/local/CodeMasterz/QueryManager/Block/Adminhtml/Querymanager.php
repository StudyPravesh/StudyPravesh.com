<?php


class CodeMasterz_QueryManager_Block_Adminhtml_Querymanager extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_querymanager";
	$this->_blockGroup = "querymanager";
	$this->_headerText = Mage::helper("querymanager")->__("Querymanager Manager");
	$this->_addButtonLabel = Mage::helper("querymanager")->__("Add New Item");
	parent::__construct();
	
	}

}