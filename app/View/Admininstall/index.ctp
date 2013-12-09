<style>
 .center{
 	text-align: center;
	margin-left: auto;
	margin-right: auto;
	margin-bottom: auto;
	margin-top: auto;
}
</style>
<?php
if(isset($AdminReg) && $AdminReg == 1)
{
?>
<div class="container">
  <div class="row">
    <div class="span12">
      <div class="hero-unit center">
          <h2>Admin Record already exist!</h2>
		  <p>Please login with the admin credentials.</p>
          <a href="<?php echo HTTP_ROOT; ?>" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take Me Home</a>
        </div>
    </div>
  </div>
</div>

<?php
}
else
{
?>
	<div class="container">
	<div class="row">
		 <form class="form-horizontal" method="post" action="">
            <fieldset>
                <!-- Address form -->
         
               <h2>Admin Setup Credentials</h2><br/>
         
                <!-- email input-->
                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <input id="email" name="email" type="email" placeholder="Email" class="input-xlarge" required="true">
                        <p class="help-block"></p>
                    </div>
                </div>
                <!-- password input-->
                <div class="control-group">
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <input id="pass" name="pass" type="password" placeholder="Password" class="input-xlarge" required="true">
                        <p class="help-block"></p>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <button class="btn btn-primary">SUBMIT</button>
                    </div>
                </div>
				
            </fieldset>
        </form>
	</div>
</div>
<?php
}
?>