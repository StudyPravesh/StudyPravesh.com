<?php
class CodeMasterz_QueryManager_Helper_Data extends Mage_Core_Helper_Abstract{
	
	public function getUaeCities() {
        $helper = Mage::helper('directory');
        $cities = array(
            $helper->__('Abu Dhabi'),
            $helper->__('Ajman'),
            $helper->__('Al Ain'),
            $helper->__('Dubai'),
            $helper->__('Fujairah'),
            $helper->__('Ras al Khaimah'),
            $helper->__('Sharjah'),
            $helper->__('Umm al Quwain'),
        );
        return $cities;
    }
 
    public function getUaeCitiesAsDropdown($selectedCity = '') {
        $cities = $this->getUaeCities();
        $options = '';
        foreach($cities as $city){
            $isSelected = $selectedCity == $city ? ' selected="selected"' : null;
            $options .= '<option value="' . $city . '"' . $isSelected . '>' . $city . '</option>';
        }
        return $options;
    }
	
	
	public function getCoursesAsDropdown($categoryId){
		$resource 	= 	Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		$table1 	= 	$resource->getTableName('eav/attribute_option');
		$table2 	= 	$resource->getTableName('eav/attribute_option_value');
		
		$query 		= 	"SELECT et2.option_id, et2.value
							FROM $table1 AS et1
							LEFT JOIN $table2 AS et2 ON et1.option_id = et2.option_id 
							WHERE et1.parent_attribute_id='$categoryId' ORDER BY et2.value ASC";
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
	
}
	 