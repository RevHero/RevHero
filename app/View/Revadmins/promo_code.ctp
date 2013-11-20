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
			{ "sWidth": '22%' },
			{ "sWidth": '9%' },
			{ "sWidth": '15%' },
			{ "sWidth": '15%' },
			{ "sWidth": '10%' },
			{ "sWidth": '10%' },
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
	if(confirm("Are you sure you want to enable this promo code?")){
		var strURL = $('#pageurl').val();
		$("#aprloader_"+adId).show();
		$("#appbtn_"+adId).hide();
		$.post(strURL+"revadmins/setEnableDisable",{env:'enable',promoId:adId},function(data){
			//alert(JSON.stringify(data, null, 4));
			$("#aprloader_"+adId).hide();
			$("#appbtn_"+adId).show();
			if(data.status == 1){
				$("#appbtn_"+adId).hide();
				$("#appbtndisable_"+adId).show();
				$("#rejbtn_"+adId).show();
				$("#rejbtndisable_"+adId).hide();
				$("#status_"+adId).html("Enabled");
			}
		},'json');
	}else{
		return false;
	}	
}

function rejectbtn(adId)
{
	if(confirm("Are you sure you want to disable this promo code?")){
		var strURL = $('#pageurl').val();
		$("#rejloader_"+adId).show();
		$("#rejbtn_"+adId).hide();
		$.post(strURL+"revadmins/setEnableDisable",{env:'disable',promoId:adId},function(data){
			//alert(JSON.stringify(data, null, 4));
			$("#rejloader_"+adId).hide();
			$("#rejbtn_"+adId).show();
			if(data.status == 0){
				$("#rejbtn_"+adId).hide();
				$("#rejbtndisable_"+adId).show();
				$("#appbtn_"+adId).show();
				$("#appbtndisable_"+adId).hide();
				$("#status_"+adId).html("Disabled");
			}
		},'json');
	}else{
		return false;
	}
}

function deletePromo(promoId)
{
	if(confirm("Are you sure you want to delete this promo code?")){
		$("#row_"+promoId).css('background-color', 'red').fadeOut(1500, function(){
			$("#row_"+promoId).remove();
		});
		var strURL = $('#pageurl').val();
		$.post(strURL+"revadmins/deletePromo",{promoId:promoId},function(data){
			if(data.status == 1){
				
			}
		},'json');
	}else{
		return false;
	}
	
	return false;
}

function editPromo(edit_id)
{
	document.location.href = "<?php echo HTTP_ROOT; ?>revadmins/edit_promo/"+edit_id;
}

function gotToDetails(promoId)
{
	document.location.href = "<?php echo HTTP_ROOT; ?>revadmins/promodetails/"+promoId;
}

</script>
<div class="span2"></div>
<div class="span4" style="margin-left:30px;margin-bottom:12px;">
	<a href="<?php echo HTTP_ROOT; ?>revadmins/add_promo">
		<button class="btn btn-primary" type="button">Create new Promo</button>
	</a>
</div>
<div class="span4" id="displayMsg"></div>
<div class="container">
	<div class="row">
        <table id="table_id" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" border="0" width="100%">
			<thead>
				<tr>
					<th>Promo Code</th>
					<th>Charge</th>
					<th>Valid From</th>
					<th>Valid To</th>
					<th>No. Users</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					//echo "<pre>";print_r($getAllPromo);exit;
					$count=0;
					foreach(@$getAllPromo as $ad){
					$count++;
					if($ad['PromoCode']['status'] == '' || $ad['PromoCode']['status'] == 0){
						$status = 'Disabled';
						$showapr = 'style="display:;"';
						$showrejdis = 'style="display:;"';
						$showrej = 'style="display:none;"';
						$showaprdis = 'style="display:none;"';
					}else if($ad['PromoCode']['status'] == 1){
						$status = 'Enabled';
						$showrej = 'style="display:;"';
						$showaprdis = 'style="display:;"';
						$showapr = 'style="display:none;"';
						$showrejdis = 'style="display:none;"';
					}
				?>
				<tr id="row_<?php echo $ad['PromoCode']['id']; ?>">
					<td>
						<?php if($ad['userCount'] > 0){ ?>
							<a onclick="gotToDetails('<?php echo $ad['PromoCode']['id']; ?>')" style="cursor:pointer">
								<span title="<?php echo $ad['PromoCode']['promocode']; ?>"><?php echo $ad['PromoCode']['promocode']; ?></span>
							</a>	
						<?php }else{ ?>
							<span title="<?php echo $ad['PromoCode']['promocode']; ?>"><?php echo $ad['PromoCode']['promocode']; ?></span>
						<?php } ?>
					</td>
					<td align="center">$ <?php echo number_format($ad['PromoCode']['price'],2);?></td>
					<td align="center"><?php echo date('M j, Y', strtotime($ad['PromoCode']['validFrom'])); ?></td>
					<td align="center"><?php echo date('M j, Y', strtotime($ad['PromoCode']['validTo'])); ?></td>
					<td align="center">
						<?php 
							if($ad['userCount'] > 0){
								echo $ad['userCount']; ?>
						<?php		
							}else{
								echo "0";
							}
						?>	
					</td>
					<td align="center" id="status_<?php echo $ad['PromoCode']['id']; ?>"><?php echo $status;?></td>
					<td align="center">
						<button class="btn btn-mini btn-inverse" type="button" id="appbtn_<?php echo $ad['PromoCode']['id']; ?>" onclick="approvebtn('<?php echo $ad['PromoCode']['id']; ?>')" <?php echo @$showapr; ?>>Enable</button>
						<button class="btn btn-mini btn-inverse disabled" type="button" id="appbtndisable_<?php echo $ad['PromoCode']['id']; ?>" <?php echo @$showaprdis; ?>>Enable</button>
						
						<span id="aprloader_<?php echo $ad['PromoCode']['id']; ?>" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /></span>
						
						<button class="btn btn-mini btn-inverse" type="button" id="rejbtn_<?php echo $ad['PromoCode']['id']; ?>" onclick="rejectbtn('<?php echo $ad['PromoCode']['id']; ?>')" <?php echo @$showrej; ?>>Disable</button>
						<button class="btn btn-mini disabled btn-inverse" type="button" id="rejbtndisable_<?php echo $ad['PromoCode']['id']; ?>"  <?php echo @$showrejdis; ?>>Disable</button>
						
						<span id="rejloader_<?php echo $ad['PromoCode']['id']; ?>" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /></span>
						<i class="icon-pencil" onclick="editPromo('<?php echo $ad['PromoCode']['id']; ?>');" style="cursor:pointer;"></i>
						<i class="icon-trash" onclick="deletePromo('<?php echo $ad['PromoCode']['id']; ?>');" style="cursor:pointer;"></i>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>