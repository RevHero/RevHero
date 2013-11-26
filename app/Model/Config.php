<?php
class Config extends AppModel{
	public $name = 'Config';
	
	function saveCofigData($data)
	{
		foreach($data as $key=>$value)
		{
			if(isset($value) && $value != ''){ //if the value comes from the config variables
				$findDuplicate = $this->find('all', array('conditions'=>array('Config.name'=>$key)));
				if($findDuplicate && count($findDuplicate) > 0){
					$this->query("update `configs` set `value`='".$value."' where `name`='".$key."'");
				}else{
					$this->query("insert into `configs` set `name`='".$key."', `value`=".$value);
				}
			}	
		}
		return 1;
	}
	
	function retrieveAllData()
	{
		$getAll = $this->find('all');
		return $getAll;
	}
	
	function getDuplicateDaysCount()
	{
		$getCount = $this->find('all', array('conditions'=>array('Config.name'=>'duplicate_days')));
		if($getCount && count($getCount) > 0){
			return $getCount[0]['Config']['value'];
		}else{
			return 0;
		}	
	}
	
	function getDuplicateDaysCountAdv()
	{
		$getCount = $this->find('all', array('conditions'=>array('Config.name'=>'adv_duplicate_days')));
		if($getCount && count($getCount) > 0){
			return $getCount[0]['Config']['value'];
		}else{
			return 0;
		}	
	}
}