<script type="text/javascript" src="<?php echo JS_PATH.'bootstrap-tagsinput.js';?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.textareaCounter.plugin.js';?>"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH.'bootstrap-tagsinput.css';?>" />
<script language="javascript" type="text/javascript">
$(document).ready(function(){
/*var text_max = 99;
$('#textarea_feedback').html(text_max + ' characters remaining');

$('#testTextarea2').keyup(function() {
	var text_length = $('#testTextarea2').val().length;
	var text_remaining = text_max - text_length;
	$('#textarea_feedback').html(text_remaining + ' characters remaining');
});*/

$('#testTextarea2').mouseover(function()
{
	$("#removeCnt").remove();
});

	var countchar = {
			'maxCharacterSize': 104,
			'originalStyle': 'originalTextareaInfo',
			'warningStyle' : 'warningTextareaInfo',
			'warningNumber': 40,
			//'displayFormat' : '#input Characters | #left Characters Left | #words Words'  
			'displayFormat' : '#left Characters Left'  
	};
	$('#testTextarea2').textareaCount(countchar);
	
/*	var options2 = {
			'maxCharacterSize': 200,
			'originalStyle': 'originalTextareaInfo',
			'warningStyle' : 'warningTextareaInfo',
			'warningNumber': 40,
			'displayFormat' : '#input/#max | #words words'
	};
	$('#testTextarea2').textareaCount(options2);*/
	
});
</script>
<div class="container">
	<div><h2>Add New Advertise Details</h2></div>
	<div class="well">
		<div class="row">
			 <form class="form-horizontal" action="<?php echo HTTP_ROOT; ?>ads/add" method="post">
				<fieldset>
					<div class="control-group">
						<label class="control-label">Headline</label>
						<div class="controls">
							<input type="text" name="data[Ad][headline]" id="add_headline" placeholder=""  class="input-xlarge" required="true">
						    <p class="help-block">Max. 35 Characters</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Destination URL</label>
						<div class="controls">
							<input type="text" name="data[Ad][dest_url]" id="dest_url" placeholder=""  class="input-xlarge" required="true">
							<p class="help-block">Max. 512 Characters</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Body Text</label>
						<div class="controls">
							<textarea rows="3"  name="data[Ad][bodytext]" style="resize:none;width:270px;" required="true" id="testTextarea2"></textarea>
							<div id="removeCnt" style="width: 270px;margin-top:-19px;">104 Characters Left</div>
						</div>
					</div>
					<!--<div class="control-group">
						<label class="control-label">CPC</label>
						<div class="controls">
							$ <input type="text" name="data[Ad][cpc]" id="cpc" placeholder=""  class="input-xlarge" required="true" style="width:45px;">
						</div>
					</div>	
					<div class="control-group">
						<label class="control-label">CPA</label>
						<div class="controls">
							$ <input type="text" name="data[Ad][cpa]" id="cpa" placeholder=""  class="input-xlarge" required="true" style="width:45px;">
						</div>
					</div>	-->
					<div class="control-group">
						<label class="control-label">Tags</label>
						<div class="controls">
							<input type="text" name="data[Ad][alltags]" data-role="tagsinput" id="allTags" class="input-xlarge"/>
						</div>
					</div>
					<div class="form-actions">
						<button class="btn btn-primary">Save</button>
						<button class="btn" type="reset">Reset</button>
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