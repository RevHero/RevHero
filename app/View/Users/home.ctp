<script language="javascript" type="text/javascript">

function validate()
{
	var emailRegEx = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	var letter     = /^[a-zA-Z]+$/;
	
	var fname = $("#fname").val().trim();
	var lname = $("#lname").val().trim();
	var email = $("#emailaddress").val().trim();
	var password = $("#userpassword").val().trim();
	var confirm_password = $("#userconpassword").val().trim();
	
	if(fname == ''){
		$("#err_fname").html("Please enter first name.");
		$("#err_fname").show();
		$("#fname").focus();
		return false;
	}else if(!fname.match(letter)){
		$("#err_fname").html("Please enter only text.");
		$("#err_fname").show();
		$("#fname").focus();
		return false;
	}else{
		$("#err_fname").hide();
	}
	
	if(lname == ''){
		$("#err_lname").html("Please enter last name.");
		$("#err_lname").show();
		$("#lname").focus();
		return false;
	}else if(!lname.match(letter)){
		$("#err_lname").html("Please enter only text.");
		$("#err_lname").show();
		$("#lname").focus();
		return false;
	}else{
		$("#err_lname").hide();
	}
	
	if(email == ''){
		$("#err_email").html("Please enter your email.");
		$("#err_email").show();
		$("#emailaddress").focus();
		return false;
	}else if(!email.match(emailRegEx)){
		$("#err_email").html("Please enter valid email.");
		$("#err_email").show();
		$("#emailaddress").focus();
		return false;
	}else{
		$("#err_email").hide();
	}
	
	if(password == ''){
		$("#err_pwd").html("Please enter a password.");
		$("#err_pwd").show();
		$("#userpassword").focus()
		return false;
	}else{
		$("#err_pwd").hide();
	}
	
	if(confirm_password == ''){
		$("#err_conpwd").html("Please enter confirm password.");
		$("#err_conpwd").show();
		$("#userconpassword").focus();
		return false;
	}else if(password != confirm_password){
		$("#err_conpwd").html("Your password and confirm password donot match.");
		$("#err_conpwd").show();
		$("#userconpassword").focus();
		return false;
	}else{
		$("#err_conpwd").hide();
	}
}

/*function closeBox()
{
	$("#displayMsg").hide();
}*/
</script>
<div class="container">
	<div class="row">
		<?php /*?><div class="span4"></div>
		<div class="span4" id="displayMsg">
		  <?php echo @$msgDisplay; ?>
		</div><?php */?>
        <div class="span12">
    		<div class="" id="loginModal">
              <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>-->
                <h3>Have an Account?</h3>
              </div>
              <div class="modal-body" style="overflow:visible">
                <div class="well">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                    <li><a href="#create" data-toggle="tab">Create Account</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="login">
                      <form class="form-horizontal" action='' method="POST">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Login</legend>
                          </div>    
                          <div class="control-group">
                            <!-- Username -->
                            <label class="control-label"  for="username">Email</label>
                            <div class="controls">
                              <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
                            </div>
                          </div>
     
                          <div class="control-group">
                            <!-- Password-->
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                              <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                            </div>
                          </div>
                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                              <button class="btn btn-success">Login</button>
                            </div>
                          </div>
                        </fieldset>
                      </form>                
                    </div>
                    <div class="tab-pane fade" id="create">
                      <form id="tab" action="" name="registration" method="post">
					  	<input type="hidden" name="data[User][registration]" value="1" />
                        <!--<label>Username</label>
                        <input type="text" value="" class="input-xlarge">-->
                        <label>First Name<span style="color: #FF0000;font-size: 15px;font-weight: bold;padding-left: 5px;vertical-align: text-top;">*</span></label>
                        <input type="text" value="" class="input-xlarge" name="data[User][fname]" id="fname">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_fname"></span>
                        <label>Last Name<span style="color: #FF0000;font-size: 15px;font-weight: bold;padding-left: 5px;vertical-align: text-top;">*</span></label>
                        <input type="text" value="" class="input-xlarge" name="data[User][lname]" id="lname">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_lname"></span>
                        <label>Email<span style="color: #FF0000;font-size: 15px;font-weight: bold;padding-left: 5px;vertical-align: text-top;">*</span></label>
                        <input type="text" value="" class="input-xlarge" name="data[User][email]" id="emailaddress">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_email"></span>
						<label>Password<span style="color: #FF0000;font-size: 15px;font-weight: bold;padding-left: 5px;vertical-align: text-top;">*</span></label>
                        <input type="password" value="" class="input-xlarge" name="data[User][pass]" id="userpassword">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_pwd"></span>
						<label>Confirm Password<span style="color: #FF0000;font-size: 15px;font-weight: bold;padding-left: 5px;vertical-align: text-top;">*</span></label>
                        <input type="password" value="" class="input-xlarge" name="data[User][conpass]" id="userconpassword">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_conpwd"></span>
                        <!--<label>Address</label>
                        <textarea value="Smith" rows="3" class="input-xlarge"></textarea>-->
                        <div>
                          <button class="btn btn-primary" onclick="return validate();">Create Account</button>
                        </div>
                      </form>
                    </div>
                </div>
              </div>
            </div>
        </div>
	</div>
</div>