<?php
class AdTag extends AppModel {
    var $name = 'AdTag';
	
	public $belongsTo = array('Tag' =>
							  array('className' => 'Tag',
							   		 'foreignKey' => 'tag_id'
							   ),
						  	  'AdDetail' =>
							  array('className'   => 'AdDetail',
							        'foreignKey'  => 'ad_id',
									'conditions'  => array('AdDetail.status'=>1)
							   )
							 );
}
?>