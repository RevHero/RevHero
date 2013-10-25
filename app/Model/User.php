<?php
class User extends AppModel{
	public $name = 'User';
	
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
		
		$user['User']['first_name'] = $userDetails['fname'];
		$user['User']['last_name'] = $userDetails['lname'];
		$user['User']['email'] = $userDetails['email'];
		$user['User']['encrypted_password'] = $userDetails['pass'];
		$user['User']['admin'] = 0;
		$user['User']['reset_token'] = '';
		$user['User']['confirmation_token'] = $userDetails['uniq_id'];
		$user['User']['is_active'] = 0;
		
		$saveUser = $userall->save($user);
		return $saveUser;
	}
}