<?php
class CodeMasterz_QueryManager_Model_Mysql4_Querymanager extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("querymanager/querymanager", "query_id");
    }
}