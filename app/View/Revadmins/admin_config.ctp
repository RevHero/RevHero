<script language="javascript" type="text/javascript">
function validate()
{
	var onlynumRegx = /^[0-9]+$/; //Regular expression for only number validation
	var duplicateDays = $("#duplicateDays").val();
	var advduplicateDays = $("#advduplicateDays").val();
	var isValidation = false;//Require to hold the value for check the validation
	
	if(duplicateDays || advduplicateDays)
	{
		if(duplicateDays){
			if(onlynumRegx.test(duplicateDays)){
				isValidation = true;
			}else{
				alert("Please enter only number for duplicate days.");
				isValidation = false;
			}
		}
		
		if(advduplicateDays){
			if(onlynumRegx.test(advduplicateDays)){
				isValidation = true;
			}else{
				alert("Please enter only number advertiser for duplicate days.");
				isValidation = false;
			}
		}
		
		if(isValidation == false){
			return false;
		}else{
			return true;
		}
	}
	else
	{
		return false;
	}
}
</script>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2"></div>
		<div class="span9">
			<div class="container">
				<div class="row">
					 <form class="form-horizontal" action="<?php echo HTTP_ROOT; ?>revadmins/admin_config" method="post">
						<fieldset>
							<!-- Address form -->
					 
							<h2>Config</h2>
					 
							<!-- Duplicate days input-->
							<div class="control-group">
								<label class="control-label">Duplicate Days</label>
								<div class="controls">
									<input id="duplicateDays" name="duplicate_days" type="text" placeholder="Duplicate Days" value="<?php echo @$getAllValues[0]['Config']['value']; ?>">
									<p class="help-block"></p>
								</div>
							</div>
							
							<!-- Duplicate days input for ADVERTISER-->
							<div class="control-group">
								<label class="control-label">Advertiser Duplicate Days</label>
								<div class="controls">
									<input id="advduplicateDays" name="adv_duplicate_days" type="text" placeholder="Advertiser Duplicate Days" value="<?php echo @$getAllValues[1]['Config']['value']; ?>">
									<p class="help-block"></p>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label"></label>
								<div class="controls">
									<button class="btn btn-primary" onclick="return validate();" style="outline:none;">Submit</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>