<?php if(isset($anonymousads)){ 
		foreach($anonymousads as $getDetails) { ?>
			  <div class="container well" id="detailid" >
  <?php 
 if(isset($getDetails)){ ?>
  <div>
  	<h3><?php echo substr($getDetails['AdDetail']['headline'],0,35); ?></h3>
  </div>
  <div class="row">
    <div class="span1.5">
	  <?php if($getDetails['AdDetail']['ad_image'] && file_exists(DIR_AD_PHOTOS.$getDetails['AdDetail']['ad_image'])){ ?>
	      <img src="<?php echo HTTP_FILES."ad_photos/".$getDetails['AdDetail']['ad_image']; ?>"  alt="<?php echo substr($getDetails['AdDetail']['headline'],0,35); ?>" class="img-rounded" style="max-width:100px;max-height:110px;">
	  <?php }else{ ?>
    	  <img src="<?php echo HTTP_IMAGES."no_image.gif"; ?>"  alt="<?php echo substr($getDetails['AdDetail']['headline'],0,35); ?>" class="img-rounded" style="max-width:100px;max-height:110px;">
	  <?php } ?>
    </div>
    <div class="span4.5">
      <p class="displayDetails">
        <i class="icon-globe"></i> <a href="<?php echo $getDetails['AdDetail']['dest_url']; ?>" style="outline:none;" target="_blank"><?php echo $getDetails['AdDetail']['dest_url']; ?></a><br />
		<p class="displayDetails"><b>Tags:</b>
			<?php
				$allTags = '';
				foreach($getDetails['Tag'] as $tag)
				{
					$allTags .= '<span class="tag label label-info">'.$tag['tag_name']."</span> ";
				}
				echo $allTags;
			?>
		</p>
		<?php if(isset($detailpg)){ ?>
			<p class="displayDetails"><b>CPA:</b> $<?php echo number_format($getDetails['AdDetail']['CPA'],2); ?></p>
			<?php if(!empty($getDetails['User']['email'])) { ?> <p class="displayDetails"><i class="icon-envelope"></i> <?php echo $getDetails['User']['email']; ?></p> <?php } ?>
			<p class="displayDetails"><b>Created:</b> <?php echo date("F j, Y", strtotime($getDetails['AdDetail']['created'])); ?></p>
		<?php } ?>
		
      </p>
    </div>
	<?php if(!isset($home) && !isset($detailpg)){ ?>
	<div class="span12" >&nbsp;</div>
	<div class="span12" >
		<div class="span4.5">
		<div class="control-group">
			<div class="span0.5">CPC <b>:</b></div>
			<div class="controls span1.5" style="margin-top:-9px;">
			$ <input type="text" name="cpc[<?php echo $getDetails['AdDetail']['id']; ?>]" id="cpc[<?php echo $getDetails['AdDetail']['id']; ?>]" value="0" class="input-xlarge"  style="width:45px;">
			</div>
		</div>	
		</div>
		<div class="span4.5">
		<div class="control-group">
			<div class="span0.5">CPA <b>:</b></div>
			<div class="controls span1.5" style="margin-top:-9px;">
			$ <input type="text" name="cpa[<?php echo $getDetails['AdDetail']['id']; ?>]" id="cpa[<?php echo $getDetails['AdDetail']['id']; ?>]" value="0"  class="input-xlarge"  style="width:45px;">
			</div>
		</div>	
		</div>
	</div>
	
	<?php } ?>
	
	
	
	</div>

  <?php } ?>
  <?php if(isset($detailpg)){ ?>
	<div style="margin-top:10px;">
	 	<?php echo $getDetails['AdDetail']['body']; ?>
	</div>
 <?php } ?>
</div>
<?php }
} ?>