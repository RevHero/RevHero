<style>
.displayDetails{
	padding:0px;
	margin:0 0 5px 0;
}
</style>
<script language="javascript" type="text/javascript">
$(document).ready(function()
{
	$("#customKeyword").change(function()
	{
		var strURL = $('#pageurl').val();
		var customKeyword = $("#customKeyword").val().trim();
		if(customKeyword && customKeyword != '')
		{
			$("#loader").show();
			$("#publishBtn").hide();
			$.post(strURL+"ads/getUniqueKeyword",{customKeyword:customKeyword},function(data){
				//alert(JSON.stringify(data, null, 4));
				$("#loader").hide();
				$("#publishBtn").show();
				if(data.status == 1){
					$("#notavail").show();
					$("#avail").hide();
					$("#notavail").html('Keyword does not exist. Please write another.');
					$("#hid_is_keyword_exist").val(1);
				}else{
					$("#notavail").hide();
					$("#avail").show();
					$("#avail").html('Keyword Available.');
					$("#hid_is_keyword_exist").val(0);
				}
				
			},'json');
		}	
	});
	
	$("#publishBtn").click(function()
	{
		var strURL = $('#pageurl').val();
		var customKeyword = $("#customKeyword").val().trim();
		var adType        = $('input:radio[name=adType]:checked').val();
		var adFormat      = $('input:radio[name=adFormat]:checked').val();
		var adversiteId   = $("#hid_ad_id").val().trim();
		var publisherId   = $("#hid_publisher_id").val().trim();
		var iskeyword     = $("#hid_is_keyword_exist").val().trim();
		var DisplayContent = '';
		
		var hid_headline        = $("#hid_headline").val();
		var hid_body            = $("#hid_body").val();
		var hid_destination_url = $("#hid_destination_url").val();
		
		if(iskeyword == '0' || iskeyword == ''){
			$("#mainloader").show();
			$("#publishBtn").hide();
			$.post(strURL+"ads/savePlacements",{customKeyword:customKeyword,adType:adType,adFormat:adFormat,adversiteId:adversiteId,publisherId:publisherId},function(data){
				//alert(JSON.stringify(data, null, 4));
				$("#mainloader").hide();
				$("#publishBtn").show();
				$("#customKeyword").val('');
				$("#notavail").hide();
				$("#avail").hide();
				if(data.status == 1){
					if(adType == 'text' && adFormat == '1'){
						DisplayContent = hid_headline+' - '+hid_body+' - '+hid_destination_url;
						$("#placementcontainer").show();
						$("#placementShow").html(DisplayContent);
						$('html, body').animate({scrollTop: $(window).scrollTop() + $(window).height()}, 800);
					}else if(adType == 'html' && adFormat == '1'){
						DisplayContent = '&lt;a href="'+hid_destination_url+'" target="_blank">'+hid_headline+'&lt;/a&gt; - '+hid_body;
						$("#placementcontainer").show();
						$("#placementShow").html(DisplayContent);
						$('html, body').animate({scrollTop: $(window).scrollTop() + $(window).height()}, 800);
					}else if(adType == 'text' && adFormat == '3'){
						DisplayContent = hid_headline+'<br>'+hid_destination_url+'<br>'+hid_body;
						$("#placementcontainer").show();
						$("#placementShow").html(DisplayContent);
						$('html, body').animate({scrollTop: $(window).scrollTop() + $(window).height()}, 800);
					}else if(adType == 'html' && adFormat == '3'){
						DisplayContent = '&lt;a href="'+hid_destination_url+'" target="_blank"&gt;'+hid_headline+'&lt;/a&gt;&lt;br&gt;&lt;a href="'+hid_destination_url+'" target="_blank"&gt;'+hid_destination_url+'&lt;/a&gt;&lt;br&gt;'+hid_body;
						$("#placementcontainer").show();
						$("#placementShow").html(DisplayContent);
						$('html, body').animate({scrollTop: $(window).scrollTop() + $(window).height()}, 800);
					}
				}else{
					$("#placementcontainer").hide();
					$("#placementShow").html('');
				}
				
			},'json');
		}else{
			alert("Please change custom keyword.");
			return false;
		}	
	});
});
</script>
<div class="container well">
  <div>
  	<h3><?php echo substr($getDetails['AdDetail']['headline'],0,35); ?></h3>
  </div>
  <div class="row">
    <div class="span1.5">
	  <?php if($getDetails['AdDetail']['ad_image']){ ?>
	      <img src="<?php echo HTTP_FILES."ad_photos/".$getDetails['AdDetail']['ad_image']; ?>"  alt="<?php echo substr($getDetails['AdDetail']['headline'],0,35); ?>" class="img-rounded" style="max-width:100px;max-height:110px;">
	  <?php }else{ ?>
    	  <img src="<?php echo HTTP_IMAGES."no_image.gif/"; ?>"  alt="<?php echo substr($getDetails['AdDetail']['headline'],0,35); ?>" class="img-rounded" style="max-width:100px;max-height:110px;">
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
		<p class="displayDetails"><b>CPA:</b> $<?php echo number_format($getDetails['AdDetail']['CPA'],2); ?></p>
		<p class="displayDetails"><i class="icon-envelope"></i> <?php echo $getDetails['User']['email']; ?></p>
        <p class="displayDetails"><b>Created:</b> <?php echo date("F j, Y", strtotime($getDetails['AdDetail']['created'])); ?></p>
      </p>
    </div>
  </div>
  <div style="margin-top:10px;">
	 <?php echo $getDetails['AdDetail']['body']; ?>
  </div>
</div>

<div class="container well">
	<div class="row">
		<div class="span1.5">
			<h4>Create Ad Placement</h4>
		</div>
	</div>
	<div class="row">
		<form class="form-horizontal" method="post" onsubmit="return false;">
			<input type="hidden" name="hid_ad_id" id="hid_ad_id" value="<?php echo $getDetails['AdDetail']['id']; ?>" />
			<input type="hidden" name="hid_publisher_id" id="hid_publisher_id" value="<?php echo $this->Session->read('Auth.User.id'); ?>" />
			<input type="hidden" name="hid_is_keyword_exist" id="hid_is_keyword_exist" value="" />
			<input type="hidden" name="hid_headline" id="hid_headline" value="<?php echo $getDetails['AdDetail']['headline']; ?>" />
			<input type="hidden" name="hid_body" id="hid_body" value="<?php echo $getDetails['AdDetail']['body']; ?>" />
			<input type="hidden" name="hid_destination_url" id="hid_destination_url" value="<?php echo $getDetails['AdDetail']['dest_url']; ?>" />
			<div class="control-group">
				<label class="control-label" for="inputKeyword">Custom Keyword</label>
				<div class="controls">
					<input type="text" id="customKeyword" placeholder="Custom Keyword">
					<span id="loader" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Getting Availability</span>
					<span style="color:#006600;margin-left:10px;" id="avail"></span>
					<span style="color:#FF0000;margin-left:10px;" id="notavail"></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputAdType">Type</label>
				<div class="controls">
					<input type="radio" name="adType" id="adType1" value="html"> <span style="vertical-align:text-top">HTML</span>&nbsp;
					<input type="radio" name="adType" id="adType2" value="text" checked="checked"> <span style="vertical-align:text-top">Text</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputFormat">Format</label>
				<div class="controls">
					<input type="radio" name="adFormat" id="adType1" value="1" checked="checked"> <span style="vertical-align:text-top">One Line</span>&nbsp;
					<input type="radio" name="adFormat" id="adType2" value="3"> <span style="vertical-align:text-top">Three Line</span>
				</div>
			</div>
		</form>
	</div>
	<div>
	   <button class="btn btn-primary" id="publishBtn">Publish</button>
	   <span id="mainloader" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Creating Ad Placement</span>
    </div>
</div>

<div class="container well" id="placementcontainer" style="display:none;">
	<div class="row">
		<div class="span1"></div>
		<div class="span11">
		  <h4>Copy the below content to display in your website.</h4>
		  <p id="placementShow"></p>
		</div>
	</div>
</div>