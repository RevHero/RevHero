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
	
	function edit_promo($editId = NULL)
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
			if(isset($editId) && $editId != ''){
				$getEditData = $this->PromoCode->AllPromoCodes($editId);
				if($getEditData && count($getEditData) > 0){
					$this->set('getEditData', $getEditData);
				}else{
					$this->redirect(HTTP_ROOT."revadmins/promo_code"); //If the user is providing manually the wrong promo id
				}
			}else{
				$this->redirect(HTTP_ROOT."revadmins/promo_code"); //if the user is removing the ID manually
			}	
		}	
	}
	
	function admin_profile()
	{
		$this->layout = 'default_admin';
		$this->loadModel('User');
		
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
	
	function allusers()
	{
		$this->layout = 'default_admin';
		$this->loadModel('User');
		$this->User->recursive = -1;
		
		$getUserDetailsWithPromoCode = $this->User->getDetailsUser();
		//echo "<pre>";print_r($getUserDetailsWithPromoCode);exit;
		$this->set('UserDetailsWithPromoCode', $getUserDetailsWithPromoCode);
	}
	
	function promodetails($promoid = NULL)
	{
		$this->layout = 'default_admin';
		$this->loadModel('PromoCode');
		
		if(isset($promoid) && $promoid != ''){
			$PromoDetails = $this->PromoCode->getPromoDetails($promoid);
			$promoUsedUsers = $this->PromoCode->getRespectiveUsers($promoid);
			
			if($PromoDetails && $promoUsedUsers && $promoUsedUsers != '' && $PromoDetails != ''){
				$this->set('PromoDetails', $PromoDetails);
				$this->set('promoUsedUsers', $promoUsedUsers);
			}else{
				$this->redirect(HTTP_ROOT."revadmins/promo_code");
			}
		}else{
			$this->redirect(HTTP_ROOT."revadmins/promo_code");
		}	
	}
}