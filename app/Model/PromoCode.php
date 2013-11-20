<?php
class PromoCode extends AppModel{
	public $name = 'PromoCode';
	
	function checkDuplicate($pcode)
	{
		$checkRequire = $this->find('all', array('conditions'=>array('PromoCode.promocode'=>$pcode, 'PromoCode.status'=>1)));
		if($checkRequire){
			return 1;
		}else{
			return 0;			
		}
	}
	
	function saveDetails($request)
	{
		if(isset($request['hid_edit_id']) && $request['hid_edit_id'] != ''){
			$pcode['PromoCode']['id'] = $request['hid_edit_id'];
		}
		
		$pcode['PromoCode']['promocode'] = $request['pcode'];
		$pcode['PromoCode']['price']     = $request['amount'];
		$pcode['PromoCode']['validFrom'] = $request['datepickerFrom'];
		$pcode['PromoCode']['validTo']   = $request['datepickerTo'];
		$pcode['PromoCode']['status']    = 1;
		
		$saveAll = $this->save($pcode);
		//$lastinsertid = $this->getLastInsertID();
		return 1;
	}
	
	function AllPromoCodes($editId = NULL)
	{
		App::import('Model','User');
		$usercount = new User(); 
		
		if(isset($editId) && $editId != ''){
			$getAll = $this->find('all', array('conditions'=>array('PromoCode.id'=>$editId)));
		}else{
			$getAll = $this->find('all', array('order'=>array('PromoCode.created DESC')));
		}
		$usercounter = 0;
		foreach($getAll as $single)
		{
			$totalUserCount = $usercount->query("select count(users.id) as totalUsers from users, promo_users where users.id=promo_users.user_id and promo_users.promo_id='".$single['PromoCode']['id']."'");
			$getAll[$usercounter]['userCount'] = $totalUserCount[0][0]['totalUsers'];
			$usercounter++;
		}	
			
		return $getAll;
	}
	
	function setEnaDis($allData)
	{
		$adDetailID = '';
		
		if($allData['env'] == 'enable')
		{
			$this->query("UPDATE `promo_codes` set `status`=1 where `id`='".$allData['promoId']."'");
			$adDetailID = 1;
		}
		else if($allData['env'] == 'disable')
		{
			$this->query("UPDATE `promo_codes` set `status`=0 where `id`='".$allData['promoId']."'");
			$adDetailID = 0;
		}
		
		return $adDetailID;
	}
	
	function deletePromo($promoId)
	{
		$delete = $this->query("DELETE from `promo_codes` where `id`='".$promoId."'");
		return 1;
	}
	
	function getValidatePromoCode($promo_code)
	{
		$today = date('Y-m-d');
		$getValid = $this->find('all', array('conditions'=>array('PromoCode.promocode'=>$promo_code, 'PromoCode.validFrom <= '=>$today, 'PromoCode.validTo >= '=>$today, 'PromoCode.status'=>1)));
		
		return $getValid;
	}
	
	function getRespectiveUsers($promo_id)
	{
		$getAllUsers = $this->query("select users.* from users, promo_users where users.id=promo_users.user_id and promo_users.promo_id='".$promo_id."' order by created desc");
		return $getAllUsers;
	}
	
	function getPromoDetails($promoID)
	{
		$getAll = $this->find('all', array('conditions'=>array('PromoCode.id'=>$promoID)));
		return $getAll;
	}
	
	function getPromoIdFromPromoCode($promoCode)
	{
		$getpromocodeid = $this->find('all', array('fields'=>array('PromoCode.id'), 'conditions'=>array('PromoCode.promocode'=>$promoCode)));
		return $getpromocodeid[0]['PromoCode']['id'];
	}
}