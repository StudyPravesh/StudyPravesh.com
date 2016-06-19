<?php
class AW_Blog_Model_Cron{
 
    /*
		Sending a test email when a cron runs
	*/
    public function addpost(){  
		Mage::log("This is a cron run test", null, 'cron.log');
		
		//$xml				= new SimpleXMLElement(file_get_contents('http://blog.angara.com/feed/'));
		$xml				= new SimpleXMLElement(file_get_contents('http://www.govtnaukries.com/feed/'));
		//$xml 				= new SimpleXmlElement($returnedContent, LIBXML_NOCDATA);
		if(isset($xml->channel)){
			//echo '<pre>';print_r($xml->channel->item[0]);die;
			$cnt = count($xml->channel->item);
			for($i=0; $i < 2; $i++){
				$url 		= 	$xml->channel->item[$i]->link;
				$title 		= 	$xml->channel->item[$i]->title;
				$content	= 	$xml->channel->item[$i]->description;
				//$content.=	'<p class="low-margin-top low-margin-bottom"><a href="'.$url.'"><b>'.$title.'</b></a></p>';
				//$content.=	'<ul class="footer-links"><li>"'.substr($desc,0,75).'"...<a class="text-underline" target="_blank" href="'.$url.'">read more</a></li></ul>';
			}
			$content	=	$this->rssProperFormat($content);		//	Reformat the string
			//echo $content;die;
			
			//	Static Data
			$identifier		=	$this->getIdentifier($title);
			$author			=	'Vaseem Ansari';
			$metaKeyword	=	$title;
			$metaDescription=	$title;
			$tags			=	'';
			$shortContent	=	$this->getShortDescription($content);
			$currentDateTime=	Mage::getModel('core/date')->date('Y-m-d H:i:s');
			$data = array(
						'title'				=>	$title,
						'post_content'		=>	$content,
						'status'			=>	1,
						'created_time'		=>	$currentDateTime,
						'update_time'		=>	$currentDateTime,
						'identifier'		=>	$identifier,
						'user'				=>	$author,
						'update_user'		=>	$author,
						'meta_keywords'		=>	$metaKeyword,
						'meta_description'	=>	$metaDescription,
						'tags'				=>	$tags,
						'short_content'		=>	$shortContent,
					);
			//echo '<pre>';print_r($data);die;
			$model = Mage::getModel('blog/post')->setData($data);
			try {
				$insertId = $model->save()->getId();
					echo "Data successfully inserted. Insert ID: ".$insertId;
					
					//	Set store
					/*$storeData = array(
							'post_id'		=>	$insertId,
							'store_id'		=>	1,
						);
					$storeModel = Mage::getModel('blog/store')->setData($storeData);
					$insertId 	= $storeModel->save()->getId();
					echo 'store saved';*/
			} catch (Exception $e){
				echo $e->getMessage();   
			}
			
			//	Generating cron log
			//Mage::log('content is ->'.$content, null, 'vaseem_cron.log');	// Creating a log file at var\log\vaseem_cron.log
			//	Send email once the static block html gets updated
			Mage::helper('blog')->sendEmail('Recent Blog Post Update from Study Pravesh', $content);
		} else{
			Mage::helper('blog')->sendEmail('Error - Recent Blog Post Update from Study Pravesh', 'Please check cron function.');
		}
		
		
    }
	
	/*
		Creating a useful post identifier/url
	*/
	function getIdentifier($title){
		$title	=	str_replace(' ', '-', $title);
		$title	=	str_replace(',', '', $title);
		$title	=	str_replace('&', '', $title);
		return strtolower($title);
	}
	
		
	/*
	
	*/
	function getShortDescription($str, $maxlen=150){
		if ( strlen($str) <= $maxlen ) return $str;
		$newstr = substr($str, 0, $maxlen);
		if ( substr($newstr,-1,1) != ' ' ) $newstr = substr($newstr, 0, strrpos($newstr, " ")).'...'; 
		return $newstr;
	}
	
	
	//	Function to remove given html tags from html string
	function rssProperFormat($string,$arrayRemoveTags) 
	{		
		if( is_array($arrayRemoveTags) ){
			$totalTagsToRemove	=	count($arrayRemoveTags);
			foreach($arrayRemoveTags as $tag){
				$string = str_replace($tag, '', $string);		//	Removing given tag		
			}
			$string = str_replace('<>', '', $string);			//	Removing blank nested tags symbols	
			$string = str_replace('</>', '', $string);	
			$string = str_replace('&#8217;', "'", $string);
			$string = str_replace(',', '', $string);	
		}
		return $string;	
	}
 
}