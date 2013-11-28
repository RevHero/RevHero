<?php
class UsersController extends AppController {
    public $name = 'Users';
	
	function home($error = NULL)
	{
		$this->layout = 'default';
		$this->loadModel('PromoCode');
		$this->loadModel('PromoUser');
		$this->set('title_for_layout', 'Home');
		
		if($this->Session->read('Auth.User.id')){
			$this->redirect(HTTP_ROOT."users/dashboard");
		}
		//echo "<pre>";print_r($this->request->data);exit;
		if(!empty($this->request->data))
		{
			$email = $this->request->data['User']['email'];
			$this->request->data['User']['pass'] = $this->Auth->password($this->request->data['User']['pass']);
			$this->request->data['User']['uniq_id'] = $this->Format->generateUniqNumber();
			
			$getDuplicate = $this->User->CheckDuplicate($email); //This is require to check the DUPLICATE registration with the same Email.
			
			if(!$getDuplicate){ //If the Email id is not present in the database
				$successSave = $this->User->saveUserDetails($this->request->data['User']);
				if($successSave){
					$this->logincheck($email,$this->request->data['User']['pass']);
				}
			}else{ //If the USER email is already present in the database
				$this->Session->write("SUCCESS","0");
				$this->redirect(HTTP_ROOT);
			}
		}
		if($this->Session->read("VISITORAD")){
			$this->loadModel('AdDetail');
			$getDetails = $this->AdDetail->getAdDetails($this->Session->read("VISITORAD"));
			//pr($getDetails);exit;
			if($getDetails && count($getDetails) >0){
				$this->set('anonymousads', array($getDetails));
				$this->set('home', 1);
			}
			$this->Session->write("VISITORAD","");
		}
		if($this->Session->read("VISITORPLACEMENT")){
			$this->loadModel('Placement');
			$getDetails = $this->Placement->find('all', array('conditions'=>array('Placement.id'=>$this->Session->read("VISITORPLACEMENT"))));
			//pr($getDetails);exit;
			if($getDetails && count($getDetails) >0){
				$this->set('anonymousplacements', array($getDetails));
				$this->set('home', 1);
			}
			$this->Session->write("VISITORPLACEMENT","");
		}
	}
	
	public function login($emailConf= NULL,$passConf= NULL)
	{
		$this->redirect(HTTP_ROOT);
	}
	
