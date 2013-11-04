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
			
			$headline    = $this->request['data']['Ad']['headline'];
			$destination = $this->request['data']['Ad']['dest_url'];
			$bodytext    = $this->request['data']['Ad']['bodytext'];
			$alltags     = $this->request['data']['Ad']['alltags'];
			
			$saveAdDetails = $this->AdDetail->saveDetails($this->Auth->user('id'), $this->request['data']['Ad']);
			
			if($saveAdDetails && $saveAdDetails > 0)
			{
				$adDetailsId = $saveAdDetails;
				$photo_name = $this->Format->uploadPhoto($this->request['data']['Ad']['uploadimage']['tmp_name'],$this->request['data']['Ad']['uploadimage']['name'],$this->request['data']['Ad']['uploadimage']['size'],DIR_AD_PHOTOS,SES_ID,"ad_img");
				
				$this->loadModel('AdDetail');
				$adImage['AdDetail']['id'] = $adDetailsId;
				$adImage['AdDetail']['ad_image'] = $photo_name;
				$saveImageName = $this->AdDetail->save($adImage);
				
				$saveTagDetails = $this->Tag->saveTags($adDetailsId, $this->request['data']['Ad']['alltags']);
				if($saveTagDetails == 1){
					$this->Session->write("SAVEADDSUCCESS","1"); //Holds the session to display the successfully ad creation message
					$this->redirect(HTTP_ROOT."ads/lists");
				}else{
					$this->Session->write("SAVEADDSUCCESS","0"); //Holds the session to display the error ad creation message
					$this->redirect(HTTP_ROOT);
				}
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
					$json_arr['fulltitle'] = $title[1];
					$json_arr['title'] = substr($title[1],0,35);
				}else{
					$json_arr['status'] = 1;
					$json_arr['fulltitle'] = $title[1];
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
		
		$conditions = array('AdDetail.is_active'=>1, 'AdDetail.status'=>1);
		$this->paginate = array(
			'conditions' => $conditions,
			'order' => array('AdDetail.created'=>'DESC'),
			'limit' => 6
		);
		$allAdStore = $this->paginate('AdDetail');
		$this->set('allAdStore', $allAdStore);
	}
	
	function details($adid=NULL,$sessionId=NULL)
	{
		$this->layout = 'default';
		$this->loadModel('AdDetail');
		$this->loadModel('User');
		$getDetails = $this->AdDetail->getAdDetails($adid,$sessionId);
		$this->set('getDetails', $getDetails);
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
		$this->layout = 'ajax';
		$this->loadModel('Placement');
		$savePlacementDetails = $this->Placement->savePlacementDetails($this->data);
		
		if($savePlacementDetails){
			$json_arr['status'] = 1;
			$json_arr['customKeyword'] = $savePlacementDetails;
		}else{
			$json_arr['status'] = 0;
		}
		echo json_encode($json_arr);exit;
	}
}
