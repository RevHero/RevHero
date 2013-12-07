<script type="text/javascript" src="<?php echo JS_PATH.'jquery.dataTables.js';?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.dataTables.bootstrap.js';?>"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH.'jquery.dataTables.css';?>" />
<link rel="stylesheet" href="<?php echo CSS_PATH.'jquery.dataTables.bootstrap.css';?>" />
<script language="javascript" type="text/javascript">
$(document).ready( function () {
	$('#table_id').dataTable({
	"aLengthMenu": [[10, 50, 100], [10,50, 100]],
	"iDisplayLength": 10,
	"iDisplayStart" : 0,
	"aaSorting": [[ 2, "desc" ]],
    "sPaginationType": "full_numbers",
	"aoColumns": [ 
			{ "sWidth": '25%' },
			{ "sWidth": '27%' },
			{ "sWidth": '15%' },
			{ "sWidth": '8%' },
			{ "sWidth": '5%' },
			{ "sWidth": '20%', "bSortable": false }
		    ]
	});
});

function closeBox()
{
	$("#displayMsg").hide();
}

function approvebtn(adId)
{
	if(confirm("Are you sure you want to approve this ad?")){
		var strURL = $('#pageurl').val();
		$("#aprloader_"+adId).show();
		$("#appbtn_"+adId).hide();
		$.post(strURL+"revadmins/setApproveReject",{env:'approve',advertiseId:adId},function(data){
			//alert(JSON.stringify(data, null, 4));
			$("#aprloader_"+adId).hide();
			$("#appbtn_"+adId).show();
			if(data.status == 1){
				$("#appbtn_"+adId).hide();
				$("#appbtndisable_"+adId).show();
				$("#rejbtn_"+adId).show();
				$("#rejbtndisable_"+adId).hide();
				$("#status_"+adId).html("Approved");
			}
		},'json');
	}else{
		return false;
	}	
}

function rejectbtn(adId)
{
	if(confirm("Are you sure you want to reject this ad?")){
		var strURL = $('#pageurl').val();
		$("#rejloader_"+adId).show();
		$("#rejbtn_"+adId).hide();
		$.post(strURL+"revadmins/setApproveReject",{env:'reject',advertiseId:adId},function(data){
			//alert(JSON.stringify(data, null, 4));
			$("#rejloader_"+adId).hide();
			$("#rejbtn_"+adId).show();
			if(data.status == 2){
				$("#rejbtn_"+adId).hide();
				$("#rejbtndisable_"+adId).show();
				$("#appbtn_"+adId).show();
				$("#appbtndisable_"+adId).hide();
				$("#status_"+adId).html("Rejected");
			}
		},'json');
	}else{
		return false;
	}
}

</script>
<div class="container">
	<div class="row">
        <table id="table_id" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" border="0" width="100%">
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
					if($ad['AdDetail']['status'] == '' || $ad['AdDetail']['status'] == 0){
						$status = 'Pending';
						$showapr = 'style="display:;"';
						$showrejdis = 'style="display:;"';
						$showrej = 'style="display:none;"';
						$showaprdis = 'style="display:none;"';
					}else if($ad['AdDetail']['status'] == 1){
						$status = 'Approved';
						$showrej = 'style="display:;"';
						$showaprdis = 'style="display:;"';
						$showapr = 'style="display:none;"';
						$showrejdis = 'style="display:none;"';
					}else if($ad['AdDetail']['status'] == 2){
						$status = 'Rejected';
						$showapr = 'style="display:;"';
						$showrejdis = 'style="display:;"';
						$showrej = 'style="display:none;"';
						$showaprdis = 'style="display:none;"';
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
							<?php /*?><a href="<?php echo HTTP_ROOT; ?>ads/details/<?php echo $ad['AdDetail']['id'];?>"><?php */?>
								<?php
									if(strlen($ad['AdDetail']['headline']) > 35){
										echo substr($ad['AdDetail']['headline'],0,35)."...";
									}else{
										echo $ad['AdDetail']['headline'];
									}
								?>
							<?php /*?></a><?php */?>
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
					<td align="center"><?php echo date('M j, Y', strtotime($ad['AdDetail']['created'])); ?></td>
					<td align="center" id="status_<?php echo $ad['AdDetail']['id']; ?>"><?php echo $status;?></td>
					<td align="center"><?php echo $active;?></td>
					<td align="center">
						<button class="btn btn-mini btn-inverse" type="button" id="appbtn_<?php echo $ad['AdDetail']['id']; ?>" onclick="approvebtn('<?php echo $ad['AdDetail']['id']; ?>')" <?php echo @$showapr; ?>>Approve</button>
						<button class="btn btn-mini btn-inverse disabled" type="button" id="appbtndisable_<?php echo $ad['AdDetail']['id']; ?>" <?php echo @$showaprdis; ?>>Approve</button>
						
						<span id="aprloader_<?php echo $ad['AdDetail']['id']; ?>" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /></span>
						
						<button class="btn btn-mini btn-inverse" type="button" id="rejbtn_<?php echo $ad['AdDetail']['id']; ?>" onclick="rejectbtn('<?php echo $ad['AdDetail']['id']; ?>')" <?php echo @$showrej; ?>>Reject</button>
						<button class="btn btn-mini disabled btn-inverse" type="button" id="rejbtndisable_<?php echo $ad['AdDetail']['id']; ?>"  <?php echo @$showrejdis; ?>>Reject</button>
						
						<span id="rejloader_<?php echo $ad['AdDetail']['id']; ?>" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /></span>
					<!--<i class="icon-pencil"></i>--> <i class="icon-trash"></i></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>