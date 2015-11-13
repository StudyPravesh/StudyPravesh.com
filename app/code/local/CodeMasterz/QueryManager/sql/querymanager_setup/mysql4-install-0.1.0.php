<?php
$installer = $this;
$installer->startSetup();
$installer->run("-- DROP TABLE IF EXISTS {$this->getTable('querymanager')}");
$installer->run("
				create table {$this->getTable('querymanager')} (
					query_id int(11) not null auto_increment,
					query_type varchar(20), 
					name varchar(20), 
					email varchar(30), 
					mobile varchar(13), 
					message text, 
					state varchar(100), 
					city varchar(100), 
					course_applied_for varchar(100), 
					primary key(query_id)
				);
");
$installer->endSetup();