<script language="javascript" type="text/javascript">

function closeBox()
{
	$("#displayMsg").hide();
}

function validate()
{
	var passwordValue = $("#pass").val();
	var passwordLength = passwordValue.length;
	
	if(passwordValue){
		if(passwordLength < 6){
			alert("Password should be minimum 6 characters.");
			return false;
		}else{
			return true;
		}
	}
}
$(document).ready(function(){
	$("#advertiseform").submit(function(event) {
		event.preventDefault();
		$('#login_div').hide('slow');
		$('#signup_div').hide('slow');
		$('#detailid').hide('slow');
		$('#ad_div').show('slow');
		$('#dest_url').val($('#adv_url').val());
		headline_txt();
	});
});


function headline_txt(){
	var strURL = $('#pageurl').val();
	var dest_url = $("#dest_url").val().trim();
	$("#loader").show();
	$("#SaveButton").hide();
	$.post(strURL+"ads/getTitleFromUrl",{url:dest_url},function(data){
		//alert(JSON.stringify(data, null, 4));
		$("#loader").hide();
		$("#SaveButton").show();
		if(data.status == 1){
			var max_count = 35;
			var totalCount = data.title.length;
			var finalLeft = max_count-totalCount
			$("#add_headline").val(data.title);
			$("#textbox_headline").html(finalLeft+' Characters Left');
		}else{
			$("#add_headline").val('');
			$("#textbox_headline").html('35 Characters Left');
		}
		
	},'json');

}

function homepage(){
	$('#login_div').show('slow');
	$('#signup_div').show('slow');
	$('#ad_div').hide('slow');
	$('#dest_url').val('');
	$('#adv_url').val('');
}


</script>

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
	$('#textbox_headline').html(text_max_headline + ' Characters Left');
	
	$('#add_headline').keyup(function() {
		var text_length = $('#add_headline').val().length;
		var text_remaining = text_max_headline - text_length;
	
		$('#textbox_headline').html(text_remaining + ' Characters Left');
	});
	$('#allTags').tagsinput({
	  typeahead: {
		  source: function(query) {
			 return $.getJSON('<?php echo HTTP_ROOT; ?>ads/getTag');
		  }
	  }
	});
});
function showtab(showid,hideid){
	$('#'+showid).show('slow');
	$('#'+hideid).hide('slow');
}
</script>
<div class="container">
	<div class="row">
		<div class="span4"></div>
		<div class="span4" id="displayMsg">
		  <?php if(@$success == 0 && @$success != ''){ ?>
			  <div class="alert alert-error">
				<a class="close" onclick="closeBox();">x</a>
				<strong>Sorry!!</strong> This email id is already registered.
			  </div>
		  <?php }else if(@$success == 2 && @$success != ''){ ?>
	  		  <div class="alert alert-error">
				<a class="close" onclick="closeBox();">x</a>
				<strong>Sorry!!</strong> This promo code is invalid.
			  </div>
		  <?php } ?>
		  
		  <?php if(@$confirmReg && @$confirmReg == 1){ ?>
		  		  <div class="alert alert-success">
					<a class="close" onclick="closeBox();">x</a>
					<strong>Thank You.</strong> Now you can login with your email and password.
				  </div>
		  <?php }else if(@$confirmReg == 0 && @$confirmReg != ''){ ?>
		  		  <div class="alert alert-error">
					<a class="close" onclick="closeBox();">x</a>
					<strong>Sorry!!</strong> This email id is already confirmed.
				  </div>
		  <?php } ?>
		  
		  <?php if(@$loginresult == 0 && @$loginresult != ''){ ?>
		  		  <div class="alert alert-error">
					<a class="close" onclick="closeBox();">x</a>
					<strong>Sorry!!</strong> Email or Password is invalid.
				  </div>
		  <?php } ?>
		  	  
		</div>
        <div class="span12">
    		<div class="" id="loginModal">
              <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>-->
				<div class="span5" id="signup_div" <?php if(isset($getDetails)){ ?>style="display:none;" <?php } ?>> <h3>Have an Account?</h3></div>
				<div class="span6"> 
				<form class="form-horizontal" method="post" id="advertiseform" name="advertiseform">
					<div class="input-append">
						<input type="url" class="span5" id="adv_url" name="adv_url" required="true" placeholder="Enter a url to advertise"/>
						<button class="btn btn-primary" type="submit">Advertise</button>
					</div>
				</form>
				</div>
				
				
				
				<div style="clear:both;"></div>
              </div>
			  
			  <div class="container well" id="detailid" <?php if(!isset($getDetails)){ ?>style="display:none;" <?php } ?> >
  <?php if(isset($getDetails)){ ?>
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
		<p>
		Sign up or Login to link this Advertisement to your account.
		</p>
      </p>
    </div>
  </div>
  <?php } ?>
