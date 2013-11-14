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
			{ "sWidth": '40%' },
			{ "sWidth": '40%' },
			{ "sWidth": '20%' }
		    ]
	});
});

</script>
<?php
//echo "<pre>";print_r($PromoDetails);exit;
?>
<div class="span2"></div>
<div class="span4" style="margin-left:30px;margin-bottom:12px;">
	<div class="container well">
		<div class="row">
			<div class="span12">
				<h3><?php echo $PromoDetails[0]['PromoCode']['promocode']; ?></h3>
			</div>	
			<div class="span12">
			  <p class="displayDetails">
				<p class="displayDetails">
					<b>Valid From:</b>
					<?php
						echo date('F j, Y', strtotime($PromoDetails[0]['PromoCode']['validFrom']));
					?> &nbsp;<strong>|</strong>&nbsp;
					<b>Valid To:</b>
					<?php
						echo date('F j, Y', strtotime($PromoDetails[0]['PromoCode']['validTo']));
					?>
				</p>
				<p class="displayDetails"><b>Credit Amount:</b> $<?php echo number_format($PromoDetails[0]['PromoCode']['price'],2); ?></p>
				<p class="displayDetails"><b>Status:</b>
					<?php if($PromoDetails[0]['PromoCode']['status'] == 1){ ?>
						<span class="text-success"><strong>Active</strong></span>
					<?php }else{ ?>	
						<span class="text-error"><strong>Inactive</strong></span>
					<?php } ?>	
				</p>
			  </p>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
        <table id="table_id" class="table table-striped table-bordered" cellpadding="0" cellspacing="0" border="0" width="100%">
			<thead>
				<tr>
					<th>Email</th>
					<th>Profile Image</th>
					<th>Signed Up</th>
				</tr>
			</thead>
			<tbody>
				<?php
					//echo "<pre>";print_r($promoUsedUsers);exit;
					$count=0;
					foreach(@$promoUsedUsers as $user){
					$count++;
					$ProfileImage = '';
					
					if(isset($user['users']['prof_image']) && $user['users']['prof_image'] != '' && file_exists(DIR_PROFILE_IMAGES.$user['users']['prof_image']))
					{
						$ProfileImage = '<img src="'.HTTP_FILES."profile_images/".$user['users']['prof_image'].'" style="max-width:100px;max-height:100px;">';
					}else{
						$ProfileImage = '<img src="'.HTTP_IMAGES."no_user.png".'" style="max-width:100px;max-height:100px;">';
					}
					
				?>
					<tr id="row_<?php echo $user['users']['id']; ?>">
						<td align="center"><?php echo $user['users']['email']; ?></td>
						<td align="center"><?php echo $ProfileImage; ?></td>
						<td align="center"><?php echo date('M j, Y', strtotime($user['users']['created'])); ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>