<script type="text/javascript" src="<?php echo JS_PATH; ?>highcharts.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>exporting.js"></script>
<script type="text/javascript">
var dt = <?php echo $dt_arr;?>;
var ydata = <?php echo $all_clicks;?>;
$(function () { 
    $('#chartPlace').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Date'
        },
        xAxis: {
			type:'datetime',
			categories: eval(dt),
			showFirstLabel:true,
			showLastLabel:true
        },
        yAxis: {
			min:0,
			allowDecimals:false,
			title: {
				text: 'Click Count'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#FF0000'
			}]
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					this.x +': '+ this.y +'';
			}
		},
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
/*        series: [{
            name: 'Jane',
            data: [1, 3, 4, 5, 8]
        }]*/
		series: eval(ydata)
    });
});
</script>
<div class="container well">
  <div>
  	<h3><?php echo substr($getDetails['AdDetail']['headline'],0,35); ?></h3>
  </div>
  <div class="row">
    <div class="span1.5">
	  <?php if($getDetails['AdDetail']['ad_image']){ ?>
	      <img src="<?php echo HTTP_FILES."ad_photos/".$getDetails['AdDetail']['ad_image']; ?>"  alt="<?php echo substr($getDetails['AdDetail']['headline'],0,35); ?>" class="img-rounded" style="max-width:100px;max-height:110px;">
	  <?php }else{ ?>
    	  <img src="<?php echo HTTP_IMAGES."no_image.gif"; ?>"  alt="<?php echo substr($getDetails['AdDetail']['headline'],0,35); ?>" class="img-rounded" style="max-width:100px;max-height:110px;">
	  <?php } ?>
    </div>
    <div class="span5">
      <p class="displayDetails" style="font-size:14px;">
        <i class="icon-globe"></i> <a href="<?php echo $getDetails['AdDetail']['dest_url']; ?>" style="outline:none;" target="_blank"><?php echo $getDetails['AdDetail']['dest_url']; ?></a><br />
        <p class="displayDetails"><b>Placement Created:</b> <?php echo date("F j, Y", strtotime($getDetails['Placement']['created'])); ?></p>
		<p class="displayDetails">
			<b>Type:</b>
			<?php
				if($getDetails['Placement']['type'] == 'html'){
					echo "HTML";
				}else{
					echo "TEXT";
				}	
			?> &nbsp;<strong>|</strong>&nbsp;
			<b>Format:</b>
			<?php
				if($getDetails['Placement']['format'] == '3'){
					echo "3 Line Format";
				}else{
					echo "1 Line Format";
				}	
			?>
		</p>
		<div class="pull-left" style="color:#232323;font-size:11px;font-weight:bold;">
			<?php
				if(count($getDetails['AdClick']) > 0){
					if(count($getDetails['AdClick']) == 1){
						echo "1 Click";
					}else{
						echo count($getDetails['AdClick'])." Clicks";
					}	
				}else{
					echo "0 Click";
				}
			?> 
	   </div>
	   <div class="input-append pull-right">
		<input class="span4 shorturl" id="box-content" type="text" readonly="readonly" value="<?php echo $getDetails['Placement']['short_url']; ?>" style="height:16px;">
	   </div>
      </p>
    </div>
  </div>
</div>
<?php
$arrDt = json_decode($dt_arr,true);
$arrClick = json_decode($all_clicks,true);

if(count($arrDt > 0) && count($arrClick[0]['data']) > 0){ ?>
	<div class="container well">
		<div class="row">
			<div id="chartPlace" style="width:100%;height:400px;margin-left:10px;"></div>
		</div>
	</div>
<?php } ?>	