<input type="hidden" name="pageurl" id="pageurl" value="<?php echo HTTP_ROOT; ?>" size="1" readonly="true"/>
<input type="hidden" name="pagename" id="pagename" value="<?php echo PAGE_NAME; ?>" size="1" readonly="true"/>
<!-- This is the design for the HEADER navigation bar -->
<div class="navbar">
<div class="navbar-inner">
  <div class="container" style="width: auto;">
	<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	</a>
	<a class="brand" href="<?php echo HTTP_ROOT."revadmins"; ?>">RevHero</a>
	<?php if($this->Session->read('Auth.User.id')){ ?>
		<div class="nav-collapse">
		  <ul class="nav pull-right">
			<li>
				<img src="<?php echo HTTP_ROOT; ?>img/no_user.png" class="img-circle img-polaroid" style="width:25px;height:25px;margin-top:8px;" >
				<li class="dropdown">
				  <a data-toggle="dropdown" class="dropdown-toggle" href="#"><b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="#">Profile</a></li>
					<li><a href="#">Settings</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo HTTP_ROOT ?>users/logout">Logout</a></li>
				  </ul>
				</li>
			</li>
		  </ul>
		</div><!-- /.nav-collapse -->
	<?php } ?>	
  </div>
</div><!-- /navbar-inner -->
</div>