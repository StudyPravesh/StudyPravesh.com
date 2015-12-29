<?php
class CodeMasterz_QueryManager_Helper_Data extends Mage_Core_Helper_Abstract{
	
	public function getCoursesAsDropdown($categoryId){
		$resource 	= 	Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$table1 	= 	$resource->getTableName('eav/attribute_option');
		$table2 	= 	$resource->getTableName('eav/attribute_option_value');
		
		$query 		= 	"SELECT et2.option_id, et2.value, et1.sort_order
							FROM $table1 AS et1
							LEFT JOIN $table2 AS et2 ON et1.option_id = et2.option_id 
							WHERE et1.parent_attribute_id='$categoryId' && et1.attribute_id='135' ORDER BY et1.sort_order ASC";
		//echo $query;
        $results 	= 	$readConnection->fetchAll($query);
		//echo '<pre>';print_r($results);
		$options = '';
        if(count($results) > 0){
			$i=0;
            foreach($results as $course){
				//echo '<pre>';print_r($city);
				$options .= '<option value='.$course['option_id']. '>' . $course['value'] .'</option>';
				$i++;
            }
        }
        return $options;
    }
	

    public function getCitiesAsDropdown($stateId){
		$resource 	= 	Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$table1 	= 	$resource->getTableName('eav/attribute_option');
		$table2 	= 	$resource->getTableName('eav/attribute_option_value');
		
		$query 		= 	"SELECT et2.option_id, et2.value
							FROM $table1 AS et1
							LEFT JOIN $table2 AS et2 ON et1.option_id = et2.option_id 
							WHERE et1.parent_attribute_id='$stateId' ORDER BY et2.value ASC";
		//echo $query;
        $results 	= 	$readConnection->fetchAll($query);
		//echo '<pre>';print_r($results);
		$options = '';
        if(count($results) > 0){
			$i=0;
            foreach($results as $city){
				//echo '<pre>';print_r($city);
				$options .= '<option value='.$city['option_id']. '>' . $city['value'] .'</option>';
				$i++;
            }
        }
        return $options;
    }
	
	
	public function getStateName($stateId) {
		$region = Mage::getModel('directory/region')->load($stateId);
		return $region->getName();
	}
	
	
	public function getCityName($cityId) {
		$collection 	= 	Mage::getModel('directorycity/directorycity')
								->getCollection()
								->addFieldToSelect('city_name')
								->addFieldToFilter('city_id', array('eq' => $cityId))
								->setPageSize(1)
								->load();
								//->load(1);die;
								//echo '<pre>';print_r($collection->getData());die;
		if( $collection->count() ){
			$data	=	$collection->getData();
			return $data[0]['city_name'];
		}
	}
	
	
	public function getCourseName($courseId) {
		$_product 	= Mage::getModel('catalog/product');
		$attr 		= $_product->getResource()->getAttribute("course");
		if ($attr->usesSource()) {
			return $colorLabel = $attr->getSource()->getOptionText($courseId);
			//echo $color_id = $attr->getSource()->getOptionId($colorLabel);
		}		
	}
	
	
}
	 