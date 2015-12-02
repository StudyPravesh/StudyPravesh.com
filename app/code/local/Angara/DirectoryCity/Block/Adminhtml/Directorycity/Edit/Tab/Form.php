<?php
class Angara_DirectoryCity_Block_Adminhtml_Directorycity_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("directorycity_form", array("legend"=>Mage::helper("directorycity")->__("Item information")));

								
						 $fieldset->addField('state_id', 'select', array(
						'label'     => Mage::helper('directorycity')->__('State'),
						'values'   => Angara_DirectoryCity_Block_Adminhtml_Directorycity_Grid::getValueArray0(),
						'name' => 'state_id',					
						"class" => "required-entry",
						"required" => true,
						));
						$fieldset->addField("city_name", "text", array(
						"label" => Mage::helper("directorycity")->__("City Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "city_name",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getDirectorycityData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getDirectorycityData());
					Mage::getSingleton("adminhtml/session")->setDirectorycityData(null);
				} 
				elseif(Mage::registry("directorycity_data")) {
				    $form->setValues(Mage::registry("directorycity_data")->getData());
				}
				return parent::_prepareForm();
		}
}
