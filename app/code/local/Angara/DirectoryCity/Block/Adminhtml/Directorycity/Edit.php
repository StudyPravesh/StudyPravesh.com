<?php
	
class Angara_DirectoryCity_Block_Adminhtml_Directorycity_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "city_id";
				$this->_blockGroup = "directorycity";
				$this->_controller = "adminhtml_directorycity";
				$this->_updateButton("save", "label", Mage::helper("directorycity")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("directorycity")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("directorycity")->__("Save And Continue Edit"),
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
				if( Mage::registry("directorycity_data") && Mage::registry("directorycity_data")->getId() ){

				    return Mage::helper("directorycity")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("directorycity_data")->getId()));

				} 
				else{

				     return Mage::helper("directorycity")->__("Add Item");

				}
		}
}