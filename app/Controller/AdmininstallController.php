<?php
	/**
	 * FOR ADMIN SETUP FIRS TIME
	 */

class AdmininstallController extends AppController {
    public $name = 'Admininstall';

	function index()
	{
		if($this->Session->read('Auth.User.id')){
			$this->redirect(HTTP_ROOT);
		}
		$this->layout = 'default';
		$this->loadModel('User');

		$this->User->recursive = -1;
		
		//pr($this->data);exit;
		if(isset($this->data) && $this->data)
		{
			$configAdminUser['email'] = $this->data['email'];
			$configAdminUser['encrypted_password'] = md5($this->data['pass']);
			$configAdminUser['admin'] = 1;
			$configAdminUser['is_active'] = 1;
			
			$successSave = $this->User->save($configAdminUser);
			if($successSave)
			{
				$this->redirect(HTTP_ROOT."users/logincheck/".$this->data['email']."/".$this->data['pass']);
			}
		}
		else
		{
			$findAdmin = $this->User->find("count", array('conditions'=>array('User.admin'=>1)));
			if($findAdmin == 0)
			{
				$this->set('AdminReg', 0);
			}
			else
			{
				$this->set('AdminReg', 1);
			}
		}	
	}
}
?>