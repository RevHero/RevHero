<script type="text/javascript" src="<?php echo JS_PATH.'bootstrap-tagsinput.js';?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.textareaCounter.plugin.js';?>"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH.'bootstrap-tagsinput.css';?>" />
<script language="javascript" type="text/javascript">
$(document).ready(function(){
$(".bootstrap-tagsinput").css("min-width", "270px");


$('#testTextarea2').mouseover(function()
{
	$("#removeCnt").remove();
});
$('#testTextarea2').focus(function()
{
	$("#removeCnt").remove();
});

var countcharBodyText = {
		'maxCharacterSize': 104,
		'originalStyle': 'originalTextareaInfo',
		'warningStyle' : 'warningTextareaInfo',
		'warningNumber': 40,
		//'displayFormat' : '#input Characters | #left Characters Left | #words Words'  
		'displayFormat' : '#left Characters Left'  
};
$('#testTextarea2').textareaCount(countcharBodyText);


var text_max_headline = 35;
//$('#textbox_headline').html(text_max_headline + ' Characters Left');

$('#add_headline').keyup(function() {
	var text_length = $('#add_headline').val().length;
	var text_remaining = text_max_headline - text_length;

	$('#textbox_headline').html(text_remaining + ' Characters Left');
});


$("#dest_url").change(function()
{
	var strURL = $('#pageurl').val();
	var dest_url = $("#dest_url").val().trim();
	$("#loader").show();
	$("#changeRequest").hide();
	$.post(strURL+"ads/getTitleFromUrl",{url:dest_url},function(data){
		//alert(JSON.stringify(data, null, 4));
		$("#loader").hide();
		$("#changeRequest").show();
		if(data.status == 1){
			var max_count = 35;
			var totalCount = data.title.length;
			var finalLeft = max_count-totalCount
			$("#add_headline").val(data.title);
			//$("#hid_headline").val(data.fulltitle);
			$("#textbox_headline").html(finalLeft+' Characters Left');
		}else{
			$("#add_headline").val('');
			//$("#hid_headline").val(data.fulltitle);
			$("#textbox_headline").html('35 Characters Left');
		}
		
	},'json');
});

/*$("#changeRequest").click(function()
{
	var cpa = $("#cpa").val();
	var allTags = $("#allTags").val();
	
	if(cpa && allTags == ''){
		$(".bootstrap-tagsinput").css("border-color", "#FF0000");
		//$(".bootstrap-tagsinput").children("input").first().attr("required", "true");
		$(".bootstrap-tagsinput").children("input").focus();
		return false;
	}else if(cpa && allTags != ''){
		$(".bootstrap-tagsinput").css("border-color", "#47AEE9");
	}
});*/

});
</script>

<?php

//echo "<pre>";print_r($getEditDetails);exit;

$tagNames = '';

foreach($getEditDetails['Tag'] as $tag)
{
	$tagNames .= $tag['tag_name'].',';
}
$tagNames = substr($tagNames,0,-1);
?>

