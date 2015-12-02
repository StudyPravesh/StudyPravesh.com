<?php
class Angara_DirectoryCity_Helper_Data extends Mage_Core_Helper_Abstract{
	
	public function getCitiesAsDropdown($stateId){
		if($stateId){
			$collection 	= 	Mage::getModel('directorycity/directorycity')
									->getCollection()
									->addFieldToSelect('*')
									->addFieldToFilter('state_id', array('eq' => $stateId))
									->setOrder('city_name',ASC)
									->load();
									//->load(1);die;
			if( $collection->count() ){
				foreach($collection as $city) {
					$options .= '<option value='.$city->getData('city_id'). '>' . $city->getData('city_name') .'</option>';
				}
			}
			return $options;
		}
    }
}
	 