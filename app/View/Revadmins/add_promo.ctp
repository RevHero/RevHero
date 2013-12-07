<script language="javascript" type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH.'bootstrap-datepicker.css';?>"/>
<script language="javascript" type="text/javascript">
$(document).ready(function()
{
	var today = new Date();
	var currentYear  = today.getFullYear();
	var currentMonth = (today.getMonth()+1);
	var currentDay   = today.getDate();
	var startdate = currentYear+"-"+currentMonth+"-"+currentDay;
	
	$('#validFrom').datepicker({
		autoclose: true,
        startDate: startdate
	});
	
	$('#validTo').datepicker({
		autoclose: true,
        startDate: startdate
	});
	
	
	$('#validTo').datepicker()
    .on('changeDate', function(ev){
		
		var startingdate = $('#datepickerFrom').val().trim();
		var endingdate   = $('#datepickerTo').val().trim();

		if(endingdate < startingdate){
			alert("The valid to can not be less than the valid from");
			$("#hid_is_less").val(1);
		}else{
			$("#hid_is_less").val(0);
		}
    });
	
	$("#pcode").change(function()
	{
		var strURL = $('#pageurl').val();
		var pcode = $("#pcode").val().trim();
		
		$("#promoloader").show();
		$("#sbtbtn").hide();
		$("#notavail").hide();
		$("#avail").hide();
		$.post(strURL+"revadmins/promo_code_exists",{pcode:pcode},function(data){
			//alert(JSON.stringify(data, null, 4));
			$("#promoloader").hide();
			$("#sbtbtn").show();
			if(data.status == 1){
				$("#notavail").show();
				$("#avail").hide();
				$("#notavail").html('Promocode already exists.');
				$("#hid_is_keyword_exist").val(1);
			}else if(data.status == 0){
				$("#notavail").hide();
				$("#avail").show();
				$("#avail").html('Promocode Available.');
				$("#hid_is_keyword_exist").val(0);
			}
		},'json');
	});
	
	$("#pcodeform").submit(function(event){
	  var iskeyword  = $("#hid_is_keyword_exist").val().trim();
	  var pcode      = $("#pcode").val().trim();
	  var amount     = $("#creditamount").val().trim();
	  var rexp = /^[0-9.]+$/;
	  
	  var startingdate = $('#datepickerFrom').val().trim();
	  var endingdate   = $('#datepickerTo').val().trim();
	
	  if(pcode == ''){
	  	 alert("Please enter promo code.");
		 return false;
	  }
	  
	  if(amount == ''){
	  	 alert("Please enter credit amount.");
		 return false;
	  }else if(!rexp.test(amount)){
		 alert("Please enter only integer for credit amount.");
		 return false;
	  }
	  
	  if(endingdate < startingdate){
		  alert("The valid to can not be less than the valid from");
		  $("#hid_is_less").val(1);
		  return false;
	  }else{
		  $("#hid_is_less").val(0);
	  }
	  
	  var isendDateLess = $("#hid_is_less").val();
	  
	  if((iskeyword == '0' || iskeyword == '') && isendDateLess == '0'){
	  	  return true;
	  }else{
		  alert("Please change promo code.");
		  return false;
	  }	
	  
	});
		
});
</script>
<div class="container">
	<div class="row-fluid">
      <form class="form-horizontal" action="" method="post" id="pcodeform">
	  <input type="hidden" name="hid_is_keyword_exist" id="hid_is_keyword_exist" value="" />
	  <input type="hidden" name="hid_is_less" id="hid_is_less" value="" />
        <fieldset>
          <div id="legend">
            <legend class="">Promotional Code</legend>
          </div>
          <div class="control-group">
            <label class="control-label"  for="username">Code</label>
            <div class="controls">
              <input type="text" id="pcode" name="pcode" placeholder="" class="input-xlarge">
			  <span id="promoloader" style="margin-left:5px;display:none;"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" /> Getting Availibility</span>
			  <span style="color:#006600;margin-left:10px;" id="avail"></span>
			  <span style="color:#FF0000;margin-left:10px;" id="notavail"></span>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="email">Credit Amount</label>
            <div class="controls">
              <!--$ <input type="text" id="amount" name="amount" placeholder="" class="input-xlarge" style="width:258px;">-->
			  <div class="input-prepend input-append">
				  <span class="add-on">$</span>
				  <input class="span9" type="text" id="creditamount" name="amount">
			  </div>
			</div>
          </div>
		  <div class="control-group">
            <label class="control-label" for="email">Valid From</label>
            <div class="controls">
   			  <div class="input-append date" id="validFrom" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
			  	<input type="text" id="datepickerFrom" name="datepickerFrom" class="input-xlarge" style="width:243px;" value="<?php echo date('Y-m-d'); ?>">
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>
            </div>
          </div>
		   <div class="control-group">
            <label class="control-label" for="email">Valid To</label>
            <div class="controls">
   			  <div class="input-append date" id="validTo" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd">
			  	<input type="text" id="datepickerTo" name="datepickerTo" class="input-xlarge" style="width:243px;" value="<?php echo date('Y-m-d'); ?>">
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>
            </div>
          </div>
          <!-- Submit -->
          <div class="control-group">
            <div class="controls">
              <button class="btn btn-success" id="sbtbtn">Submit</button>
            </div>
          </div>
     
        </fieldset>
      </form>
    </div>
</div>