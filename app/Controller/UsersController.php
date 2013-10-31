<?php
class UsersController extends AppController {
    public $name = 'Users';
	
	function home($error = NULL)
	{
		$this->layout = 'default';		
		if($this->Session->read('Auth.User.id')){
			$this->redirect(HTTP_ROOT."users/dashboard");
		}
		
		if(!empty($this->request->data))
		{
			if(!empty($this->request->data['User']['registration']) && $this->request->data['User']['registration'] == 1)
			{
				$fname = $this->request->data['User']['fname'];
				$lname = $this->request->data['User']['lname'];
				$email = $this->request->data['User']['email'];
				$this->request->data['User']['pass'] = $this->Auth->password($this->request->data['User']['pass']);
				$this->request->data['User']['uniq_id'] = $this->Format->generateUniqNumber();
				
				$getDuplicate = $this->User->CheckDuplicate($email); //This is require to check the DUPLICATE registration with the same Email.
				
				if(!$getDuplicate){ //If the Email id is not present in the database
					$from = 'test@andolasoft.com';
					$to = $email;
					$subject = 'Welcome to RevHero!';
					$message = '<table>
									<tr><td><p>Hi '.$fname.' '.$lname.',</p></td></tr>
									<tr><td>Thank you for registering with RevHero!</td></tr>
									<tr><td>Please click on the link below to confirm your account registration</td></tr>
									<tr><td>'.HTTP_ROOT.'users/confirmation/'.$this->request->data['User']['uniq_id'].'</td></tr>
									<tr><td height="20"></td></tr>
									<tr><td>Thanks,</td></tr>
									<tr><td>RevHero Team</td></tr>
								</table>';
					$replyto = 'test@andolasoft.com';
					
					$return = $this->Format->sendConfirmEmail($from, $to, $subject, $message, $replyto); //This is require to send the confirmation message to email
					if($return){
						$successSave = $this->User->saveUserDetails($this->request->data['User']);
						if($successSave){
							$this->Session->write("SUCCESS","1");
							$this->redirect(HTTP_ROOT);
						}
					}
				}else{ //If the USER email is already present in the database
					$this->Session->write("SUCCESS","0");
					$this->redirect(HTTP_ROOT);
				}
			}
		}
	}
	
	//Require to confirm the user after registration when clicks the link in Email
	function confirmation($uniq_id = NULL){
		$chkActivation = $this->User->find('first',array('conditions'=>array('User.confirmation_token'=>$uniq_id)));
		if($chkActivation['User']['id']) {
			$usr['User']['id'] = $chkActivation['User']['id'];
			$usr['User']['is_active'] = 1;
			$usr['User']['confirmation_token'] = '';

			if($this->User->save($usr)){
				$this->Session->write("CONFIRMREG","1");
				$this->redirect(HTTP_ROOT);
			}
		}else{
			$this->Session->write("CONFIRMREG","0");
			$this->redirect(HTTP_ROOT);
		}
		exit;
	}
	
	public function login($emailConf= NULL,$passConf= NULL)
	{
		$this->redirect(HTTP_ROOT);
	}
	
	//Require to implement the login functionality
	public function logincheck($emailConf= NULL,$passConf= NULL)
	{
		if($emailConf && $passConf && $emailConf != '' && $passConf != ''){
			$email = $emailConf;
			$pass = $passConf;
		}else{
			$email = @$this->request->data['email'];
			$pass = @$this->request->data['password'];
		}
			
		if(!empty($email)){
			$usrLogin = array();
			if($email && $pass){
				$this->request->data['User']['email'] = $email;
				if(strlen($pass) == 32) {
					$this->request->data['User']['encrypted_password'] = $pass;
				}else {
					$this->request->data['User']['encrypted_password'] = md5($pass);
				}
				$usrLogin = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['User']['email'],'User.encrypted_password'=>$this->request->data['User']['encrypted_password'],'User.is_active'=>1)));
				
