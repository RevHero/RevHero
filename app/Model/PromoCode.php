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
		if(isset($editId) && $editId != ''){
			$getAll = $this->find('all', array('conditions'=>array('PromoCode.id'=>$editId)));
		}else{
			$getAll = $this->find('all');
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
}