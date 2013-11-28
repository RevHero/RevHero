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
	
	var $hasMany = array(
		'AdClick' => array(
			'className' => 'AdClick',
			'foreignKey' => 'placement_id',
			'dependent' => false, //When dependent is set to true, recursive model deletion is possible. In this example, AdClick records will be deleted when their associated Placement record has been deleted.
			'conditions' => '',
			'fields' => '',
			'order' => array('AdClick.created' => 'DESC'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
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
		$adp['Placement']['short_url'] = $details['strURL']."s/".$adp['Placement']['keyword'];
		$adp['Placement']['creator_ip_address'] = $this->getRealIpAddr();
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
	
	function getRealIpAddr()
	{
		if(!empty($_SERVER['REMOTE_ADDR']))
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   
		{
			$explodeIp = explode(", ",$_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = $explodeIp[0];
		}
		else
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		return $ip;
	}
	
	function getDestURL($slugparam)
	{
		App::import('Model','Placement');
		$placement = new Placement();
		
		App::import('Model','AdClick');
		$adclick = new AdClick();
		
		$DestUrl = $placement->find('all',array('conditions'=>array('keyword'=>$slugparam)));
		
		$adclickarr['AdClick']['ad_detail_id'] = $DestUrl[0]['AdDetail']['id'];
		$adclickarr['AdClick']['placement_id'] = $DestUrl[0]['Placement']['id'];
		$adclickarr['AdClick']['user_ip_address'] = $this->getRealIpAddr();
		
		$saveAdclicks = $adclick->save($adclickarr);
		$adclickId = $adclick->getLastInsertID();
		
		return $adclickId."####".$DestUrl[0]['AdDetail']['dest_url'];
	}
	
	function allplacementdetails($userId)
	{
		App::import('Model','Placement');
		$allplacement = new Placement();

		$placements = $allplacement->find('count', array('conditions'=>array('publisher_id'=>$userId), 'order'=>'Placement.created DESC'));
		return $placements;
	}
}
?>