<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $helpers = array('Html', 'Form');
	public $components = array('Auth','Session','Format'); //Including the required components
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		if(!defined('CONTROLLER')) { 
			define('CONTROLLER', $this->params['controller']);
		}
		
		if(!defined('PAGE_NAME')) { 
			define('PAGE_NAME', $this->action); //This require to hold the action name
		}
		if($this->Auth->User("id")){ //If the user logs in correctly
			//This is require to restrict the user to enter the user section with loggedin as ADMIN
			if(CONTROLLER == 'users' || CONTROLLER == 'ads'){
				if(PAGE_NAME != 'logout'){
					if($this->Auth->User("admin") == 1){
						$this->redirect(HTTP_ROOT."revadmins");
					}
				}	
			}
			
			//This is require to restrict the user to enter the admin section without the admin credential. By loggedin with normal user credentials.
			if(CONTROLLER == 'revadmins'){
				if(!$this->Auth->User("admin") == 1){
					$this->redirect(HTTP_ROOT);
				}
			}
			
			if(CONTROLLER == 'deploy'){
				$this->redirect(HTTP_ROOT."deploy/index");
			}
			
			if (!defined('WWW_ROOT')) {
				define('WWW_ROOT', dirname(__FILE__) . DS);
			}
			
			if(!defined('SES_ID')) { 
				define('SES_ID', $this->Auth->User("id"));
			}
			
			if(PAGE_NAME == "home"){ //If the user is logged in and then redirecting to home page, it automatically redirects to dashboard page
				$this->redirect(HTTP_ROOT."users/dashboard");
			}
			
			$this->set('successaddsave',$this->Session->read("SAVEADDSUCCESS"));
			$this->Session->write("SAVEADDSUCCESS","");
			
			/* Code retriving for PROFILE IMAGE in the header part for both USER and ADMIN starts here */
			
			$User = ClassRegistry::init('User');
			$get_profile_image = $User->query("SELECT `prof_image` from `users` where `id`='".$this->Auth->User("id")."'");
			$this->Session->write("profile_image", $get_profile_image[0]['users']['prof_image']);
			
			/* Code retriving for PROFILE IMAGE in the header part for both USER and ADMIN starts here */
			
			//$this->set('loginstatus',$this->Session->read("LOGINSTATUS")); //Requires to hold the session for the loggedin users.
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
			$this->Auth->allow('home','confirmation','logincheck','forgotpassword','admin_login','route_url','index','registration'); //here we have to specify the actions which we want to load without the user authentication.
			
			$this->Session->write("SUCCESS","");
			$this->Session->write("CONFIRMREG","");
			$this->Session->write("ERRORLOGINDISPLAY","");
			$this->Session->write("PASS_SUCCESS","");
			$this->Session->write("ERROR_EMAIL_RESET",'');
		}	
	}
}
