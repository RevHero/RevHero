<script language="javascript" type="text/javascript">

/*function validate()
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
	}else if(password.length < 6){
		$("#err_pwd").html("Password should be greater than or equal to 6 characters..");
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
}*/

function closeBox()
{
	$("#displayMsg").hide();
}

/*function validateLogin()
{
	var emailRegEx = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	
	var email = $("#loginemail").val().trim();
	var password = $("#loginpassword").val().trim();
	
	if(email == ''){
		$("#err_log_email").html("Please enter your email.");
		$("#err_log_email").show();
		$("#loginemail").focus();
		return false;
	}else if(!email.match(emailRegEx)){
		$("#err_log_email").html("Please enter valid email.");
		$("#err_log_email").show();
		$("#loginemail").focus();
		return false;
	}else{
		$("#err_log_email").hide();
	}
	
	if(password == ''){
		$("#err_log_pass").html("Please enter a password.");
		$("#err_log_pass").show();
		$("#loginpassword").focus()
		return false;
	}else{
		$("#err_log_pass").hide();
	}
}*/

</script>
<div class="container">
	<div class="row">
		<div class="span4"></div>
		<div class="span4" id="displayMsg">
		  <?php if(@$success && @$success == 1){ ?>
			  <div class="alert alert-success">
				<a class="close" onclick="closeBox();">x</a>
				<strong>Thank You.</strong> A confirmation email has been sent to your email.
			  </div>
		  <?php }else if(@$success == 0 && @$success != ''){ ?>  
			  <div class="alert alert-error">
				<a class="close" onclick="closeBox();">x</a>
				<strong>Sorry!!</strong> This email id is already registered.
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
                <h3>Have an Account?</h3>
              </div>
              <div class="modal-body" style="overflow:visible">
                <div class="well">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                    <li><a href="#create" data-toggle="tab">Create Account</a></li>
<!--					<span class="pull-right" style="font-weight:bold;"><span style="color: #FF0000;font-size: 15px;font-weight: bold;padding-right: 5px;padding-left: 5px;vertical-align: text-top;">*</span>Required Fields</span>-->
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="login">
                      <form class="form-horizontal" action='users/login' method="POST">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Login</legend>
                          </div>    
                          <div class="control-group">
                            <!-- Username -->
                            <label class="control-label"  for="username">Email</label>
                            <div class="controls">
                              <input type="email" name="email" placeholder="" class="input-xlarge" required="true">
							  <span style="color:#BD4247;display:;" class="help-inline" id="err_log_email"><?php echo @$ErrorMsgEmail; ?></span>
                            </div>
                          </div>
     
                          <div class="control-group">
                            <!-- Password-->
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                              <input type="password" name="password" placeholder="" class="input-xlarge" required="true">
							  <span style="color:#BD4247;display:;" class="help-inline" id="err_log_pass"></span>
                            </div>
                          </div>
                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                              <button class="btn btn-success" onclick="return validateLogin();">Login</button>
							  <span style="margin-left:110px;color:#317EAC;"><a href="<?php echo HTTP_ROOT; ?>users/forgotpassword">Forgot Password?</a></span>
                            </div>
                          </div>
                        </fieldset>
                      </form>                
                    </div>
                    <div class="tab-pane fade" id="create">
                      <form id="tab" action="" name="registration" method="post">
					  	<input type="hidden" name="data[User][registration]" value="1" />
                        <label>First Name</label>
                        <input type="text" value="" class="input-xlarge" name="data[User][fname]" required="true">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_fname"></span>
                        <label>Last Name</label>
                        <input type="text" value="" class="input-xlarge" name="data[User][lname]" required="true">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_lname"></span>
                        <label>Email</label>
                        <input type="email" value="" class="input-xlarge" name="data[User][email]" required="true">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_email"></span>
						<label>Password</label>
                        <input type="password" value="" class="input-xlarge" name="data[User][pass]" required="true">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_pwd"></span>
						<label>Confirm Password</label>
                        <input type="password" value="" class="input-xlarge" name="data[User][conpass]" required="true">
						<span style="padding-bottom:10px;color:#BD4247;display:none;" class="help-inline" id="err_conpwd"></span>
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