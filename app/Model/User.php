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
		
		$user['User']['first_name'] = '';
		$user['User']['last_name'] = '';
		$user['User']['email'] = $userDetails['email'];
		$user['User']['encrypted_password'] = $userDetails['pass'];
		$user['User']['admin'] = 0;
		$user['User']['reset_token'] = '';
		$user['User']['confirmation_token'] = '';
		$user['User']['is_active'] = 1;
		
		$saveUser = $userall->save($user);
		return $saveUser;
	}
}