<?php
class AdsController extends AppController {
    public $name = 'Ads';
	
	function advertise()
	{
		$this->layout = 'default';
		if(!$this->Session->read('Auth.User.id')){
			$this->redirect(HTTP_ROOT);
		}
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
				$saveTagDetails = $this->Tag->saveTags($adDetailsId, $this->request['data']['Ad']['alltags']);
				if($saveTagDetails == 1){
					$this->Session->write("SAVEADDSUCCESS","1"); //Holds the session to display the successfully ad creation message
					$this->redirect(HTTP_ROOT);
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
					$json_arr['title'] = substr($title[1],0,35);
				}else{
					$json_arr['status'] = 1;
					$json_arr['title'] = $title[1];
				}
			}
		}else{
			$json_arr['status'] = 0;
		}	
		echo json_encode($json_arr);exit;
	}
	
}
