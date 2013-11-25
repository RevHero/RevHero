<?php
class User extends AppModel{
	public $name = 'User';
	
	var $hasMany = array(
		'AdDetail' => array(
			'className' => 'AdDetail',
			'foreignKey' => 'advertiser_id',
			'dependent' => false, //When dependent is set to true, recursive model deletion is possible. In this example, AdDetail records will be deleted when their associated User record has been deleted.
			'conditions' => '',
			'fields' => '',
			'order' => array('AdDetail.created' => 'DESC'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Placement' => array(
			'className' => 'Placement',
			'foreignKey' => 'publisher_id',
			'dependent' => false, //When dependent is set to true, recursive model deletion is possible. In this example, Publisher records will be deleted when their associated User record has been deleted.
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
	
	function CheckDuplicate($email) // Function require to check duplicate email in database
	{
		App::import('Model','User');
		$useralls = new User(); 
		
		$getUser = $useralls->find('first',array('conditions'=>array('email'=>$email))); //The query requires for checking from dtabase
		if(@$getUser['User']['email'] && @$getUser['User']['email'] != ''){
			return true;
		}else{
			return false;
		}
	}
	
	function saveUserDetails($userDetails) // This is require to save the user details in the users table in database
	{
		App::import('Model','User');
		$userall = new User();
		
		App::import('Model','PromoUser');
		$promouser = new PromoUser();
		
		$user['User']['first_name'] = '';
		$user['User']['last_name'] = '';
		$user['User']['email'] = $userDetails['email'];
		$user['User']['encrypted_password'] = $userDetails['pass'];
		$user['User']['admin'] = 0;
		$user['User']['reset_token'] = '';
		$user['User']['confirmation_token'] = '';
		$user['User']['is_active'] = 1;
		
		$saveUser = $userall->save($user);
		$userLastID = $userall->getLastInsertID();
		return $userLastID;
	}
	
	function getDetailsUser()
	{
		App::import('Model','AdDetail');
		$adcount = new AdDetail();
		
		App::import('Model','Placement');
		$publishcnt = new Placement();
		$getUser = $this->find('all', array('conditions'=>array('User.admin'=>0), 'order'=>array('User.created desc')));
		
		/* Query for getting the details for ANONYMOUS user STARTS here */
		
		$createdAdCount = $adcount->find('count', array('conditions'=>array('AdDetail.advertiser_id'=>0)));
		$publishedAdCount = $publishcnt->find('count', array('conditions'=>array('Placement.publisher_id'=>0)));
		$mainArr[0]['user_id'] = 0;
		$mainArr[0]['email'] = 'Anonymous User';
		$mainArr[0]['profile_image'] = '';
		$mainArr[0]['createdAdCount'] = $createdAdCount;
		$mainArr[0]['publishedAdCount'] = $publishedAdCount;
		$mainArr[0]['signedUp'] = '';
		$mainArr[0]['is_active'] = '';
		$mainArr[0]['promocode'] = '';
		
		/* Query for getting the details for ANONYMOUS user ENDS here */
		
		$arrCount = 1; //Tha array starts at counter number 1. The 0 element goes to the ANONYMOUS user
		foreach($getUser as $user)
		{
			//This is required to get the promocode details for that particular user
			$getPromoCodeForUser = $this->query("SELECT `promo_codes`.`promocode` from `promo_codes`, `promo_users` where `promo_codes`.`id`=`promo_users`.`promo_id` and `promo_users`.`user_id`='".$user['User']['id']."'");
			
			$createdAdCount = $adcount->find('count', array('conditions'=>array('AdDetail.advertiser_id'=>$user['User']['id'])));
			$publishedAdCount = $publishcnt->find('count', array('conditions'=>array('Placement.publisher_id'=>$user['User']['id'])));
			$mainArr[$arrCount]['user_id'] = $user['User']['id'];
			$mainArr[$arrCount]['email'] = $user['User']['email'];
			$mainArr[$arrCount]['profile_image'] = $user['User']['prof_image'];
			$mainArr[$arrCount]['createdAdCount'] = $createdAdCount;
			$mainArr[$arrCount]['publishedAdCount'] = $publishedAdCount;
			$mainArr[$arrCount]['signedUp'] = $user['User']['created'];
			$mainArr[$arrCount]['is_active'] = $user['User']['is_active'];
			$mainArr[$arrCount]['promocode'] = @$getPromoCodeForUser[0]['promo_codes']['promocode'];
			$arrCount++;
		}
		return $mainArr;
	}
	
}