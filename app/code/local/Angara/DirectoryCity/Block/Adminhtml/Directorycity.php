<?php


class Angara_DirectoryCity_Block_Adminhtml_Directorycity extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_directorycity";
	$this->_blockGroup = "directorycity";
	$this->_headerText = Mage::helper("directorycity")->__("Directorycity Manager");
	$this->_addButtonLabel = Mage::helper("directorycity")->__("Add New Item");
	parent::__construct();
	
	}

}