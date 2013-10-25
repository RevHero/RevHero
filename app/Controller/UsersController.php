<?php
class UsersController extends AppController {
    public $name = 'Users';
	
	function home($error = NULL)
	{
		$this->layout = 'default';		
		
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
									<tr><td>http://localhost/RevHero/users/confirmation/'.$this->request->data['User']['uniq_id'].'</td></tr>
									<tr><td height="20"></td></tr>
									<tr><td>Thanks,</td></tr>
									<tr><td>RevHero Team</td></tr>
								</table>';
					$replyto = 'test@andolasoft.com';
					
					$return = $this->Format->sendEmail($from, $to, $subject, $message, $replyto); //This is require to send the confirmation message to email
					if($return){
						$successSave = $this->User->saveUserDetails($this->request->data['User']);
						if($successSave){
							$this->redirect(HTTP_ROOT."RevHero/users/home");
						}
					}
				}else{ //If the USER email is already present in the database
					$this->redirect(HTTP_ROOT."RevHero/users/home");
				}
			}
		}
	}
}
