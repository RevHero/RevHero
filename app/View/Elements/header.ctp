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
	<a class="brand" href="<?php echo HTTP_ROOT; ?>">RevHero123</a>
	<?php if($this->Session->read('Auth.User.id')){ ?>
	<ul class="nav pull-left">
		<li class="divider-vertical"></li>
		<li><a href="<?php echo HTTP_ROOT ?>ads/lists">Advertise</a></li>
		<li class="divider-vertical"></li>
		<!--<li><a href="#">Publish</a></li>
		<li class="divider-vertical"></li>-->
		<li><a href="<?php echo HTTP_ROOT ?>ads/store">Ad Store</a></li>
		<li class="divider-vertical"></li>
	</ul>

		<div class="nav-collapse">
		  <ul class="nav pull-right">
			<?php /*?><li style="font-family: 'Telex',sans-serif;padding: 16px 10px 14px;text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.2);color:#FFFFFF;">
				Welcome <?php //echo $this->Session->read('Auth.User.first_name'); ?>James
			</li><?php */?>
			<li>
				<?php if($this->Session->read('profile_image') != '' && file_exists(DIR_PROFILE_IMAGES.$this->Session->read('profile_image'))){ ?>
					<img src="<?php echo HTTP_FILES."profile_images/".$this->Session->read('profile_image'); ?>" class="img-circle img-polaroid" style="width:40px;height:40px;margin-top:2px;padding:2px;" >
				<?php }else{ ?>
					<img src="<?php echo HTTP_ROOT.'img/no_user.png'; ?>" class="img-circle img-polaroid" style="width:40px;height:40px;margin-top:2px;padding:2px;" >
				<?php } ?>
				<li class="dropdown">
				  <a data-toggle="dropdown" class="dropdown-toggle" href="#"><b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="<?php echo HTTP_ROOT; ?>users/profile">Profile</a></li>
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