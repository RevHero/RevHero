<script language="javascript" type="text/javascript">

function closeBox()
{
	$("#displayMsg").hide();
}

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
                <h3>Have an Account?</h3>
              </div>
              <div class="modal-body" style="overflow:visible">
                <div class="well">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#login" data-toggle="tab">Create Account</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="login">
                      <form class="form-horizontal" id="tab" action="" name="registration" method="post">
					  	<input type="hidden" name="data[User][hid_promocode_id]" id="hid_promocode_id" value="<?php echo $promocodeId; ?>">
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
                            <!-- Promo Code-->
                            <label class="control-label" for="password">Promo Code</label>
                            <div class="controls">
                             <input type="text" class="input-xlarge" name="data[User][promo]" value="<?php echo $displaypromo; ?>" readonly="readonly">
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
        </div>
	</div>
</div>