<?php
class UsersController extends AppController {
    public $name = 'Users';
	
	function home($error = NULL)
	{
		$this->layout = 'default';		
		
		/*if(!empty($this->request->data))
		{
			$submitVal = $this->request->data['submit_Pass'];
			$betaEmail = $this->request->data['User']['email'];
			
			if(!(empty($submitVal)))
			{
				$return = $this->Format->checkEmailExists($betaEmail);
				//echo $return;exit;
				
				if($return == 1) //Present in both user table and betauser table  //User Already Exists
				{
                         $this->Session->write("ERROR","This email is already registered.");
					$this->redirect(HTTP_ROOT."users/home"); 
				}
				else if($return == 2) //Present in beta table but not in user table and is_approve in 1  //Your beta user has been approved
				{
					$this->Session->write("ERROR","This email is already registered.");
					$this->redirect(HTTP_ROOT."users/home"); 
				}
				else if($return == 3) //Present in beta table but not in user table and is_approve in 0  //Your beta user has been disapproved
				{
					$this->Session->write("ERROR","This email is already registered for beta user.");
					$this->redirect(HTTP_ROOT."users/home"); 
				}
				else if($return == 4) //Present in user table and not present in betauser table  //User Already Exists
				{
					$this->Session->write("ERROR","This email is already registered.");

					$this->redirect(HTTP_ROOT."users/home"); 
				}
				else if($return == 5) //Not present in both user and beta user table //Your beta user request has been sent
				{
					$this->loadModel('BetaUser');
					
					$betauser['BetaUser']['email'] = $betaEmail;
					$betauser['BetaUser']['registered_at'] = GMT_DATETIME;
					
                         $ip = $this->Format->getRealIpAddr();
			          $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip);
			          if(isset($tags['city']) && isset($tags['region']) && isset($tags['country']) && $tags['city'])
			          {
				          $location = $tags['city'].", ".$tags['region'].", ".$tags['country'];
				          if(isset($tags['longitude']) && isset($tags['latitude'])) {
					          $location.= "\nIP: ".$ip.", lon/lat: ".$tags['longitude']."/".$tags['latitude'];
				          }
			          }
			          else {
				          $location.= "\nIP: ".$ip;
			          }

					$from = $betaEmail;
					$to = "rpt@andolasoft.com";
					//$subject = "Beta User";
                         $subject = "Beta user registered";                              
					//$message = "The User is just now sent a request for beta functionality";
                         $message =  "<p style='font-family:Arial;font-size:14px;'>
							<p style='font-family:Arial;font-size:14px;'>Dear site administrator,<p>
							<p style='font-family:Arial;font-size:14px;'>You're lucky today, a new beta user has registered with OrangeScrum.</p>
                                     <p style='font-family:Arial;font-size:14px;'>  Invite him/her by approving the user through the admin panel. </p>
							<p>&nbsp;</p>
							<p style='font-family:Arial;font-size:14px;'><b>Email:</b> ".$betaEmail."</p>
							<p style='font-family:Arial;font-size:14px;'><b>Location:</b> ".nl2br($location)."</p>
						</p>";
					$sendEmailAdmin = $this->Sendgrid->sendGridEmail($from,$to,$subject,$message,"Beta User",$betaEmail);
					
					if($sendEmailAdmin)
					{
						if($this->BetaUser->save($betauser))
						{
							$this->Session->write("SUCCESS","You have successfully registered for beta user.You will get an invitation link soon.");
					          $this->redirect(HTTP_ROOT."users/home"); 
						}
					}	
				}
			}
		}*/
		
	}
}
