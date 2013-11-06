<div class="container well">
  <div>
  	<h3><?php echo substr($getDetails['AdDetail']['headline'],0,35); ?></h3>
  </div>
  <div class="row">
    <div class="span1.5">
	  <?php if($getDetails['AdDetail']['ad_image']){ ?>
	      <img src="<?php echo HTTP_FILES."ad_photos/".$getDetails['AdDetail']['ad_image']; ?>"  alt="<?php echo substr($getDetails['AdDetail']['headline'],0,35); ?>" class="img-rounded" style="max-width:100px;max-height:110px;">
	  <?php }else{ ?>
    	  <img src="<?php echo HTTP_IMAGES."no_image.gif"; ?>"  alt="<?php echo substr($getDetails['AdDetail']['headline'],0,35); ?>" class="img-rounded" style="max-width:100px;max-height:110px;">
	  <?php } ?>
    </div>
    <div class="span5">
      <p class="displayDetails" style="font-size:14px;">
        <i class="icon-globe"></i> <a href="<?php echo $getDetails['AdDetail']['dest_url']; ?>" style="outline:none;" target="_blank"><?php echo $getDetails['AdDetail']['dest_url']; ?></a><br />
        <p class="displayDetails"><b>Placement Created:</b> <?php echo date("F j, Y", strtotime($getDetails['Placement']['created'])); ?></p>
		<div class="pull-left" style="color:#232323;font-size:11px;font-weight:bold;">
			<?php
				if(count($getDetails['AdClick']) > 0){
					if(count($getDetails['AdClick']) == 1){
						echo "1 Click";
					}else{
						echo count($getDetails['AdClick'])." Clicks";
					}	
				}else{
					echo "0 Click";
				}
			?> 
	   </div>
	   <div class="input-append pull-right">
		<input class="span4 shorturl" id="box-content" type="text" readonly="readonly" value="<?php echo $getDetails['Placement']['short_url']; ?>" style="height:16px;">
	   </div>
      </p>
    </div>
  </div>
  
</div>