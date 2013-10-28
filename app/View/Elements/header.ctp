<!-- This is the design for the HEADER navigation bar -->
<div class="navbar">
<div class="navbar-inner">
  <div class="container" style="width: auto;">
	<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	</a>
	<a class="brand" href="<?php echo HTTP_ROOT; ?>">RevHero</a>
	<?php if(@$loginstatus && @$loginstatus == 1){ ?>
		<div class="nav-collapse">
		  <ul class="nav pull-right">
			<li class="divider-vertical"></li>
			<li><a href="#">Advertise</a></li>
			<li class="divider-vertical"></li>
			<li><a href="#">Publish</a></li>
			<li class="divider-vertical"></li>
			<li style="font-family: 'Telex',sans-serif;padding: 16px 10px 14px;text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.2);color:#FFFFFF;">Welcome Sandeep</li>
			<li>
				<img src="<?php echo HTTP_ROOT; ?>img/no_user.png" class="img-circle img-polaroid" style="width:25px;height:25px;margin-top:8px;" >
				<li class="dropdown">
				  <a data-toggle="dropdown" class="dropdown-toggle" href="#"><b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="#">Profile</a></li>
					<li><a href="#">Settings</a></li>
					<li class="divider"></li>
					<li><a href="logout">Logout</a></li>
				  </ul>
				</li>
			</li>
		  </ul>
		</div><!-- /.nav-collapse -->
	<?php } ?>	
  </div>
</div><!-- /navbar-inner -->
</div>