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
		$adp['Placement']['short_url'] = HTTP_ROOT.$adp['Placement']['keyword'];
		$adp['Placement']['creator_ip_address'] = $this->getRealIpAddr();
		$adp['Placement']['is_active'] = 1;
		
		$saveAdplacements = $placement->save($adp);
		$placementDetailID = $placement->getLastInsertID();
		
		/* Added the functionality to update the "Placememnt Format ID" in the placements table STARTS here */
		
			$placementFormatId = "P".str_pad($details['publisherId'],5,"0",STR_PAD_LEFT)."-".str_pad($placementDetailID,5,"0",STR_PAD_LEFT);
			$this->query("update `placements` set `placementId`='".$placementFormatId."' where `id`='".$placementDetailID."'");
			
		/* Added the functionality to update the "Placememnt Format ID" in the placements table ENDS here */	
		
		return array($placementDetailID, $adp['Placement']['keyword']);
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
	function getDestURL($slugparam, $loggedInId=NULL)
	{
		App::import('Model','Placement');
		$placement = new Placement();
		
		App::import('Model','AdDetail');
		$adDetail = new AdDetail();
		
		App::import('Model','Config');
		$config = new Config();
		
		$DestUrl = $placement->find('all',array('conditions'=>array('keyword'=>$slugparam)));//pr($DestUrl);exit;
		
		if($DestUrl && count($DestUrl) > 0)
		{
			$isAdvertiser = false;
			
			if(isset($loggedInId) && $loggedInId != ''){
				$getAdDetail = $adDetail->find('all', array('conditions'=>array('AdDetail.advertiser_id'=>$loggedInId, 'AdDetail.id'=>$DestUrl[0]['AdDetail']['id'])));
				$isAdvertiser = true;
			}
			
			switch ($isAdvertiser)
			{
				case true:
				  $duplicateDayCount = $config->getDuplicateDaysCount();
				  $returnDuplicateDetails = $this->VerifyDuplicateClick($DestUrl[0]['Placement']['id'], $_SERVER['REMOTE_ADDR'], $DestUrl, $duplicateDayCount);
				  return $returnDuplicateDetails;
				  
				case false:
				  $duplicateDayCount = $config->getDuplicateDaysCountAdv();
				  $returnDuplicateDetails = $this->VerifyDuplicateClick($DestUrl[0]['Placement']['id'], $_SERVER['REMOTE_ADDR'], $DestUrl, $duplicateDayCount);
				  return $returnDuplicateDetails;
			}
		}
		else
		{
			return "0####0";
		}	
		
	}
	
	function VerifyDuplicateClick($placeMentid, $userIp, $DestUrl, $duplicateDayCount)
	{
		App::import('Model','AdClick');
		$adclick = new AdClick();
		
		//$duplicateDayCount = 1;
		$checkDuplicateClick = $adclick->find('first', array('fields'=>array('AdClick.placement_id', 'AdClick.user_ip_address', 'AdClick.created'), 'conditions'=>array('AdClick.placement_id'=>$placeMentid, 'AdClick.user_ip_address'=>$userIp), 'order'=>'AdClick.created DESC'));
		
		if($checkDuplicateClick) //Check if the data is present in the database for the above condition
		{
			$date1 = date('Y-m-d',strtotime($checkDuplicateClick['AdClick']['created']));
			$date2 = date('Y-m-d');
			$diff = abs(strtotime($date2) - strtotime($date1));
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			if($days > $duplicateDayCount || $duplicateDayCount == 0){ //if the difference day is greater than the ADMIN specified day
				$adclickarr['AdClick']['ad_detail_id'] = $DestUrl[0]['AdDetail']['id'];
				$adclickarr['AdClick']['placement_id'] = $DestUrl[0]['Placement']['id'];
				$adclickarr['AdClick']['user_ip_address'] = $this->getRealIpAddr();
				
				$saveAdclicks = $adclick->save($adclickarr);
				$adclickId = $adclick->getLastInsertID();
				
				return $adclickId."####".$DestUrl[0]['AdDetail']['dest_url'];
			}else{
				return "0####0";
			}
		}else{ //if not present in the database then we have to insert into database and redirect to the destination url
			$adclickarr['AdClick']['ad_detail_id'] = $DestUrl[0]['AdDetail']['id'];
			$adclickarr['AdClick']['placement_id'] = $DestUrl[0]['Placement']['id'];
			$adclickarr['AdClick']['user_ip_address'] = $this->getRealIpAddr();
			
			$saveAdclicks = $adclick->save($adclickarr);
			$adclickId = $adclick->getLastInsertID();
			
			return $adclickId."####".$DestUrl[0]['AdDetail']['dest_url'];
		}
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