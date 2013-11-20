<?php
class AdClick extends AppModel {
    var $name = 'AdClick';
	
	var $belongsTo = array(
		'Placement' => array(
			'className' => 'Placement',
			'foreignKey' => 'placement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function getChartResult($placementId)
	{
		//$getclickdetails = $this->query('SELECT count(id) as clickCount, `placement_id`, created FROM `ad_clicks` where `placement_id`=16 group by DATE_FORMAT(`created`, "%Y-%m-%d") ');
		$clickdetails = $this->find('all', array('fields'=>array('COUNT(`AdClick`.`id`) as clickCount', 'AdClick.placement_id', 'AdClick.created'),'conditions'=>array('AdClick.placement_id'=>$placementId), 'group' => 'DATE_FORMAT(`AdClick`.`created`,"%Y-%m-%d")'));
		//echo "<pre>";print_r($clickdetails);exit;
		return $clickdetails;
	}
	
}
?>