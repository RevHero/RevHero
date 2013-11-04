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
	
	var $hasMany = array(
		'Placement' => array(
			'className' => 'Placement',
			'foreignKey' => 'ad_detail_id',
			'dependent' => false, //When dependent is set to true, recursive model deletion is possible. In this example, AdDetail records will be deleted when their associated User record has been deleted.
			'conditions' => '',
			'fields' => '',
			'order' => array('Placement.created' => 'DESC'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
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
			$allAds = $getAds->find('all',array('conditions'=>array('AdDetail.is_active'=>1)));
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
	
	function setAprRej($allData)
	{
		App::import('Model','AdDetail');
		$setAdDetails = new AdDetail();
		$adDetailID = '';
		
		if($allData['env'] == 'approve')
		{
			$setAdDetails->query("UPDATE `ad_details` set `status`=1, `approved_date`=NOW() where `id`='".$allData['advertiseId']."'");
			$adDetailID = 1;
		}
		else if($allData['env'] == 'reject')
		{
			$setAdDetails->query("UPDATE `ad_details` set `status`=2 where `id`='".$allData['advertiseId']."'");
			$adDetailID = 2;
		}
		
		return $adDetailID;
	}	
}

?>