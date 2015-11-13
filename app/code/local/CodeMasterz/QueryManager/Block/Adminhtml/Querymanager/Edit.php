<?php
	
class CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "query_id";
				$this->_blockGroup = "querymanager";
				$this->_controller = "adminhtml_querymanager";
				$this->_updateButton("save", "label", Mage::helper("querymanager")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("querymanager")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("querymanager")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("querymanager_data") && Mage::registry("querymanager_data")->getId() ){

				    return Mage::helper("querymanager")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("querymanager_data")->getId()));

				} 
				else{

				     return Mage::helper("querymanager")->__("Add Item");

				}
		}
}