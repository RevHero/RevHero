<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $helpers = array('Html', 'Form');
	public $components = array('Auth','Session','Format'); //Including the required components
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		if(!defined('PAGE_NAME')) { 
			define('PAGE_NAME', $this->action); //This require to hold the action name
		}
		
		if($this->Auth->User("id")){ //If the user logs in correctly
		
			if (!defined('WWW_ROOT')) {
				define('WWW_ROOT', dirname(__FILE__) . DS);
			}
		
			if(PAGE_NAME == "home"){ //If the user is logged in and then redirecting to home page, it automatically redirects to dashboard page
				$this->redirect(HTTP_ROOT."users/dashboard");
			}
			
			//$this->set('loginresult',$this->Session->read("LOGINDISPLAY")); //Required to hold the value for displaying the error msg for invalid login
			//$this->Session->write("LOGINDISPLAY","");
			
			$this->set('loginstatus',$this->Session->read("LOGINSTATUS")); //Requires to jold the session for the loggedin users.
		}else{ //if the user is coming to the site without login
			$this->set('success',$this->Session->read("SUCCESS"));
			$this->set('confirmReg',$this->Session->read("CONFIRMREG"));
			$this->set('loginresult',$this->Session->read("ERRORLOGINDISPLAY"));
			$this->set('pass_success',$this->Session->read("PASS_SUCCESS"));
			$this->set('error_email_reset',$this->Session->read("ERROR_EMAIL_RESET"));
			
			if(PAGE_NAME == "dashboard"){ //Automatically redirects to home page if the user wants to go to dashboard page without login.
				$this->redirect(HTTP_ROOT);
			}
			
			$this->Auth->autoRedirect = false;
			Security::setHash('md5'); //Setting for conveting the password to hash format
			$this->Auth->allow('home','confirmation','login','forgotpassword'); //here we have to specify the actions which we want to load without the user authentication.
			
			$this->Session->write("SUCCESS","");
			$this->Session->write("CONFIRMREG","");
			$this->Session->write("ERRORLOGINDISPLAY","");
			$this->Session->write("PASS_SUCCESS","");
			$this->Session->write("ERROR_EMAIL_RESET",'');
		}	
	}
}
