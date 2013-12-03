<script language="javascript" type="text/javascript">
function closeBox()
{
	$("#displayMsg").hide();
}
</script>
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
<?php
//echo "<pre>";print_r($getallplacements);exit;

if(count($getallplacements) == 0)
{

?>
<?php /*?><div class="row-fluid">
	<!--<div class="span4"></div>-->
	<div class="span16" style="border:1px solid #CCCCCC;padding:5px;margin-bottom:10px;width:640px; text-align:center;color:#FF0000;">
	<!--<div class="span8" style="border:1px solid #CCCCCC;padding:5px;margin-bottom:10px;width:640px; text-align:center;color:#FF0000;">-->
		You don't have any placements
		<p style="margin-top:20px;">
			<a href="<?php echo HTTP_ROOT; ?>ads/store">
				<button class="btn btn-primary" type="button">Create a New Placement</button>
			</a>	
		</p>
	</div>
</div><?php */?>
<div class="container">
<div class="row-fluid">
	<div class="span16" style="text-align:center;color:#FF0000;border:1px solid #999999;padding-top:10px;">
	  <p>You don't have any placements.</p>
	  <?php if($countgetallApprovedAds > 0){ ?>
		  <p style="margin-top:20px;">
			  <a href="<?php echo HTTP_ROOT; ?>ads/store">
				  <button class="btn btn-primary" type="button">Create a New Placement</button>
			  </a>	
		  </p>
	  <?php } if($countgetallActivedAds > 0 && $countgetallApprovedAds == 0){ ?>
		  <p style="color:#333333;">
			  Publish your created <a href="<?php echo HTTP_ROOT; ?>ads/lists">Ads yet to be approved</a> by the Admin
		  </p>
	  <?php } ?>	  
	</div>
</div>
</div>  
<?php }else{ ?>
<?php /*?><div class="row">
	<div class="span4"></div>
	<div class="span8" style="border:1px solid #CCCCCC;padding:5px;margin-bottom:10px;width:640px;">
		1 - 5 of <?php echo $totalplacementcounts; ?> Placements
		Page <?php echo $this->Paginator->counter(); ?>
	</div>
</div><?php */?>

<?php

	foreach($getallplacements as $placement)
	{

?>

<div class="row">
  <div class="span4"></div>
  <div class="span8" style="border:1px solid #CCCCCC;padding:10px;margin-bottom:20px;">
    <div class="row">
      <div class="span2">
	  	<?php
			if(isset($placement['AdDetail']['ad_image']) && $placement['AdDetail']['ad_image'] != ''){
		?>
		        <img src="<?php echo HTTP_FILES; ?>ad_photos/<?php echo $placement['AdDetail']['ad_image']; ?>" alt="" class="thumbnail">
		<?php }else{ ?>
				<img src="<?php echo HTTP_IMAGES; ?>no_image.gif" alt="" class="thumbnail">
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
<div class="row">
	<div class="span4"></div>
	<div class="span8" style="width:640px;">
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
	</div>
</div>
<?php } ?>