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
		$adp['Placement']['short_url'] = $details['strURL'].$adp['Placement']['keyword'];
		$adp['Placement']['creator_ip_address'] = $this->getRealIpAddr();
		$adp['Placement']['is_active'] = 1;
		
		//echo "<pre>";print_r($adp);exit;
				
		$saveAdplacements = $placement->save($adp);
		$placementDetailID = $placement->getLastInsertID();
		return $adp['Placement']['keyword'];
	}
	
	function getRandomNum()
	{
		App::import('Model','Placement');
		$placement = new Placement();
		
		$arrReserveKeywords = array("javascript","javascripts","image","images","img","imgs","css","style","styles","icon","icons","static","server","admin","user","administrator","login","password","deploy");
		
		//$tempRandomKeyword = substr(md5(uniqid(rand())),0,6);
		$tempRandomKeyword = $this->buildShortUrlKeyword(); //Generate the keyword as per the specified format
		
		if(in_array(strtolower($tempRandomKeyword),$arrReserveKeywords)){//not be a reserved word according to the specified array
			$this->getRandomNum();
		}else if((substr($tempRandomKeyword,0,1) == "-") || (substr($tempRandomKeyword, (strlen($tempRandomKeyword)-1)) == "-")){ // Keyword not start or end with a hyphen.
			$this->getRandomNum();
		}else if((strlen($tempRandomKeyword) <3) || (strlen($tempRandomKeyword) > 128)){ // Keyword have a minimum length of 3 and have a maximum length of 128.
			$this->getRandomNum();
		}else{
			$findRandomKey = $placement->find('first',array('conditions'=>array('Placement.keyword'=>$tempRandomKeyword)));
			if($findRandomKey){
				$this->getRandomNum();
			}else{
				return $tempRandomKeyword;
			}
		}	
	}
	
	private function buildShortUrlKeyword() //contain [a-z][A-Z][0-9] and hyphens (-); all other characters are not allowed.
	{
		$codeset = "-0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ"; // note:this is not a complete alphabet. characters l, I, and O were removed because they look too similar to other characters
		$base = strlen($codeset);
		$n = mt_rand(299, 9999999999); // range from 54 to dZfsHp
		
		$converted = NULL;
		while ($n > 0)
		{
			$converted = substr($codeset, ($n % $base), 1) . $converted;
			$n = floor($n / $base);
		}
		return $converted;
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
	
	function isKeywordExists($slugValue)
	{
		$getDetail = $this->find('all',array('conditions'=>array('keyword'=>$slugValue)));
		if(count($getDetail) > 0){
			return 1;
		}else{
			return 0;
		}
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