				$this->Session->write('Auth.User',@$usrLogin['User']);
			}
			
			//Below Condition 1 || UserId || Auth UserId
			if(($this->Auth->login() || isset($usrLogin['User']['id'])) && $this->Auth->user('id'))
			{
				//$this->Session->write("LOGINSTATUS","1");
				$this->redirect(HTTP_ROOT."users/dashboard");
			}
			else
			{
				$this->Session->write("ERRORLOGINDISPLAY","0");
				$this->redirect(HTTP_ROOT);
			}
		}
		exit;
	}
	
	function dashboard()
	{

	}
	
	function logout()
	{	
		$this->Session->write('Auth.User.id','');
		$this->Auth->logout();
		$this->redirect(HTTP_ROOT);
	}
	
	function forgotpassword() 
	{
		$this->set('passemail','10');
		if(!empty($this->request->data) && empty($this->request->data['User']['repass']) && empty($this->request->data['User']['newpass'])){
			$from = 'test@andolasoft.com';
			$to = trim($this->request->data['User']['email']);
			$this->User->recursive = -1;
			$getUsrData = $this->User->find("first",array('conditions' => array('User.email'=>$to,'User.is_active'=>1),'fields'=>array('User.id','User.first_name','User.last_name')));
			if($getUsrData && is_array($getUsrData) && count($getUsrData)){
				$id = $getUsrData['User']['id'];
				$name = stripslashes($getUsrData['User']['first_name']." ".$getUsrData['User']['last_name']);
				$qstr = md5(uniqid(rand()));
				$urlValue = "?qstr=".$qstr;
				$subject = SITE_NAME." Request for Reset Password";
				$message = "<table cellspacing='0' cellpadding='0'  width='100%' border='0' >
							<tr><td>&nbsp;</td></tr>
							<tr><td align='left' style='margin-top:10px;'>Hi ".$name.",</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td align='left' style='font:normal 12px verdana;padding-top:5px;'>You have requested to reset your password</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:5px;'>Click this link to reset your password:</td></tr>
							<tr>
								<td align='left' style='font-family:Arial;font-size:14px;line-height:22px;'>
									<a href='".HTTP_ROOT."users/forgotpassword/".$urlValue."' target='_blank'>".HTTP_ROOT."users/forgotpassword/".$urlValue."</a>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
						</table>
						";
						
				$return = $this->Format->sendConfirmEmail($from, $to, $subject, $message, ''); //This is require to send the confirmation message to email
				if($return){
					$this->User->query("UPDATE users SET reset_token='".$qstr."' WHERE id=".$id);
					$this->Session->write("PASS_SUCCESS","1");
					$this->redirect(HTTP_ROOT."users/forgotpassword/");
				}
			}
			else {
				$this->Session->write("PASS_SUCCESS","0");
				$this->Session->write("ERROR_EMAIL_RESET",$to);
				$this->Session->write("ERROR_RESET","<font style='color:red;'>Email '".$to."' doesn't exists in our records!</font>");
				$this->redirect(HTTP_ROOT."users/forgotpassword/");
			}
		}
		
		if(isset($_GET['qstr']) && $_GET['qstr'])
		{  
			$queryString = urldecode($_GET['qstr']);
			$this->User->recursive = -1;
			$getData =$this->User->query("SELECT User.id,User.email,User.first_name,User.last_name FROM users AS User WHERE User.reset_token='".$queryString."' AND User.is_active='1'");
			
			if(isset($getData) && count($getData) == 1)
			{
				$this->set('passemail','12');
				$this->set('user_id',$getData['0']['User']['id']);
			}
		}
		
		//echo "<pre>";print_r($this->request->data);exit;
		
		if(!empty($this->request->data) && !empty($this->request->data['User']['repass']) && !empty($this->request->data['User']['newpass']))
		{
			if($this->request->data['User']['repass']==$this->request->data['User']['newpass'])
			{
				$newMd5Passwrod = md5($this->request->data['User']['repass']);
				$id = $this->request->data['user_id'];			
				$this->User->query("UPDATE users SET encrypted_password='".$newMd5Passwrod."',reset_token='' WHERE id=".$id);
				$this->set('chkemail','11');
			}
		}
	}
}
