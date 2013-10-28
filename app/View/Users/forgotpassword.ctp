<style>
h2 {
    color: #343D45;
    font-family: Verdana,Geneva,sans-serif;
    font-size: 22px;
    font-weight: normal;
    height: 35px;
    margin: 12px 40px 0 15px;
    text-align: center;
}
h6 {
    color: #343D45;
    font-family: Verdana,Geneva,sans-serif;
    font-size: 13px;
    font-weight: normal;
    line-height: 20px;
    margin: 10px 32px 10px;
    text-align: left;
}
</style>
<script language="javascript" type="text/jscript">
function closeBox()
{
	$("#displayMsg").hide();
}
</script>
<div class="container">
	<div class="row">
		<div class="span4"></div>
		<div class="span4" id="displayMsg">
		  <?php if(@$pass_success && @$pass_success == 1){ ?>
			  <div class="alert alert-success">
				<a class="close" onclick="closeBox();">x</a>
				<strong>Thank You.</strong> Please check your mail to reset your password.
			  </div>
		  <?php }else if(@$pass_success == 0 && @$pass_success != ''){ ?>  
			  <div class="alert alert-error">
				<a class="close" onclick="closeBox();">x</a>
				<strong>Sorry!!</strong> Email <?php echo $error_email_reset; ?> doesn't exists in our records!
			  </div>
		  <?php } ?>
		</div>
	</div>
</div>
<?php if(@$passemail=="10"){ ?>
<div class="container" style="width:442px;border:1px solid #CCCCCC;" id="ForgotPass">
	<div class="row">
		<form action="" method="post">
			<input type="hidden" name="data[User][newpass]" id="fornewpass" value="">
			<input type="hidden" name="data[User][repass]" id="forrepass" value="">
			<div><h2>Forgot your password?</h2></div>
			<div><h6>To reset your password, type the full email address you use to sign in to your RevHero Account.</h6></div>
            <fieldset>
                <input type="email" id="forgotemail" name="data[User][email]" class="input-block-level" placeholder="Email ID" style="width:429px;margin-left:26px;" required="true">
				<a href="<?php echo HTTP_ROOT; ?>" style="padding-top:5px;padding-right:8px;" class="pull-right">Cancel</a>
                <button type="submit" class="btn btn-warning pull-right" style="margin-right:7px;">Submit</button>
            </fieldset>
			<div><h6>(After submitting please click on the link sent to your email)</h6></div>
        </form>
	</div>
</div>
<?php } if(@$passemail=="12"){ ?>
	<div class="container" style="width:442px;border:1px solid #CCCCCC;<?php if(@$chkemail=="11"){?>display:none;<?php } ?>" id="ResetPass">
		<div class="row">
			<form action="" method="post">
			<input type="hidden" id="user_id" name="user_id" value="<?php if(isset($user_id)) { echo $user_id; } ?>" readonly="true">
				<div><h2>Reset your password</h2></div>
				<fieldset>
					<input type="password" id="resetpass" name="data[User][newpass]" class="input-block-level" placeholder="New Password" style="width:429px;margin-left:26px;" required="true">
					<input type="password" id="retypepass" name="data[User][repass]" class="input-block-level" placeholder="Re-type Password" style="width:429px;margin-left:26px;" required="true">
					<a href="<?php echo HTTP_ROOT; ?>" style="padding-top:5px;padding-right:8px;" class="pull-right">Cancel</a>
					<button type="submit" class="btn btn-warning pull-right" style="margin-right:7px;">Submit</button>
				</fieldset>
			</form>
		</div>
	</div>
<?php } ?>	

<?php if(@$chkemail=="11"){?>
	<div class="container" style="width:442px;border:1px solid #CCCCCC;" id="ThankForget">
		<div class="row">
			<div><h2 style="color:#379B37;font-size:18px;text-align:right;">Your Password is successfully changed.</h2></div>
			<div><h2 style="color:#000000;font-size:17px;text-align:center;margin-left:65px;"><a href="<?php echo HTTP_ROOT; ?>" style="color:blue;text-decoration:underline;">Login</a> with your new pasword</h2></div>
		</div>
	</div>
<?php }?>
