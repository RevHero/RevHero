<?php
class AdsController extends AppController {
    public $name = 'Ads';
	
	function lists()
	{
		$this->layout = 'default';
		if(!$this->Session->read('Auth.User.id')){
			$this->redirect(HTTP_ROOT);
		}
		$this->loadModel('AdDetail');
		$AllAdDetails = $this->AdDetail->getAllAds(SES_ID);
		//echo "<pre>";print_r($AllAdDetails);exit;
		$this->set('AllAdDetails', $AllAdDetails);
	}
	
	function add()
	{
		if(isset($this->request['data']['Ad']) && $this->request['data']['Ad'])
		{
			$this->loadModel('AdDetail');
			$this->loadModel('Tag');
			if($this->Auth->user('id')){
				$saveAdDetails = $this->AdDetail->saveDetails($this->Auth->user('id'), $this->request['data']['Ad']);
			}else{
				$saveAdDetails = $this->AdDetail->saveDetails(0, $this->request['data']['Ad']);
			}
			
			if($saveAdDetails && $saveAdDetails > 0)
			{
				$adDetailsId = $saveAdDetails;
				if($this->Auth->user('id')){
					$photo_name = $this->Format->uploadPhoto($this->request['data']['Ad']['uploadimage']['tmp_name'],$this->request['data']['Ad']['uploadimage']['name'],$this->request['data']['Ad']['uploadimage']['size'],DIR_AD_PHOTOS,SES_ID,"ad_img");
				}else{
					$photo_name = $this->Format->uploadPhoto($this->request['data']['Ad']['uploadimage']['tmp_name'],$this->request['data']['Ad']['uploadimage']['name'],$this->request['data']['Ad']['uploadimage']['size'],DIR_AD_PHOTOS,0,"ad_img");
				}
				$this->loadModel('AdDetail');
				$adImage['AdDetail']['id'] = $adDetailsId;
				$adImage['AdDetail']['ad_image'] = $photo_name;
				$saveImageName = $this->AdDetail->save($adImage);
				
				$saveTagDetails = $this->Tag->saveTags($adDetailsId, $this->request['data']['Ad']['alltags']);//We are also saving the blank TAGS to the database.
				if($saveTagDetails == 1){
					if($this->Auth->user('id')){
						$this->Session->write("SAVEADDSUCCESS","1"); //Holds the session to display the successfully ad creation message
						$this->redirect(HTTP_ROOT."ads/lists");
					}else{
						//$this->Session->setFlash('Ad is created successfully.', 'default', array(), 'S'); 
						$id_arr = array();
						$lastkey = 0;
						if($this->Cookie->read('advertised')){
							$cookiearr = $this->Cookie->read('advertised');
							foreach($cookiearr as $k=>$v){
								$id_arr[$k] = $v;
								$lastkey = $k;
							}
							$id_arr[++$lastkey] = $adDetailsId;
							$this->Cookie->write('advertised',$id_arr,'/',strtotime('+30 days'));
						}else{
							$id_arr[$lastkey] = $adDetailsId;
							$this->Cookie->write('advertised',$id_arr,'/',strtotime('+30 days'));
						}
						
						$this->Session->write("VISITORAD",$adDetailsId);
						$this->redirect(HTTP_ROOT);
					}
				}else{
					$this->Session->write("SAVEADDSUCCESS","0"); //Holds the session to display the error ad creation message
					$this->redirect(HTTP_ROOT);
				}
			}
		}	
	}
	
