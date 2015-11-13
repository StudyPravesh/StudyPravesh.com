<?php
class CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("querymanager_form", array("legend"=>Mage::helper("querymanager")->__("Item information")));

								
						 $fieldset->addField('query_type', 'select', array(
						'label'     => Mage::helper('querymanager')->__('Query Type'),
						'values'   => CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getValueArray1(),
						'name' => 'query_type',
						));
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("querymanager")->__("Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("querymanager")->__("Email"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "email",
						));
					
						$fieldset->addField("mobile", "text", array(
						"label" => Mage::helper("querymanager")->__("Mobile"),
						"name" => "mobile",
						));
					
						$fieldset->addField("message", "textarea", array(
						"label" => Mage::helper("querymanager")->__("Message / Query"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "message",
						));
									
						 $fieldset->addField('state', 'select', array(
						'label'     => Mage::helper('querymanager')->__('State'),
						'values'   => CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getValueArray6(),
						'name' => 'state',
						));				
						 $fieldset->addField('city', 'select', array(
						'label'     => Mage::helper('querymanager')->__('City'),
						'values'   => CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getValueArray7(),
						'name' => 'city',
						));				
						 $fieldset->addField('course_applied_for', 'select', array(
						'label'     => Mage::helper('querymanager')->__('Course Applied For'),
						'values'   => CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getValueArray8(),
						'name' => 'course_applied_for',					
						"class" => "required-entry",
						"required" => true,
						));

				if (Mage::getSingleton("adminhtml/session")->getQuerymanagerData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getQuerymanagerData());
					Mage::getSingleton("adminhtml/session")->setQuerymanagerData(null);
				} 
				elseif(Mage::registry("querymanager_data")) {
				    $form->setValues(Mage::registry("querymanager_data")->getData());
				}
				return parent::_prepareForm();
		}
}
