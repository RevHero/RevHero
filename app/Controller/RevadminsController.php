<?php
class RevadminsController extends AppController {
    public $name = 'Revadmins';
	
	function index()
	{
		if($this->Session->read('Auth.User.id')){
			$this->redirect(HTTP_ROOT."revadmins/admin_dashboard");
		}else{	
			$this->redirect(HTTP_ROOT);
		}
		
	}
	
	function admin_dashboard()
	{
		$this->layout = 'default_admin';
		$this->loadModel('AdDetail');
		$AllAdDetails = $this->AdDetail->getAllAds();
		//echo "<pre>";print_r($AllAdDetails);exit;
		$this->set('AllAdDetails', $AllAdDetails);
	}
	
	function setApproveReject()
	{
		$this->layout = 'ajax';
		$this->loadModel('AdDetail');
		
		$return = $this->AdDetail->setAprRej($this->request->data);
		
		$json_arr['advertise_id'] = $this->request->data['advertiseId'];
		$json_arr['status'] = $return;
		
		echo json_encode($json_arr);exit;
	}
}
