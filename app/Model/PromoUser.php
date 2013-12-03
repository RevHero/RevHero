<?php
class PromoUser extends AppModel{
	public $name = 'PromoUser';
	
	function saveDetails($saveUserId, $promoCodeid)
	{
		$promos['PromoUser']['user_id'] = $saveUserId;
		$promos['PromoUser']['promo_id'] = $promoCodeid;
		
		$savePromoUser = $this->save($promos);
		$lastinsertID = $this->getLastInsertID();
		return $lastinsertID;
	}
	
}