<?php
class AdDetail extends AppModel {
    var $name = 'AdDetail';
	
	function saveDetails($userId, $requires)
	{
		App::import('Model','AdDetail');
		$adsall = new AdDetail(); 
		
		$ad['AdDetail']['advertiser_id'] = $userId;
		$ad['AdDetail']['headline'] = $requires['headline'];
		$ad['AdDetail']['body'] = $requires['bodytext'];
		$ad['AdDetail']['dest_url'] = $requires['dest_url'];
		$ad['AdDetail']['CPC'] = $requires['cpc'];
		$ad['AdDetail']['CPA'] = $requires['cpa'];
		$ad['AdDetail']['staus'] = 0;
		$ad['AdDetail']['is_active'] = 1;
		
		$saveAds = $adsall->save($ad);
		$adDetailID = $adsall->getLastInsertID();
		return $adDetailID;
	}
}
?>