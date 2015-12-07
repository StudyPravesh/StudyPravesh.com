<?php

class CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("querymanagerGrid");
				$this->setDefaultSort("query_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("querymanager/querymanager")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("query_id", array(
				"header" => Mage::helper("querymanager")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "query_id",
				));
                
						$this->addColumn('query_type', array(
						'header' => Mage::helper('querymanager')->__('Query Type'),
						'index' => 'query_type',
						'type' => 'options',
						'options'=>CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getOptionArray1(),				
						));
						
				$this->addColumn("name", array(
				"header" => Mage::helper("querymanager")->__("Name"),
				"index" => "name",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("querymanager")->__("Email"),
				"index" => "email",
				));
				$this->addColumn("mobile", array(
				"header" => Mage::helper("querymanager")->__("Mobile"),
				"index" => "mobile",
				));
				$this->addColumn("message", array(
				"header" => Mage::helper("querymanager")->__("Message / Query"),
				"index" => "message",
				));
						$this->addColumn('state', array(
						'header' => Mage::helper('querymanager')->__('State'),
						'index' => 'state',
						'type' => 'options',
						'options'=>CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getOptionArray6(),				
						));
						
						$this->addColumn('city', array(
						'header' => Mage::helper('querymanager')->__('City'),
						'index' => 'city',
						'type' => 'options',
						'options'=>CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getOptionArray7(),				
						));
						
						$this->addColumn('course_applied_for', array(
						'header' => Mage::helper('querymanager')->__('Course Applied For'),
						'index' => 'course_applied_for',
						'type' => 'options',
						'options'=>CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getOptionArray8(),				
						));
						
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('query_id');
			$this->getMassactionBlock()->setFormFieldName('query_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_querymanager', array(
					 'label'=> Mage::helper('querymanager')->__('Remove Querymanager'),
					 'url'  => $this->getUrl('*/adminhtml_querymanager/massRemove'),
					 'confirm' => Mage::helper('querymanager')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray1()
		{
            $data_array=array(); 
			$data_array[0]='Query for Apply';
			$data_array[1]='Inquiry';
			$data_array[2]='Call Back';
            return($data_array);
		}
		
		static public function getValueArray1()
		{
            $data_array=array();
			foreach(CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getOptionArray1() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);
		}
		
		static public function getOptionArray6()
		{
            $data_array			=	array(); 
			$stateCollection 	= 	Mage::getModel('directory/country')->load('IN')->getRegions()->toOptionArray();
			if (count($stateCollection) > 0){
				foreach($stateCollection as $state){
					$data_array[$state['value']]	=	$state['label'];
				}
			}
			return($data_array);
		}
		
		static public function getValueArray6()
		{
            $data_array=array();
			foreach(CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getOptionArray6() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray7()
		{
            $data_array=array(); 
			$collection 	= 	Mage::getModel('directorycity/directorycity')
									->getCollection()
									->addFieldToSelect('*')
									->addFieldToFilter('state_id', array('eq' => $stateId))
									->setOrder('city_name',ASC)
									->load();
									//->load(1);die;
			if( $collection->count() ){
				foreach($collection as $city) {
					$data_array[$city->getData('city_id')]	=	$city->getData('city_name');
				}
			}
            return($data_array);
		}
		
		static public function getValueArray7()
		{
            $data_array=array();
			foreach(CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getOptionArray7() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray8()
		{
            $data_array=array(); 
			$data_array[0]='Course';
            return($data_array);
		}
		static public function getValueArray8()
		{
            $data_array=array();
			foreach(CodeMasterz_QueryManager_Block_Adminhtml_Querymanager_Grid::getOptionArray8() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}