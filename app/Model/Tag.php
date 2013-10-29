<?php
class Tag extends AppModel{
	public $name = 'Tag';
	
	function getAllTags()
	{
		App::import('Model','Tag');
		$tagdetails = new Tag(); 
		
		$getTag = $tagdetails->find('all'); //The query requires for getting all the tags
		foreach($getTag as $value)
		{
			$tags[] = $value['Tag']['tag_name'];
		}
		return json_encode($tags);
	}
	function saveTags($adDetailsId, $alltags)
	{
		App::import('Model','Tag');
		$TagDetail = new Tag(); 
		App::import('Model','AdTag');
		$AdTagDetail = new AdTag(); 
		
		$explodeTags = explode(",", $alltags);
		foreach($explodeTags as $value)
		{
			$success = 0;
			$getTag = $TagDetail->find('first',array('fields'=>array('id'),'conditions'=>array('tag_name'=>$value))); //The query requires for checking from dtabase whether TAG is present or not
			if(empty($getTag)){ //If TAG is not present then save the TAG in both tags and ad_tags table
				$tag['Tag']['tag_name'] = $value;
				$tag['Tag']['is_active'] = 1;
				
				$saveTag = $TagDetail->saveAll($tag);
				if($saveTag)
				{
					$saveTagID = $TagDetail->getLastInsertID();
					$ad_tag['AdTag']['ad_id'] = $adDetailsId;
					$ad_tag['AdTag']['tag_id'] = $saveTagID;
					
					$saveAdTag = $AdTagDetail->saveAll($ad_tag);
					$success = 1;
				}
			}else{ //If TAG is present then save the TAG in only ad_tags table but donot save in tags table
				$saveTagID = $getTag['Tag']['id'];
				$ad_tag['AdTag']['ad_id'] = $adDetailsId;
				$ad_tag['AdTag']['tag_id'] = $saveTagID;
				
				$saveAdTag = $AdTagDetail->saveAll($ad_tag);
				$success = 1;
			}
		}
		if($success == 1)
			return 1;
		else
			return 0;	
	}
}