<?php
$installer = $this;
$installer->startSetup();
$installer->run("-- DROP TABLE IF EXISTS {$this->getTable('directory_city')}");
$installer->run("
				CREATE TABLE {$this->getTable('directory_city')} (
					`city_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'City Id',
					`state_id` VARCHAR(4) NOT NULL DEFAULT '0' COMMENT 'State Id',
					`city_name` VARCHAR(255) NULL DEFAULT NULL COMMENT 'City Name',
					PRIMARY KEY (`city_id`)
				);
");
$installer->endSetup();