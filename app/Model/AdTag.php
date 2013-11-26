<?php
class AdTag extends AppModel {
    var $name = 'AdTag';
	
	public $belongsTo = array('Tag' =>
							  array('className' => 'Tag',
							   		 'foreignKey' => 'ad_id'
							   ),
						  	  'AdDetail' =>
							  array('className' => 'AdDetail',
							        'foreignKey'  => 'tag_id'
							   )
							 );
}
?>