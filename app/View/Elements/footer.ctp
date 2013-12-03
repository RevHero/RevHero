<script>
$(document).ready(function(){
	// scroll body to 0px on click
	$('#back-top a').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
});
</script>

<style>
	#footer {
		background-color: #F5F5F5;
	}
	.credit {
		margin: 20px 0;
	}
	.muted {
		color: #999999;
	}
</style>
<div id="footer">
  <div class="container">
  	<p class="pull-right credit" id="back-top"><a href="#top" style="outline:none;">Back to top</a></p>
	<p class="muted credit">Example courtesy <a href="<?php echo HTTP_ROOT; ?>">RevHero</a>.</p>
  </div>
</div>