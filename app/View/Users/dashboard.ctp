<script language="javascript" type="text/javascript">
function closeBox()
{
	$("#displayMsg").hide();
}
</script>
<div class="span6"></div>
<div class="span4" id="displayMsg">
<?php if(@$successaddsave && @$successaddsave == 1){ ?>
  <div class="alert alert-success">
	<a class="close" onclick="closeBox();">x</a>
	<strong>Thank You.</strong> You have created advertise successfully.
  </div>
<?php }else if(@$successaddsave == 0 && @$successaddsave != ''){ ?>  
  <div class="alert alert-error">
	<a class="close" onclick="closeBox();">x</a>
	<strong>Sorry!!</strong> Advertise did not save.
  </div>
<?php } ?>  
</div>

<div class="container">
	<div class="row">
        <div class="span16">
          <h5><i class="icon icon-globe"></i> Dashboard </h5>
          <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
        </div>
	</div>
</div>