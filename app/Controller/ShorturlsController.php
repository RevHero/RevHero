<?php
class ShorturlsController extends AppController {
    public $name = 'Shorturls';
	
	function route_url()
	{
		$this->loadModel('AdDetail');
		$this->loadModel('Placement');
		
		$DestUrl = $this->Placement->find('all',array('conditions'=>array('keyword'=>$this->params['slug'])));
		//echo "<pre>";print_r($DestUrl);exit;
		$destinationUrl = $DestUrl[0]['AdDetail']['dest_url'];
		
		$this->redirect($destinationUrl);
		
		/*if(isset($this->params['slug'])){
			echo $this->params['slug'];exit;
		}
		echo "sandeep";exit;*/
	}
}
