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
	
	function admin_config()
	{
		$this->layout = 'default_admin';
		if($this->request->data){
			$this->request->data['duplicateDays'];
		}
	}
	
	function promo_code()
	{
		$this->layout = 'default_admin';
		$this->loadModel('PromoCode');
		$getAllPromo = $this->PromoCode->AllPromoCodes();
		$this->set('getAllPromo', $getAllPromo);
	}
	
	function promo_code_exists()
	{
		$this->layout = 'ajax';
		$this->loadModel('PromoCode');
		if($this->request->data){
			$return = $this->PromoCode->checkDuplicate($this->request->data['pcode']);
			$json_arr['status'] = $return;
			echo json_encode($json_arr);exit;
		}
	}
	
	function add_promo()
	{
		$this->layout = 'default_admin';
		$this->loadModel('PromoCode');
		
		if($this->request->data){
			//echo "<pre>";print_r($this->request->data);
			$savePromoCode = $this->PromoCode->saveDetails($this->request->data);
			if($savePromoCode){
				$this->redirect(HTTP_ROOT."revadmins/promo_code");
			}else{
				$this->redirect(HTTP_ROOT."revadmins/index");
			}
		}
	}
	
	function setEnableDisable()
	{
		$this->layout = 'ajax';
		$this->loadModel('PromoCode');
		
		$return = $this->PromoCode->setEnaDis($this->request->data);
		
		$json_arr['promo_id'] = $this->request->data['promoId'];
		$json_arr['status'] = $return;
		
		echo json_encode($json_arr);exit;
	}
	
	function deletePromo()
	{
		$this->layout = 'ajax';
		$this->loadModel('PromoCode');
		$deletereturn = $this->PromoCode->deletePromo($this->request->data['promoId']);
		
		$json_arr['promo_id'] = $this->request->data['promoId'];
		$json_arr['status'] = $deletereturn;
		
		echo json_encode($json_arr);exit;
	}
	
	function edit_promo($editId)
	{
		$this->layout = 'default_admin';
		$this->loadModel('PromoCode');
		//echo "<pre>";print_r($this->request);exit;
		if($this->request->data){
			$savePromoCode = $this->PromoCode->saveDetails($this->request->data);
			
			if($savePromoCode){
				$this->redirect(HTTP_ROOT."revadmins/promo_code");
			}
		}else{
			$getEditData = $this->PromoCode->AllPromoCodes($editId);
			$this->set('getEditData', $getEditData);
		}	
	}
}
