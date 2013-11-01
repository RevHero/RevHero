<?php
class AdDetail extends AppModel {
    var $name = 'AdDetail';
	
	var $hasAndBelongsToMany = array(
        'Tag' =>
            array(
                'className'              => 'Tag',
                'joinTable'              => 'ad_tags',
                'foreignKey'             => 'ad_id',
                'associationForeignKey'  => 'tag_id'
            )
    );
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'advertiser_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function saveDetails($userId, $requires)
	{
		App::import('Model','AdDetail');
		$adsall = new AdDetail(); 
		
		$ad['AdDetail']['advertiser_id'] = $userId;
		$ad['AdDetail']['headline'] = $requires['hid_headline'];
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
	
	function getAllAds($userId=NULL)
	{
		App::import('Model','AdDetail');
		$getAds = new AdDetail();
		
		if(isset($userId) && $userId != ''){
			$allAds = $getAds->find('all',array('conditions'=>array('AdDetail.advertiser_id'=>$userId, 'AdDetail.is_active'=>1)));
		}else{
			//$allAds = $getAds->find('all',array('conditions'=>array('is_active'=>1)));
		}	
		return $allAds;
	}
	
	function getAdDetails($adid=NULL)
	{
		App::import('Model','AdDetail');
		$getAdDetails = new AdDetail();
		
		$AdDetails = $getAdDetails->find('first',array('conditions'=>array('AdDetail.id'=>$adid, 'AdDetail.is_active'=>1)));
		return $AdDetails;
	}
}
?>