</div>
			  
			  
			  
              <div class="modal-body" style="overflow:visible" id="login_div">
                <div class="well">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                    <li><a href="#create" data-toggle="tab">Create Account</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="login">
                      <form class="form-horizontal" action='users/logincheck' method="POST">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Login</legend>
                          </div>    
                          <div class="control-group">
                            <!-- Username -->
                            <label class="control-label"  for="username">Email</label>
                            <div class="controls">
                              <input type="text" name="email" placeholder="" class="input-xlarge" required="true">
                            </div>
                          </div>
     
                          <div class="control-group">
                            <!-- Password-->
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                              <input type="password" name="password" placeholder="" class="input-xlarge" required="true">
                            </div>
                          </div>
                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                              <button class="btn btn-success">Login</button>
							  <span style="margin-left:110px;color:#317EAC;"><a href="<?php echo HTTP_ROOT; ?>users/forgotpassword">Forgot Password?</a></span>
                            </div>
                          </div>
                        </fieldset>
                      </form>                
                    </div>
                    <div class="tab-pane fade" id="create">
                      <form class="form-horizontal" id="tab" action="" name="registration" method="post">
						<fieldset>
                          <div id="legend">
                            <legend class="">Create Account</legend>
                          </div>    
                          <div class="control-group">
                            <!-- Username -->
                            <label class="control-label" for="username">Email</label>
                            <div class="controls">
                              <input type="email" value="" class="input-xlarge" name="data[User][email]" required="true">
                            </div>
                          </div>
     
                          <div class="control-group">
                            <!-- Password-->
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                             <input type="password" id="pass" value="" class="input-xlarge" name="data[User][pass]" required="true">
                            </div>
                          </div>
                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                              <button class="btn btn-primary" onclick="return validate();">Create Account</button>
                            </div>
                          </div>
                        </fieldset>

                      </form>
                    </div>
                </div>
              </div>
            </div>
			</div>
			  <div id="ad_div" style="display:none;">
			  	<div class="container">
	<div><h2>Add New Advertise Details</h2></div>
	<div class="well">
		<div class="row">
			 <form class="form-horizontal" action="<?php echo HTTP_ROOT; ?>ads/add" method="post" enctype="multipart/form-data">
				<fieldset>
					<input type="hidden" name="data[Ad][dest_url]" id="dest_url" placeholder="http://www.example.com"  class="input-xlarge" value="" maxlength="512" size="512">
					<div class="control-group">
						<label class="control-label">Headline <b>:</b></label>
						<div class="controls">
							<input type="text" name="data[Ad][headline]" id="add_headline" placeholder=""  class="input-xlarge" required="true" maxlength="35" size="35" onfocus="headline_txt();">
							<!--<input type="hidden" name="data[Ad][hid_headline]" value="" id="hid_headline" />-->
							<span id="loader" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Updating Headline</span>
						    <div id="textbox_headline"></div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Text <b>:</b></label>
						<div class="controls">
							<textarea rows="3"  name="data[Ad][bodytext]" style="resize:none;width:270px;" required="true" id="testTextarea2"></textarea>
							<div id="removeCnt" style="width: 270px;margin-top:-19px;">104 Characters Left</div>
						</div>
					</div>
						 <input type="hidden" name="data[Ad][cpc]" id="cpc" value="0" class="input-xlarge" style="width:45px;">
						 <input type="hidden" name="data[Ad][cpa]" id="cpa" value="0"  class="input-xlarge" style="width:45px;">
					<div class="control-group">
						<label class="control-label">Tags <b>:</b></label>
						<div class="controls">
							<input type="text" name="data[Ad][alltags]" data-role="tagsinput" id="allTags"/>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Image <b>:</b></label>
						<div class="controls">
							<input type="file" name="data[Ad][uploadimage]" class="input-xlarge"/>
						</div>
					</div>
					<div class="form-actions">
						<button class="btn btn-primary" id="SaveButton">Submit</button>
						<button class="btn btn-primary" id="CancelButton" type="button" onclick="return homepage();">Cancel</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
			  </div>
        </div>	
	</div>
</div>