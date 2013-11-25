<?php
class Config extends AppModel{
	public $name = 'Config';
	
	function saveCofigData($data)
	{
		//pr($data);
		
		foreach($data as $key=>$value)
		{
			$findDuplicate = $this->find('all', array('conditions'=>array('Config.name'=>$key)));
			
			//pr($findDuplicate);
			
			if($findDuplicate && count($findDuplicate) > 0){
				$this->query("update `configs` set `value`='".$value."' where `name`='".$key."'");
			}else{
				$this->query("insert into `configs` set `name`='".$key."', `value`=".$value);
			}
		}
		//exit;

		return 1;
	}
	
	function retrieveAllData()
	{
		$getAll = $this->find('all');
		//pr($getAll);exit;
		return $getAll;
	}
	
	function getDuplicateDaysCount()
	{
		$getCount = $this->find('all', array('conditions'=>array('Config.name'=>'duplicate_days')));
		return $getCount[0]['Config']['value'];
	}
	
	function getDuplicateDaysCountAdv()
	{
		$getCount = $this->find('all', array('conditions'=>array('Config.name'=>'adv_duplicate_days')));
		return $getCount[0]['Config']['value'];
	}
}