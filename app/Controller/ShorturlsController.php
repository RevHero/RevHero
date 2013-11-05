<?php
class ShorturlsController extends AppController {
    public $name = 'Shorturls';
	
	function route_url()
	{
		$this->loadModel('Placement');
		
		$saveAdClickandGetDestinationUrl = $this->Placement->getDestURL($this->params['slug']);
		
		$explode = explode("####", $saveAdClickandGetDestinationUrl);
		
		$returnsuccess = $explode[0];
		$destinationUrl = $explode[1];

		if($returnsuccess){
			$this->redirect($destinationUrl);
		}	
	}
}
