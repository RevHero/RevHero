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
			{ "sWidth": '10%' },
			{ "sWidth": '16%' },
			{ "sWidth": '8%' },
			{ "sWidth": '8%' },
			{ "sWidth": '13%' },
			{ "sWidth": '25%' },
		    ]
	});
});

function showBtn(userId)
{
	$(".allBtn").hide();
	$("#saveBtn_"+userId).show();
}

function saveRevenue(userId)
{
	var strURL = $('#pageurl').val();
	var share = $("#revenue_"+userId).val();
	var hid_share = $("#hid_revenue_"+userId).val();
	//var regx = /^[0-9.]$/;
	var regx = /^[.0-9]+$/i;
	
	if(share) //If the Admin provided the share percentage number
	{
		if(share != hid_share) //If the new number same as the old number, then no call will happen for saving
		{
			if(regx.test(share)){ //Validating only number using the regular expression 
			  $("#saveBtn_"+userId).hide();
			  $("#mainloader_"+userId).show();
			  
			  $.post(strURL+"revadmins/saveRevenuePercentage",{strURL:strURL,share:share,userId:userId},function(data){
				//alert(JSON.stringify(data, null, 4));
				$("#mainloader_"+userId).hide();
				if(data.status == 1)
				{
					$("#hid_revenue_"+userId).val(share); //Assign the percentage value to the hidden variable for future checking reference
				}	
			  },'json');
			}else{
			  alert('Please enter only numbers.');
			  return false;
			}
		}
	}
	else
	{
		alert('Please enter revenue share.');
		return false;
	}	
}
</script>
<div class="span2"></div>
<div class="span4" id="displayMsg"></div>
<div class="container">
	<div class="row">
        <table id="table_id" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" border="0" width="100%">
			<thead>
				<tr>
					<th>Email</th>
					<th>Profile Image</th>
					<th>Used Promo Code</th>
					<th>Ad Created</th>
					<th>Ad Published</th>
					<th>Signed Up</th>
					<th>Revenue Share</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach(@$UserDetailsWithPromoCode as $key=>$user){
					$ProfileImage = '';
					
					if(isset($user['profile_image']) && $user['profile_image'] != '' && file_exists(DIR_PROFILE_IMAGES.$user['profile_image']))
					{
						$ProfileImage = '<img class="img-rounded img-polaroid" src="'.HTTP_FILES."profile_images/".$user['profile_image'].'" style="width:50px;height:50px;">';
					}else{
						$ProfileImage = '<img class="img-rounded img-polaroid" src="'.HTTP_IMAGES."no_user.png".'" style="width:50px;height:50px;">';
					}
					
				?>
					<tr id="row_<?php echo $user['user_id']; ?>">
						<td align="center"><?php echo $user['email']; ?></td>
						<td align="center"><?php if($user['email'] != 'Anonymous User'){ echo $ProfileImage; } ?></td>
						<td align="center"><?php echo $user['promocode']; ?></td>
						<td align="center"><?php echo $user['createdAdCount']; ?></td>
						<td align="center"><?php echo $user['publishedAdCount']; ?></td>
						<td align="center"><?php if(isset($user['signedUp']) && $user['signedUp'] != ''){ echo date('M j, Y', strtotime($user['signedUp'])); }else{ echo ""; } ?></td>
						<td align="center">
							<?php if($key > 0){ ?> <!-- This condition requires to restrict for displaying the textbox of revenue share to the ANONYMOUS user -->
								
								<div class="input-append">
									<input class="span2" type="text" name="revenue" id="revenue_<?php echo $user['user_id']; ?>" value="<?php if(isset($user['revenue']) && $user['revenue'] != 0){ echo $user['revenue']; }else{ echo "68"; } ?>" style="width:50px;height:20px;" onfocus="showBtn('<?php echo $user['user_id']; ?>')" />
									<span class="add-on">%</span>
								</div>
								
								 &nbsp;
								<input type="hidden" id="hid_revenue_<?php echo $user['user_id']; ?>" value="<?php echo $user['revenue']; ?>" />
								<span class="allBtn" id="saveBtn_<?php echo $user['user_id']; ?>" style="display:none;">
									<button class="btn btn-primary btn-mini" style="outline:none;" id="ajaxSave_<?php echo $user['user_id']; ?>" onclick="saveRevenue('<?php echo $user['user_id']; ?>')" type="button">Save</button>
								</span><br />
								<span id="mainloader_<?php echo $user['user_id']; ?>" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Updating Revenue Share</span>
							<?php } ?>	
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>