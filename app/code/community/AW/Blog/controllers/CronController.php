<?php

class AW_Blog_CronController extends Mage_Core_Controller_Front_Action
{
    /*
	
	*/
    public function autoPostAction(){
        Mage::getModel('blog/cron')->addpost();
    }

   
}