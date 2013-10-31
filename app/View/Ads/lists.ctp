<script type="text/javascript" src="<?php echo JS_PATH.'jquery.dataTables.js';?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.dataTables.bootstrap.js';?>"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH.'jquery.dataTables.css';?>" />
<link rel="stylesheet" href="<?php echo CSS_PATH.'jquery.dataTables.bootstrap.css';?>" />

<script type='text/javascript'>
$(document).ready( function () {
	$('#table_id').dataTable({
	"aLengthMenu": [[10, 50, 100], [10,50, 100]],
	"iDisplayLength": 10,
	"iDisplayStart" : 0,
	"aaSorting": [[ 0, "asc" ]],
    "sPaginationType": "full_numbers",
	"aoColumns": [ 
			null,
			null,
			null,
			null,
			null,
			{ "bSortable": false }
		    ]
	});
});

function closeBox()
{
	$("#displayMsg").hide();
}

</script>
<div class="span2"></div>
<div class="span4" style="margin-left:30px;margin-bottom:12px;"><a href="<?php echo HTTP_ROOT; ?>ads/add"><button class="btn btn-primary" type="button">Create new Ad</button></a></div>
<div class="span4" id="displayMsg">
<?php if(@$successaddsave && @$successaddsave == 1){ ?>
  <div class="alert alert-success">
	<a class="close" onclick="closeBox();">x</a>
	<strong>Thank You.</strong> You have created advertise successfully.
  </div>
<?php }else if(@$successaddsave == 0 && @$successaddsave != ''){ ?>  
  <div class="alert alert-error">
	<a class="close" onclick="closeBox();">x</a>
	<strong>Sorry!!</strong> Advertise did not save.
  </div>
<?php } ?>  
</div>
<div class="container">
<div class="row">
<table id="table_id" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" border="0">
    <thead>
        <tr>
            <th>Headline Text</th>
            <th>Tags</th>
			<th>Created date</th>
			<th>Approval Status</th>
			<th>Active</th>
			<th>Action</th>
        </tr>
    </thead>
    <tbody>
		<?php
			//echo "<pre>";print_r($AllAdDetails);exit;
			$count=0;
			foreach($AllAdDetails as $ad){
			$count++;
			if($ad['AdDetail']['staus'] == '' || $ad['AdDetail']['staus'] == 0){
				$status = 'Pending';
			}else if($ad['AdDetail']['staus'] == 1){
				$status = 'Approved';
			}else if($ad['AdDetail']['staus'] == 2){
				$status = 'Rejected';
			}
			
			if($ad['AdDetail']['is_active'] == '' || $ad['AdDetail']['is_active'] == 0){
				$active = 'No';
			}else if($ad['AdDetail']['is_active'] == 1){
				$active = 'Yes';
			}
		?>
        <tr>
            <td>
				<span title="<?php echo $ad['AdDetail']['headline'];?>">
					<?php
						if(strlen($ad['AdDetail']['headline']) > 35){
							echo substr($ad['AdDetail']['headline'],0,35)."...";
						}else{
							echo $ad['AdDetail']['headline'];
						}
					?>
				</span>
			</td>
			<td>
				<?php
					$allTags = '';
					foreach($ad['Tag'] as $tag)
					{
						$allTags .= '<span class="tag label label-info">'.$tag['tag_name']."</span> ";
					}
					echo $allTags;
				?>
			</td>
			<td align="center"><?php echo $ad['AdDetail']['created'];?></td>
			<td align="center"><?php echo $status;?></td>
			<td align="center"><?php echo $active;?></td>
			<td align="center"><i class="icon-pencil"></i> <i class="icon-trash"></i></td>
        </tr>
		<?php } ?>
    </tbody>
</table>
</div>
</div>