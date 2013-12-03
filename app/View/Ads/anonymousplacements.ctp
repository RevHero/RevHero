<p class="text-center"><b>List of placements to be linked to your account.</b></p>
<style>
.pagination ul > .active > a,
.pagination ul > li > a:hover{
    background-color: #428BCA;
	border-color:#428BCA;
	color:#FFFFFF;
}
#mainAd:hover{
	background-color:#F8F8F8;
}
</style>
<form action="<?php echo HTTP_ROOT.'ads/linkplacement'; ?>" method="post">
<?php

	foreach($getallplacements as $placement)
	{

?>
<input type="hidden" name="hid_placement_id[<?php echo $placement['Placement']['id'] ?>]" value="<?php echo $placement['Placement']['id'] ?>" />

<div class="row">
  <div class="span4"></div>
  <div class="span8" style="border:1px solid #CCCCCC;padding:10px;margin-bottom:20px;">
    <div class="row">
      <div class="span2">
	  	<?php
			if(isset($placement['AdDetail']['ad_image']) && $placement['AdDetail']['ad_image'] != ''){
				if(file_exists(DIR_AD_PHOTOS.$placement['AdDetail']['ad_image'])){
		?>
			        <img src="<?php echo HTTP_FILES; ?>ad_photos/<?php echo $placement['AdDetail']['ad_image']; ?>" alt="" class="thumbnail" style="max-width:100px;max-height:100px;">
			<?php }else{ ?>
					<img src="<?php echo HTTP_IMAGES; ?>no_image.gif" alt="" class="thumbnail" style="max-width:100px;max-height:100px;">
		<?php } } else{ ?>
				<img src="<?php echo HTTP_IMAGES; ?>no_image.gif" alt="" class="thumbnail" style="max-width:100px;max-height:100px;">
		<?php } ?>
      </div>
      <div class="span6">      
        <p><h4><?php echo substr($placement['AdDetail']['headline'],0,35); ?></h4></p>
		<p style="color:#232323;font-size:12px;"><?php echo date("M j, Y", strtotime($placement['Placement']['created'])); ?> | <a href="<?php echo $placement['AdDetail']['dest_url']; ?>" target="_blank"><?php echo $placement['AdDetail']['dest_url']; ?></a></p>
		<div class="pull-left" style="color:#232323;font-size:11px;font-weight:bold;">
			<?php
				if(count($placement['AdClick']) > 0){
					if(count($placement['AdClick']) == 1){
						echo "1 Click";
					}else{
						echo count($placement['AdClick'])." Clicks";
					}	
				}else{
					echo "0 Click";
				}
			?> 
			|
			<a href="<?php echo HTTP_ROOT; ?>users/placementdetails/<?php echo $placement['Placement']['id']; ?>">View stats</a>
		</div>
		<div class="input-append pull-right">
			<input class="span4 shorturl" id="box-content" type="text" readonly="readonly" value="<?php echo $placement['Placement']['short_url']; ?>" style="height:16px;">
			<!--<input type="button" class="btn btn-primary copyshorturl" id="copy" name="copy" value="Copy" onClick="cpy('box-content','copy');" />-->
		</div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<p class="text-left" style="margin-left:270px;">
<button class="btn btn-primary" name="linked" type="submit">Link</button>
<button class="btn btn-primary" name="skipped" type="submit">Skip</button>
</p>
</form>