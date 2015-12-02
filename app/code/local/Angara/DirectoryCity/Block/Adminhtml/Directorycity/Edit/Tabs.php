<?php
class Angara_DirectoryCity_Block_Adminhtml_Directorycity_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("directorycity_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("directorycity")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("directorycity")->__("Item Information"),
				"title" => Mage::helper("directorycity")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("directorycity/adminhtml_directorycity_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