	//Require to implement the login functionality
	public function logincheck($emailConf= NULL,$passConf= NULL)
	{
		if($this->Session->read('Auth.User.id')){
			$this->redirect(HTTP_ROOT."users/dashboard");
		}
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
				$this->User->recursive = -1;
				$usrLogin = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['User']['email'],'User.encrypted_password'=>$this->request->data['User']['encrypted_password'],'User.is_active'=>1)));
				
				//echo "<pre>";print_r($usrLogin);exit;
				
				$this->Session->write('Auth.User',@$usrLogin['User']);
			}
			
			//Below Condition 1 || UserId || Auth UserId
			if(($this->Auth->login() || isset($usrLogin['User']['id'])) && $this->Auth->user('id'))
			{
				//$this->Session->write("LOGINSTATUS","1");
				if($usrLogin['User']['admin'] == 1)
				{
					$this->redirect(HTTP_ROOT."revadmins/admin_dashboard");
				}
				else
				{
					$this->redirect(HTTP_ROOT."users/dashboard");
				}	
			}
			else
			{
				$this->Session->write("ERRORLOGINDISPLAY","0");
				$this->redirect(HTTP_ROOT);
			}
		}
		else{ //This is require if the user manually enter this action without login, then he will be redirected to the home page/login page
			$this->redirect(HTTP_ROOT);
		}
		exit;
	}
	
	function dashboard()
	{
		$this->set('title_for_layout', 'Dashboard');
		$advcookie = $this->Cookie->read('advertised');
		if(!empty($advcookie)){
			$this->redirect(HTTP_ROOT."ads/anonymousads");
		}
		
		$placementcookie = isset($_COOKIE['publish_placement'])?$_COOKIE['publish_placement']:'';
		if(!empty($placementcookie)){
			$this->redirect(HTTP_ROOT."ads/anonymousplacements");
		}
		$this->layout = 'default';
		$this->loadModel('Placement');
		$this->loadModel('AdDetail');
		$userId = $this->Session->read('Auth.User.id');
		$gettotalplacementcounts = $this->Placement->allplacementdetails($userId);
		$conditions = array('Placement.is_active'=>1, 'Placement.publisher_id'=>$userId);
		$this->paginate = array(
			'conditions' => $conditions,
			'limit' => 5,
			'order' => array('Placement.created'=>'DESC'),
		);
		
		$getallplacements = $this->paginate('Placement');
		$getallActiveAdsforUser = $this->AdDetail->getAllAds($this->Auth->user('id'));
		$getallApprovedAds = $this->AdDetail->find('count', array('conditions'=>array('AdDetail.is_active'=>1, 'AdDetail.status'=>1)));
		
		$this->set('getallplacements', $getallplacements);
		$this->set('totalplacementcounts', $gettotalplacementcounts);
		
		$this->set('countgetallActivedAds', count($getallActiveAdsforUser));
		$this->set('countgetallApprovedAds', $getallApprovedAds);
	}
	
	function logout()
	{	
		$this->Session->write('Auth.User.id','');
		$this->Session->write('profile_image','');
		$this->Session->destroy();
		$this->Auth->logout();
		$this->redirect(HTTP_ROOT);
	}
	
	function forgotpassword() 
	{
		$this->set('title_for_layout', 'Forgot Password');
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
	
	function placementdetails($placementId = NULL)
	{
		$this->layout = 'default';
		$this->set('title_for_layout', 'Placement Details');
		$this->loadModel('Placement');
		$this->loadModel('AdClick');
		$this->AdClick->recursive = -1;
		
		if(isset($placementId) && $placementId != '')
		{
			$getplacementdetails = $this->Placement->find('all', array('conditions'=>array('Placement.id'=>$placementId, 'Placement.publisher_id'=>$this->Auth->user('id'))));
			if($getplacementdetails && count($getplacementdetails) > 0)
			{
				$this->set('getDetails',$getplacementdetails[0]);
				
				$getclickdetails = $this->AdClick->getChartResult($placementId,'0'); //0 is used to get the click count for only unique clicks
				
				$getTotalClickIncludesDuplicateClick = $this->AdClick->getChartResult($placementId, '1'); //1 is used to get all click count including duplicate click
				
				$dt_arr=array();
				$unique_clicks=array();
				$all_duplicate_clicks=array();
				foreach($getclickdetails as $eachclick) //Building array to hold the count for unique clicks
				{
					$dt=date('M j, Y',strtotime(date("Y-m-d", strtotime($eachclick['AdClick']['created']))));
					array_push($dt_arr,$dt);
					array_push($unique_clicks,(int)$eachclick[0]['clickCount']);
				}
				
				foreach($getTotalClickIncludesDuplicateClick as $eachduplicateclick) //Building the array to hold the count for all clicks including duplicate clicks
				{
					array_push($all_duplicate_clicks, (int)$eachduplicateclick[0]['clickCount']);
				}
				
				$carr = array(array('name'=>'Unique Clicks','color'=>'#36A7E7','connectNulls'=> 'true','data'=>$unique_clicks), array('name'=>'Total(including duplicate) Clicks','color'=>'#910000','connectNulls'=> 'true','data'=>$all_duplicate_clicks));
				$this->set('dt_arr',json_encode($dt_arr));
				$this->set('all_clicks',json_encode($carr));
			}
			else
			{
				$this->redirect(HTTP_ROOT."users/dashboard/");
			}
		}
		else
		{
			$this->redirect(HTTP_ROOT."users/dashboard/");
		}	
	}
	
	function profile()
	{
		$this->layout = 'default';
		$this->set('title_for_layout', 'Profile');
		if($this->request['data'] && $this->request['data']['profile']['uploadimage']['tmp_name'] != '' && $this->request['data']['profile']['uploadimage']['name'] != '')
		{
			$photo_name = $this->Format->uploadPhoto($this->request['data']['profile']['uploadimage']['tmp_name'],$this->request['data']['profile']['uploadimage']['name'],$this->request['data']['profile']['uploadimage']['size'],DIR_PROFILE_IMAGES,SES_ID,"profile_img");
			
			if($photo_name){
				if($this->request['data']['hid_old_prof_img'] && file_exists(DIR_PROFILE_IMAGES.$this->request['data']['hid_old_prof_img'])){
					unlink(DIR_PROFILE_IMAGES.$this->request['data']['hid_old_prof_img']);
				}	
				$saveImage['User']['id'] = SES_ID;
				$saveImage['User']['prof_image'] = $photo_name;
				$saveImageName = $this->User->save($saveImage);
			}	
		}
		
		$this->User->recursive = -1;		
		$getProfileImage = $this->User->find('all', array('fields'=>array('User.prof_image'),'conditions'=>array('User.id'=>SES_ID)));
		$this->Session->write("profile_image", $getProfileImage[0]['User']['prof_image']);
	}
	
	function registration()
	{
		if($this->Session->read('Auth.User.id')){
			$this->redirect(HTTP_ROOT."users/dashboard");
		}
		$this->layout = 'default';
		$this->loadModel('PromoCode');
		if(isset($this->request->query['promocode']) && $this->request->query['promocode'] != '') //If PROMOCODE present in the query string
		{
			$promo_code = $this->request->query['promocode'];
			
			if(isset($promo_code) && $promo_code != '') //If user providing the PROMO CODE
			{
				$isValidPromo = $this->PromoCode->getValidatePromoCode($promo_code);
				if(count($isValidPromo) > 0){
					$this->set('displaypromo', @$promo_code);
					$this->set('promocodeId', @$isValidPromo[0]['PromoCode']['id']);
				}else{
					$this->set('displaypromo', @$promo_code);
					$this->set('errorMsg', "<b class='text-error'>This is a invalid promo code</b>");
					//$this->Session->write("SUCCESS","2"); //This is require to set if the user is giving INVALID Promo Code
					//$this->redirect(HTTP_ROOT);
				}
			}
		}
		else //If user is not giving promocode or trying to run the url with only registration action name
		{
			$this->set('displaypromo', @$promo_code);
			$this->set('errorMsg', "<b class='text-error'>Please enter a valid URL with promo code</b>");
			//$this->redirect(HTTP_ROOT);
		}
		
		if(isset($this->request->data['User']))
		{
			$this->loadModel('User');
			$this->loadModel('PromoUser');
			//echo "<pre>";print_r($this->request->data['User']);exit;
			
			if($this->request->data['User']['hid_error'] == 0 && $this->request->data['User']['hid_error'] != 1)
			{
				$email = $this->request->data['User']['email'];
				$this->request->data['User']['pass'] = $this->Auth->password($this->request->data['User']['pass']);
				
				$getDuplicate = $this->User->CheckDuplicate($email); //This is require to check the DUPLICATE registration with the same Email.
				
				if(!$getDuplicate){ //If the Email id is not present in the database
					$successSave = $this->User->saveUserDetails($this->request->data['User']);
					if($successSave){
						$promocodeId = $this->PromoCode->getPromoIdFromPromoCode($this->request->data['User']['promo']); //Get the promo code id from promo code
						$this->PromoUser->saveDetails($successSave, $promocodeId); //This is require to store respective data for user and promo
						$this->logincheck($this->request->data['User']['email'], $this->request->data['User']['pass']);
					}
				}else{ //If the USER email is already present in the database
					$this->Session->write("SUCCESS","0");
					$this->redirect(HTTP_ROOT."users/registration?promocode=".$this->request->data['User']['promo']);
				}
			}
			else
			{
				$this->redirect(HTTP_ROOT."users/registration?promocode=".$this->request->data['User']['promo']);
			}	
		}
	}
}