	function edit($editId = NULL)
	{
		$this->layout = 'default';
		$this->loadModel('AdDetail');
		$this->loadModel('Tag');
		
		//echo "<pre>";print_r($this->request['data']);exit;
		if(isset($this->request['data']['Ad']) && $this->request['data']['Ad'])
		{
			//Checking whether the user edits anything or not and uploaded any image or not
			if($this->request['data']['Ad']['dest_url'] == $this->request['data']['hid_dest_url'] && 
			   $this->request['data']['Ad']['headline'] == $this->request['data']['hid_headline'] &&
			   $this->request['data']['Ad']['bodytext'] == $this->request['data']['hid_body'] &&
			   $this->request['data']['Ad']['cpc'] == $this->request['data']['hid_CPC'] &&
			   $this->request['data']['Ad']['cpa'] == $this->request['data']['hid_CPA'] &&
			   $this->request['data']['Ad']['alltags'] == $this->request['data']['hid_alltags'] &&
			   $this->request['data']['Ad']['uploadimage']['name'] == '')
			{   
			   $this->Session->write("SAVEADDSUCCESS","2"); //Holds the session to display the error msg that nothing is edited
			   $this->redirect(HTTP_ROOT."ads/lists");
			}
			else
			{
				$saveAdDetails = $this->AdDetail->saveDetails($this->Auth->user('id'), $this->request['data']['Ad']);
				if($saveAdDetails && $saveAdDetails > 0)
				{
					$adDetailsId = $saveAdDetails;
					if($this->request['data']['Ad']['uploadimage']['tmp_name'] && $this->request['data']['Ad']['uploadimage']['name'])
					{
						$photo_name = $this->Format->uploadPhoto($this->request['data']['Ad']['uploadimage']['tmp_name'],$this->request['data']['Ad']['uploadimage']['name'],$this->request['data']['Ad']['uploadimage']['size'],DIR_AD_PHOTOS,SES_ID,"ad_img");
						$adImage['AdDetail']['id'] = $adDetailsId;
						$adImage['AdDetail']['ad_image'] = $photo_name;
						$saveImageName = $this->AdDetail->save($adImage);
					}
					else if(!$this->request['data']['Ad']['uploadimage']['tmp_name'] && !$this->request['data']['Ad']['uploadimage']['name'] && $this->request['data']['hid_image'])
					{
						$copyImage = $this->request['data']['hid_image'];
						$oldname = strtolower($this->request['data']['hid_image']);
						$ext = substr(strrchr($oldname, "."), 1);
						$newname = md5(time().SES_ID).".".$ext;
						copy(DIR_AD_PHOTOS.$copyImage, DIR_AD_PHOTOS.$newname);
						
						$adImage['AdDetail']['id'] = $adDetailsId;
						$adImage['AdDetail']['ad_image'] = $newname;
						$saveImageName = $this->AdDetail->save($adImage);
						
						//$targetpath = $path.$newname;
						//move_uploaded_file($tmp_name, $targetpath);
					}
					//echo $this->request['data']['Ad']['alltags']."#######".$this->request['data']['hid_alltags'];
					
					//if($this->request['data']['Ad']['alltags'] != $this->request['data']['hid_alltags'])
					//{
						$saveTagDetails = $this->Tag->saveTags($adDetailsId, $this->request['data']['Ad']['alltags']);
					//}
					
					$this->Session->write("SAVEADDSUCCESS","1"); //Holds the session to display the successfully ad creation message
					$this->redirect(HTTP_ROOT."ads/lists");
				}
				else
				{
					$this->Session->write("SAVEADDSUCCESS","0"); //Holds the session to display the error ad creation message
					$this->redirect(HTTP_ROOT);
				}
			}
		}
		else
		{
			$getEditDetails = $this->AdDetail->getAdDetails($editId);
			if($getEditDetails && count($getEditDetails) >0)
			{
				$this->set('getEditDetails', $getEditDetails);
			}
			else
			{
				//if the user is manually giving a ad id which is not present in the database, will be redirected to the ad lists page.
				$this->redirect(HTTP_ROOT."ads/lists");
			}
		}
	}
	function getTag()
	{
		$this->layout = 'ajax';
		
		$this->loadModel('Tag');
		$getAll = $this->Tag->getAllTags();

		print $getAll;
		exit;
	}
	
	function getTitleFromUrl()
	{
		$this->layout = 'ajax';
		$DestURL = $this->data['url'];
		$str = @file_get_contents($DestURL);
		
		if($str){
			if(strlen($str)>0){
				preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
				if(strlen($title[1]) > 35){
					$json_arr['status'] = 1;
					//$json_arr['fulltitle'] = $title[1];
					$json_arr['title'] = substr($title[1],0,35);
				}else{
					$json_arr['status'] = 1;
					//$json_arr['fulltitle'] = $title[1];
					$json_arr['title'] = $title[1];
				}
			}
		}else{
			$json_arr['status'] = 0;
		}	
		echo json_encode($json_arr);exit;
	}
	
	function store()
	{
		$this->layout = 'default';
		$this->loadModel('AdDetail');
		$this->loadModel('Tag');
		
		$alltags = $this->Tag->find('all', array('conditions'=>array('Tag.tag_name !=' => ''), 'limit' => 10));
		
		//echo "<pre>";print_r($alltags);exit;
		
		$this->Session->write('alltags', $alltags); //This is require to show the tags in the tagdetails page.
		$this->set('alltags', $alltags);
		
		$conditions = array('AdDetail.is_active'=>1, 'AdDetail.status'=>1);
		$this->paginate = array(
			'conditions' => $conditions,
			'order' => array('AdDetail.created'=>'DESC'),
			'limit' => 10
		);
		$allAdStore = $this->paginate('AdDetail');
		$this->set('allAdStore', $allAdStore);
		
		$getallActiveAdsforUser = $this->AdDetail->getAllAds($this->Auth->user('id'));
		$this->set('countgetallActivedAds', count($getallActiveAdsforUser));
		
	}
	
	function details($adid=NULL)
	{
		if(isset($adid) && $adid != '')
		{
			$this->layout = 'default';
			$this->loadModel('AdDetail');
			$this->loadModel('User');
			$getDetails = $this->AdDetail->getAdDetails($adid);
			if($getDetails && count($getDetails) >0){
				$this->set('anonymousads', array($getDetails));
				$this->set('detailpg', 1);
			}else{
				$this->redirect(HTTP_ROOT."ads/lists");
			}	
		}
		else
		{
			$this->redirect(HTTP_ROOT."ads/lists");
		}	
	}
	
