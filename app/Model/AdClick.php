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
	
	function getChartResult($placementId, $status)
	{
		//$getclickdetails = $this->query('SELECT count(id) as clickCount, `placement_id`, created FROM `ad_clicks` where `placement_id`=16 group by DATE_FORMAT(`created`, "%Y-%m-%d") ');
		if($status == 0)
		{
			$clickdetails = $this->find('all', array('fields'=>array('COUNT(`AdClick`.`id`) as clickCount', 'AdClick.placement_id', 'AdClick.created'),'conditions'=>array('AdClick.placement_id'=>$placementId, 'AdClick.is_duplicate'=>0), 'order' => '`AdClick`.`created` DESC', 'group' => 'DATE_FORMAT(`AdClick`.`created`,"%Y-%m-%d")', 'limit'=>'7'));
		}
		else
		{
			$clickdetails = $this->find('all', array('fields'=>array('COUNT(`AdClick`.`id`) as clickCount', 'AdClick.placement_id', 'AdClick.created'),'conditions'=>array('AdClick.placement_id'=>$placementId), 'order' => '`AdClick`.`created` DESC', 'group' => 'DATE_FORMAT(`AdClick`.`created`,"%Y-%m-%d")', 'limit'=>'7'));
		}	
		return $clickdetails;
	}
	
}
?>