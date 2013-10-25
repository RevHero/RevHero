<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $helpers = array('Html', 'Form');
	public $components = array('Auth','Session','Format'); //Including the required components
	
	public function beforeFilter() {
		parent::beforeFilter();
		if($this->Auth->User("id")){ //If the user logs in correctly
			echo $this->Auth->user('istype');
		}else{ //if the user is coming to the site without login
			$this->Auth->autoRedirect = false;
			Security::setHash('md5'); //Setting for conveting the password to hash format
			$this->Auth->allow('home'); //here we have to specify the actions which we want to load without the user authentication.
		}	
	}
}