<div class="container">
	<div><h2>Edit Advertise Details</h2></div>
	<div class="well">
		<div class="row">
			 <form class="form-horizontal" action="<?php echo HTTP_ROOT; ?>ads/edit" method="post" enctype="multipart/form-data">
			 <input type="hidden" name="hid_edit_id" id="hid_edit_id" value="<?php echo $getEditDetails['AdDetail']['id']; ?>" />
				<fieldset>
					<div class="control-group">
						<label class="control-label">Destination URL <b>:</b> </label>
						<div class="controls">
							<input type="url" name="data[Ad][dest_url]" id="dest_url" placeholder="http://www.example.com"  class="input-xlarge" required="true" maxlength="512" size="512" value="<?php echo $getEditDetails['AdDetail']['dest_url']; ?>">
							<input type="hidden" name="hid_dest_url" id="hid_dest_url" value="<?php echo $getEditDetails['AdDetail']['dest_url']; ?>" />
							<!--<p class="help-block">Max. 512 Characters</p>-->
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Headline <b>:</b></label>
						<div class="controls">
							<input type="text" name="data[Ad][headline]" id="add_headline" placeholder=""  class="input-xlarge" required="true" maxlength="35" size="35" value="<?php echo $getEditDetails['AdDetail']['headline']; ?>">
							<input type="hidden" name="hid_headline" id="hid_headline" value="<?php echo $getEditDetails['AdDetail']['headline']; ?>" />
							<span id="loader" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Updating Headline</span>
						    <div id="textbox_headline">
								<?php
									if(strlen($getEditDetails['AdDetail']['headline']) == 35){
										echo "0 Characters Left";
									}else{
										$remaining = 35 - strlen($getEditDetails['AdDetail']['headline']);
										echo $remaining." Characters Left";
									}
								?>
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Text <b>:</b></label>
						<div class="controls">
							<textarea rows="3"  name="data[Ad][bodytext]" style="resize:none;width:270px;" required="true" id="testTextarea2"><?php echo $getEditDetails['AdDetail']['body']; ?></textarea>
							<input type="hidden" name="hid_body" id="hid_body" value="<?php echo $getEditDetails['AdDetail']['body']; ?>" />
							<div id="removeCnt" style="width: 270px;margin-top:-19px;">
								<?php
									if(strlen($getEditDetails['AdDetail']['body']) == 104){
										echo "0 Characters Left";
									}else{
										$remaining1 = 104 - strlen($getEditDetails['AdDetail']['body']);
										echo $remaining1." Characters Left";
									}
								?>
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">CPC <b>:</b></label>
						<div class="controls">
							$ <input type="text" name="data[Ad][cpc]" id="cpc" placeholder="1.85" class="input-xlarge" required="true" style="width:45px;" value="<?php echo $getEditDetails['AdDetail']['CPC']; ?>">
							<input type="hidden" name="hid_CPC" id="hid_CPC" value="<?php echo $getEditDetails['AdDetail']['CPC']; ?>" />
						</div>
					</div>	
					<div class="control-group">
						<label class="control-label">CPA <b>:</b></label>
						<div class="controls">
							$ <input type="text" name="data[Ad][cpa]" id="cpa" placeholder="1.25"  class="input-xlarge" required="true" style="width:45px;" value="<?php echo $getEditDetails['AdDetail']['CPA']; ?>">
							<input type="hidden" name="hid_CPA" id="hid_CPA" value="<?php echo $getEditDetails['AdDetail']['CPA']; ?>" />
						</div>
					</div>	
					<div class="control-group">
						<label class="control-label">Tags <b>:</b></label>
						<div class="controls">
							<input type="text" name="data[Ad][alltags]" data-role="tagsinput" id="allTags" value="<?php echo $tagNames; ?>"/>
							<input type="hidden" name="hid_alltags" id="hid_alltags" value="<?php echo $tagNames; ?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Image <b>:</b></label>
						<div class="controls">
							<input type="file" name="data[Ad][uploadimage]" class="input-xlarge"/>
							<input type="hidden" name="hid_image" id="hid_image" value="<?php echo $getEditDetails['AdDetail']['ad_image']; ?>" />
						</div><br />
						<div class="controls">
						<?php if(isset($getEditDetails['AdDetail']['ad_image']) && $getEditDetails['AdDetail']['ad_image'] != ''){ ?>
							<img src="<?php echo HTTP_FILES."ad_photos/".$getEditDetails['AdDetail']['ad_image']; ?>" border="0" style="max-height:100px;max-width:100px;" />
						<?php } ?>	
						</div>
					</div>
					<div class="form-actions">
						<button class="btn btn-primary" id="changeRequest">Save</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<script>
$('#allTags').tagsinput({
  typeahead: {
	  source: function(query) {
		 return $.getJSON('<?php echo HTTP_ROOT; ?>ads/getTag');
	  }
  }
});
</script>