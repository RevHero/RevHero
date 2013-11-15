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
<script language="javascript" type="text/javascript">
function getTheDetails(ad_id)
{
	document.location.href = '<?php echo HTTP_ROOT; ?>ads/details/'+ad_id;
}
</script>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<div>
				<ul class="nav nav-pills nav-stacked">
					<?php
					//echo "<pre>";print_r($alltags);exit;
					foreach($alltags as $tag){
					if(count($tag['AdDetail']) > 0){
					?>
						<li class="tag-item" title="<?php echo $tag['Tag']['tag_name']; ?>">
							<a style="background-color: #2C3E50; color:#FFF;" href="<?php echo HTTP_ROOT; ?>ads/tagdetails/<?php echo str_replace(" ","+",$tag['Tag']['tag_name']); ?>" class="1111">
								<span class="badge pull-right"><?php echo count($tag['AdDetail']); ?></span>
								<span>
									<?php
										if(strlen($tag['Tag']['tag_name']) > 15){
											echo substr($tag['Tag']['tag_name'],0,15)."...";
										}else{
											echo $tag['Tag']['tag_name'];
										}
									?>
								</span>
							</a>
						</li>
					<?php } } ?>
				</ul>
			</div>
		</div>
		<div class="span9">
				<div><h4 style="margin-top:0px;">Displaying Ads tagged with "<?php echo $tagname; ?>"</h4></div>
			<!--<div class="container">-->
				<?php if(count($allrequiretagdetails) > 0){ ?>
				<!--<div class="row-fluid">-->
				  <ul class="thumbnails">
					<?php
						$counter = 1;
						//echo "<pre>";print_r($allrequiretagdetails);exit;
						foreach($allrequiretagdetails as $addisplay){
						
						if($addisplay['AdDetail']['status'] == 1){
						
						if($counter % 6 == 0){
							$first_child = 'margin-left:0px;padding-left:0px;';
						}else{
							$first_child = '';
						}
					?>
						<li class="span2" style="cursor:pointer;width: 140px;<?php echo $first_child; ?>" id="mainAd" onclick="getTheDetails('<?php echo $addisplay['AdDetail']['id'] ?>');">
						  <div class="thumbnail" style="padding: 0">
							<div style="padding:4px;height:130px;text-align:center;vertical-align:middle;">
							<?php
							  if(isset($addisplay['AdDetail']['ad_image']) && $addisplay['AdDetail']['ad_image'] != '' && file_exists(DIR_AD_PHOTOS.$addisplay['AdDetail']['ad_image'])){
							?>
								<img class="img-rounded" style="max-height:125px;max-width:130px;" title="<?php echo $addisplay['AdDetail']['headline']; ?>" alt="<?php echo $addisplay['AdDetail']['headline']; ?>" src="<?php echo HTTP_FILES.'ad_photos/'.$addisplay['AdDetail']['ad_image']; ?>">
							<?php
							  }else{
							?>
								<img class="img-rounded" style="max-height:125px;max-width:130px;" title="<?php echo $addisplay['AdDetail']['headline']; ?>" alt="<?php echo $addisplay['AdDetail']['headline']; ?>" src="<?php echo HTTP_IMAGES.'no_image.gif'; ?>">
							<?php  
							  }	
							?>	
							</div>
							<div class="caption" style="height: 70px;border-top:1px solid #DDDDDD;">
							  <h5 title="<?php echo $addisplay['AdDetail']['headline']; ?>">
								<?php
									if(strlen($addisplay['AdDetail']['headline']) > 10){
										echo substr($addisplay['AdDetail']['headline'],0,10)." &hellip;";
									}else{
										echo $addisplay['AdDetail']['headline'];
									}	
								?>
							  </h5>
							  <p style="font-weight:bold;color:#000000;">CPA: $ <?php echo number_format($addisplay['AdDetail']['CPA'],2); ?></p>
							</div>
						  </div>
						</li>
					<?php $counter++; } } ?>
				  </ul>
				<!--</div>-->
				<div class="pagination pull-right">
					<ul>
					<?php echo $this->Paginator->prev(
							'&larr; ' . __('Previous'),
							array(
								'escape' => false,
								'tag' => 'li'
							),
							'<a onclick="return false;">&larr; Previous</a>',
							array(
								'class'=>'disabled prev',
								'escape' => false,
								'tag' => 'li'
							)
						);
						?>
						<?php
							echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
						?>
						<?php
						echo $this->Paginator->next(
							__('Next') . ' &rarr;',
							array(
								'escape' => false,
								'tag' => 'li'
							),
							'<a onclick="return false;">Next &rarr;</a>',
							array(
								'class' => 'disabled next',
								'escape' => false,
								'tag' => 'li'
							)
						);
						?>
					</ul>
				</div>
				<?php }else{ ?>
				<div class="row-fluid">
					<div class="span12" style="text-align:center;color:#FF0000;border:1px solid #999999;padding-top:10px;">
					  <p>No Ad Store available.</p>
					</div>
				</div>  
				<?php } ?>
			<!--</div>-->
		
		</div>
	</div>
</div>