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
	
	
	public function getCities($stateId)
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('cities');
        $query = "SELECT * FROM `".$tableName."` WHERE state_id = ".$stateId;
		//echo $query;
        $results = $readConnection->fetchAll($query);
        $cities = array();

        if(count($results) > 0)
        {
            foreach($results as $city)
            {
                $cityId = $city['id'];
                $cityName = $city['city_name'];
                $cities[$cityId] = $cityName;
            }
        }
        return $cities;
    }

    public function getCitiesAsDropdown($selectedCity = '',$stateId)
    {
        $cities = $this->getCities($stateId);
		//echo '<pre>';print_r($cities);
        $options = '';
        if(count($cities) > 0)
        {
            foreach($cities as $key	=>	$city)
            {
                $isSelected = $selectedCity == $city ? ' selected="selected"' : null;
                $options .= '<option value="' . $city . '"' . $isSelected . '>' . $city . '</option>';
            }
        }
        return $options;
    }
	
}
	 