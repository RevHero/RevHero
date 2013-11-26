<?php
class Placement extends AppModel {
    var $name = 'Placement';

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'publisher_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AdDetail' => array(
			'className' => 'AdDetail',
			'foreignKey' => 'ad_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function getKeywordUnique($keyword=NULL)
	{
		App::import('Model','Placement');
		$getKeyWord = new Placement();
		
		$allkeyword = $getKeyWord->find('all',array('conditions'=>array('Placement.is_active'=>1, 'Placement.keyword'=>$keyword)));
		
		if(count($allkeyword) > 0){
			$status = 1;
		}else{
			$status = 0;
		}
		return $status;
	}
	
	function savePlacementDetails($details)
	{
		App::import('Model','Placement');
		$placement = new Placement(); 
		
		$adp['Placement']['publisher_id'] = $details['publisherId'];
		$adp['Placement']['ad_detail_id'] = $details['adversiteId'];
		if(isset($details['customKeyword']) && $details['customKeyword'] != ''){
			$adp['Placement']['keyword'] = $details['customKeyword'];
		}else{
			//$randomCustomKeyword = substr(md5(uniqid(rand())),0,6);
			$randomCustomKeyword = $this->getRandomNum();
			$adp['Placement']['keyword'] = $randomCustomKeyword;
		}	
		$adp['Placement']['type'] = $details['adType'];
		$adp['Placement']['format'] = $details['adFormat'];
		$adp['Placement']['short_url'] = '';
		$adp['Placement']['is_active'] = 1;
		
		$saveAdplacements = $placement->save($adp);
		$placementDetailID = $placement->getLastInsertID();
		return $adp['Placement']['keyword'];
	}
	
	function getRandomNum()
	{
		App::import('Model','Placement');
		$placement = new Placement();
		
		$tempRandomKeyword = substr(md5(uniqid(rand())),0,6);
		$findRandomKey = $placement->find('first',array('conditions'=>array('Placement.keyword'=>$tempRandomKeyword)));
		if($findRandomKey){
			$this->getRandomNum();
		}else{
			return $tempRandomKeyword;
		}
	}
	
}
?>