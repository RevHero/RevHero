<?php if(isset($anonymousads)){  ?>
<div class="container well">
<?php if(!isset($home)){ ?>
	<div class="row">
		<div class="span1.5">
			<h4>Create Ad Placement</h4>
		</div>
	</div>
<?php } ?>
	<div class="row">
		<form class="form-horizontal" method="post" onsubmit="return false;">
			<input type="hidden" name="hid_ad_id" id="hid_ad_id" value="<?php echo $anonymousads[0]['AdDetail']['id']; ?>" />
			<input type="hidden" name="hid_publisher_id" id="hid_publisher_id" value="<?php if($this->Session->read('Auth.User.id')) { echo $this->Session->read('Auth.User.id'); }else{ echo 0; }?>" />
			<input type="hidden" name="hid_is_keyword_exist" id="hid_is_keyword_exist" value="" />
			<input type="hidden" name="hid_headline" id="hid_headline" value="<?php echo substr($anonymousads[0]['AdDetail']['headline'],0,35); ?>" />
			<input type="hidden" name="hid_body" id="hid_body" value="<?php echo substr($anonymousads[0]['AdDetail']['body'],0,104); ?>" />
			<input type="hidden" name="hid_destination_url" id="hid_destination_url" value="<?php echo $anonymousads[0]['AdDetail']['dest_url']; ?>" />
			<div <?php if(isset($home)){ ?>style="display:none;" <?php } ?> >
			<div class="control-group">
				<label class="control-label" for="inputKeyword">Custom Keyword</label>
				<div class="controls">
					<input type="text" id="customKeyword" placeholder="Custom Keyword">
					<span id="loader1" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Getting Availability</span>
					<span style="color:#006600;margin-left:10px;" id="avail"></span>
					<span style="color:#FF0000;margin-left:10px;" id="notavail"></span>
				</div>
			</div>
			</div>
			<?php if(isset($home)){ ?>
			<div class="control-group span12">
				<div class="span1">Type</div>
				<div class="controls span2" style="margin-left:2px;">
					<input type="radio" name="adType" id="adType1" value="html"> <span style="vertical-align:text-top">HTML</span>&nbsp;
					<input type="radio" name="adType" id="adType2" value="text" checked="checked"> <span style="vertical-align:text-top">Text</span>
				</div>
				<div class="span1">Format</div>
				<div class="controls span3" style="margin-left:5px;">
					<input type="radio" name="adFormat" id="adType1" value="1" checked="checked"> <span style="vertical-align:text-top">One Line</span>&nbsp;
					<input type="radio" name="adFormat" id="adType2" value="3"> <span style="vertical-align:text-top">Three Line</span>
				</div>
				<div class="span2">
					<button class="btn btn-primary" id="publishBtn">Publish</button>
					<span id="mainloader" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Creating Ad Placement</span>
				</div>
				
			</div>
			<?php } ?>
			<?php if(!isset($home)){ ?>
			<div class="control-group">
				<label class="control-label" for="inputAdType">Type</label>
				<div class="controls">
					<input type="radio" name="adType" id="adType1" value="html"> <span style="vertical-align:text-top">HTML</span>&nbsp;
					<input type="radio" name="adType" id="adType2" value="text" checked="checked"> <span style="vertical-align:text-top">Text</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputFormat">Format</label>
				<div class="controls">
					<input type="radio" name="adFormat" id="adType1" value="1" checked="checked"> <span style="vertical-align:text-top">One Line</span>&nbsp;
					<input type="radio" name="adFormat" id="adType2" value="3"> <span style="vertical-align:text-top">Three Line</span>
				</div>
			</div>
			<?php } ?>
		</form>
	</div>
	<?php if(!isset($home)){ ?>
	<div>
	   <button class="btn btn-primary" id="publishBtn">Publish</button>
	   <span id="mainloader" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Creating Ad Placement</span>
    </div>
	<?php } ?>
	<?php if(isset($home)){ ?>
		<div class="span11" id="placementcontainer" style="display:none;">
		  <h4>Copy the below content to display in your website.</h4>
		  <p id="placementShow"></p>
		</div>
	<?php } ?>
</div>
<?php if(!isset($home)){ ?>
<div class="container well" id="placementcontainer" style="display:none;">
	<div class="row">
		<div class="span1"></div>
		<div class="span11">
		  <h4>Copy the below content to display in your website.</h4>
		  <p id="placementShow"></p>
		</div>
	</div>
</div>
<?php } ?>

<script type="text/javascript">
var placeARR = new Array();

function getCookie(c_name)
{
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1)
    {
  		c_start = c_value.indexOf(c_name + "=");
    }
	if (c_start == -1)
    {
  		c_value = null;
    }
	else
    {
  		c_start = c_value.indexOf("=", c_start) + 1;
  		var c_end = c_value.indexOf(";", c_start);
  		if (c_end == -1)
  		{
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
}
$(document).ready(function(){
	$("#publishBtn").click(function()
	{
		var strURL = $('#pageurl').val();
		var customKeyword = $("#customKeyword").val().trim();
		var adType        = $('input:radio[name=adType]:checked').val();
		var adFormat      = $('input:radio[name=adFormat]:checked').val();
		var adversiteId   = $("#hid_ad_id").val().trim();
		var publisherId   = $("#hid_publisher_id").val().trim();
		var iskeyword     = $("#hid_is_keyword_exist").val().trim();
		var DisplayContent = '';
		
		var hid_headline        = $("#hid_headline").val();
		var hid_body            = $("#hid_body").val();
		var hid_destination_url = $("#hid_destination_url").val();
		
		if(iskeyword == '0' || iskeyword == ''){
			$("#mainloader").show();
			$("#publishBtn").hide();
			$.post(strURL+"ads/savePlacements",{strURL:strURL,customKeyword:customKeyword,adType:adType,adFormat:adFormat,adversiteId:adversiteId,publisherId:publisherId},function(data){
				//alert(JSON.stringify(data, null, 4));
				$("#mainloader").hide();
				$("#publishBtn").show();
				$("#customKeyword").val('');
				$("#notavail").hide();
				$("#avail").hide();
				if(data.status == 1){
					
					var cookieName = 'publish_placement';
					var today = new Date();
					var expire = new Date();
					var nDays=1;
					
					if(!getCookie('publish_placement'))
					{
						placeARR[0] = data.placementId;
						expire.setTime(today.getTime() + 3600000*24*nDays);
					}
					else
					{
						placeARR = getCookie('publish_placement').split(",");
						var keyValue = placeARR.length;
						placeARR[keyValue] = data.placementId;
						expire.setTime(today.getTime() + 3600000*24*nDays);
					}	
					
					document.cookie = cookieName+"="+escape(placeARR)+ ";expires="+expire.toGMTString()+";path=/";
					
					if(adType == 'text' && adFormat == '1'){
						//DisplayContent = hid_headline+' - '+hid_body+' - '+hid_destination_url;
						DisplayContent = hid_headline+' - '+hid_body+' - '+strURL+data.customKeyword;
						$("#placementcontainer").show();
						$("#placementShow").html(DisplayContent);
						$('html, body').animate({scrollTop: $(window).scrollTop() + $(window).height()}, 1000);
					}else if(adType == 'html' && adFormat == '1'){
						//DisplayContent = '&lt;a href="'+hid_destination_url+'" target="_blank">'+hid_headline+'&lt;/a&gt; - '+hid_body;
						DisplayContent = '&lt;a href="'+strURL+data.customKeyword+'" target="_blank">'+hid_headline+'&lt;/a&gt; - '+hid_body;
						$("#placementcontainer").show();
						$("#placementShow").html(DisplayContent);
						$('html, body').animate({scrollTop: $(window).scrollTop() + $(window).height()}, 1000);
					}else if(adType == 'text' && adFormat == '3'){
						//DisplayContent = hid_headline+'<br>'+hid_destination_url+'<br>'+hid_body;
						DisplayContent = hid_headline+'<br>'+strURL+data.customKeyword+'<br>'+hid_body;
						$("#placementcontainer").show();
						$("#placementShow").html(DisplayContent);
						$('html, body').animate({scrollTop: $(window).scrollTop() + $(window).height()}, 1000);
					}else if(adType == 'html' && adFormat == '3'){
						//DisplayContent = '&lt;a href="'+hid_destination_url+'" target="_blank"&gt;'+hid_headline+'&lt;/a&gt;&lt;br&gt;&lt;a href="'+hid_destination_url+'" target="_blank"&gt;'+hid_destination_url+'&lt;/a&gt;&lt;br&gt;'+hid_body;
						DisplayContent = '&lt;a href="'+strURL+data.customKeyword+'" target="_blank"&gt;'+hid_headline+'&lt;/a&gt;&lt;br&gt;&lt;a href="'+strURL+data.customKeyword+'" target="_blank"&gt;'+strURL+data.customKeyword+'&lt;/a&gt;&lt;br&gt;'+hid_body;
						$("#placementcontainer").show();
						$("#placementShow").html(DisplayContent);
						$('html, body').animate({scrollTop: $(window).scrollTop() + $(window).height()}, 1000);
					}
				}else{
					$("#placementcontainer").hide();
					$("#placementShow").html('');
				}
				
			},'json');
		}else{
			alert("Please change custom keyword.");
			return false;
		}	
	});

});
</script>
<?php } ?>