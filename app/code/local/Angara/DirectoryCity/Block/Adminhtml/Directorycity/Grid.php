<?php

class Angara_DirectoryCity_Block_Adminhtml_Directorycity_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("directorycityGrid");
				$this->setDefaultSort("city_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("directorycity/directorycity")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("city_id", array(
				"header" => Mage::helper("directorycity")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "city_id",
				));
                
						$this->addColumn('state_id', array(
						'header' => Mage::helper('directorycity')->__('State'),
						'index' => 'state_id',
						'type' => 'options',
						'options'=>Angara_DirectoryCity_Block_Adminhtml_Directorycity_Grid::getOptionArray0(),				
						));
						
				$this->addColumn("city_name", array(
				"header" => Mage::helper("directorycity")->__("City Name"),
				"index" => "city_name",
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
			$this->setMassactionIdField('city_id');
			$this->getMassactionBlock()->setFormFieldName('city_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_directorycity', array(
					 'label'=> Mage::helper('directorycity')->__('Remove Directorycity'),
					 'url'  => $this->getUrl('*/adminhtml_directorycity/massRemove'),
					 'confirm' => Mage::helper('directorycity')->__('Are you sure?')
				));
			return $this;
		}
			

		static public function getOptionArray0()
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
		
		
		static public function getValueArray0()
		{
            $data_array=array();
			foreach(Angara_DirectoryCity_Block_Adminhtml_Directorycity_Grid::getOptionArray0() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}