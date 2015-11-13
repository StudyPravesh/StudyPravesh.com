<?php
class CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("querymanager_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("querymanager")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("querymanager")->__("Item Information"),
				"title" => Mage::helper("querymanager")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("querymanager/adminhtml_querymanager_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
