<?php
class ShorturlsController extends AppController {
    public $name = 'Shorturls';
	
	function route_url()
	{
		$this->loadModel('Placement');
		$checkKeywordExists = $this->Placement->isKeywordExists($this->params['slug']);
		if(isset($checkKeywordExists) && $checkKeywordExists == 1){
		
			$saveAdClickandGetDestinationUrl = $this->Placement->getDestURL($this->params['slug']);
			
			$explode = explode("####", $saveAdClickandGetDestinationUrl);
			
			$returnsuccess = $explode[0];
			$destinationUrl = $explode[1];
	
			if($returnsuccess){
				$this->redirect($destinationUrl);
			}else{
				$this->redirect(HTTP_ROOT);
			}
		}else{
		
			if($this->Auth->user('admin') && $this->Auth->user('admin') == 1)
			{
				$this->redirect(HTTP_ROOT."revadmins/admin_dashboard");
			}
			else
			{
				$this->redirect(HTTP_ROOT);
			}
		}	
	}
}
