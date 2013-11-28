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
}
?>