	function getUniqueKeyword()
	{
		$this->layout = 'ajax';
		$customKeyword = $this->data['customKeyword'];
		$this->loadModel('Placement');
		$getUnqKeyword = $this->Placement->getKeywordUnique($customKeyword);

		if($getUnqKeyword == 0){
			$json_arr['status'] = 0;
		}else if($getUnqKeyword == 1){
			$json_arr['status'] = 1;
		}
		echo json_encode($json_arr);exit;
	}
	
	function savePlacements()
	{
		if(!isset($this->data['pub_submit'])){
			$this->layout = 'ajax';
		}
		$this->loadModel('Placement');
		
		$savePlacementDetails = $this->Placement->savePlacementDetails($this->data);
		
		
		if(!isset($this->data['pub_submit'])){
			if($savePlacementDetails){
				$json_arr['status'] = 1;
				$json_arr['customKeyword'] = $savePlacementDetails[1];
				$json_arr['placementId'] = $savePlacementDetails[0];
			}else{
				$json_arr['status'] = 0;
			}
			echo json_encode($json_arr);exit;
		}else{
			$id_arr = array();
			$lastkey = 0;
			if(isset($_COOKIE['publish_placement']) && !empty($_COOKIE['publish_placement'])){
				$cookiearr = explode(",",$_COOKIE['publish_placement']);
				foreach($cookiearr as $k=>$v){
					$id_arr[$k] = $v;
					$lastkey = $k;
				}
				$id_arr[++$lastkey] = $savePlacementDetails[0];
				setcookie('publish_placement',implode(",",$id_arr),strtotime('+30 days'),'/');
			}else{
				$id_arr[$lastkey] = $savePlacementDetails[0];
				setcookie('publish_placement',implode(",",$id_arr),strtotime('+30 days'),'/');
			}
			
			$this->Session->write("VISITORPLACEMENT",$savePlacementDetails[0]);
			$this->redirect(HTTP_ROOT);
		}	
	}
	
	function tagdetails($tagname=NULL)
	{
		$this->layout = 'default';
		$this->loadModel('AdTag');
		$this->loadModel('Tag');
		$this->loadModel('AdDetail');
		
		if(isset($tagname) && $tagname != '')
		{
			$conditions = array('Tag.is_active'=>1, 'Tag.tag_name'=>$tagname, 'AdDetail.status'=>1);
			$this->paginate = array(
				'conditions' => $conditions,
				'limit' => 10
			);
			$allrequiretagdetails = $this->paginate('AdTag');
			
			$alltags = $this->Session->read('alltags');
			
			//echo "<pre>";print_r($allrequiretagdetails);exit;
			
			$this->set('alltags', $alltags);
			$this->set('allrequiretagdetails', $allrequiretagdetails);
			$this->set('tagname', $tagname);
			
			//echo $tagname;exit;
		}
		else
		{
			$this->redirect(HTTP_ROOT."ads/store");
		}	
	}
	
	function anonymousads(){
		if($this->Cookie->read('advertised')){
			$this->loadModel('AdDetail');
			$getDetails = $this->AdDetail->find('all',array('conditions'=>array('AdDetail.id'=>($this->Cookie->read('advertised')))));
			$this->set('anonymousads',$getDetails);
		}else{
			$this->redirect(HTTP_ROOT);
		}
	}
	
	function anonymousplacements()
	{
		if(isset($_COOKIE['publish_placement']) && $_COOKIE['publish_placement'] != ''){
			$this->loadModel('Placement');
			$arrPlacements = explode(",",$_COOKIE['publish_placement']);
			$getDetails = $this->Placement->find('all',array('conditions'=>array('Placement.id'=>($arrPlacements))));
			$this->set('getallplacements',$getDetails);
		}else{
			$this->redirect(HTTP_ROOT);
		}
	}
	function linkad(){
		if(isset($this->data['linked'])){
			$this->loadModel('AdDetail');
			foreach($this->data['cpc'] as $k => $v){
				$this->AdDetail->query("UPDATE ad_details set cpc = ".$v.",cpa= ".$this->data['cpa'][$k].",advertiser_id=".SES_ID." WHERE id = ".$k);
			}
		}
		unset($_COOKIE['advertised']);
		$this->Cookie->write('advertised','','/',time()-10000);
		$this->redirect(HTTP_ROOT);
	}
	
	function linkplacement(){
		if(isset($this->data['linked'])){
			$this->loadModel('Placement');
			$placementids = implode(',',$this->data['hid_placement_id']);
			$this->Placement->query("UPDATE placements set publisher_id=".SES_ID." WHERE id IN (".$placementids.")");
		}
		unset($_COOKIE['publish_placement']);
		setcookie('publish_placement','',time()-10000,'/');
		$this->redirect(HTTP_ROOT);
	}
}
