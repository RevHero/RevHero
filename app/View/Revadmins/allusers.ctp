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
			{ "sWidth": '30%' },
			{ "sWidth": '15%' },
			{ "sWidth": '20%' },
			{ "sWidth": '10%' },
			{ "sWidth": '10%' },
			{ "sWidth": '15%' },
		    ]
	});
});

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
				</tr>
			</thead>
			<tbody>
				<?php
					//echo "<pre>";print_r($UserDetailsWithPromoCode);exit;
					$count=0;
					foreach(@$UserDetailsWithPromoCode as $user){
					$count++;
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
						<td align="center"><?php echo $ProfileImage; ?></td>
						<td align="center"><?php echo $user['promocode']; ?></td>
						<td align="center"><?php echo $user['createdAdCount']; ?></td>
						<td align="center"><?php echo $user['publishedAdCount']; ?></td>
						<td align="center"><?php if(isset($user['signedUp']) && $user['signedUp'] != ''){ echo date('M j, Y', strtotime($user['signedUp'])); }else{ echo ""; } ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>