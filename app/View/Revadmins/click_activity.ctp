<script language="javascript" type="text/javascript">
var countryData = <?php echo $distinctCountry; ?>;
</script>
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type='text/javascript'>
 google.load('visualization', '1', {'packages': ['geochart']});
 google.setOnLoadCallback(drawRegionsMap);

function drawRegionsMap() {
	var data = new google.visualization.DataTable(); 
	
	data.addRows(countryData.length); 
	
	data.addColumn('string', 'Country'); 
	data.addColumn('number', 'Click'); 
	
	for(var i=0; i<countryData.length; i++)
	{
		var country_name = countryData[i]['ad_clicks']['Country'];
		var country_code = countryData[i]['ad_clicks']['CountryCode'];
		var click_count  = countryData[i][0]['total_count'];
		
		data.setValue(i, 0, country_name);
    	data.setValue(i, 1, parseInt(click_count));
	}
	var options = {colorAxis: {colors: ['green', 'blue']}};

	var map= document.getElementById('chart_div') 
	var chart = new google.visualization.GeoChart(map); 
	
	google.visualization.events.addListener(chart, 'regionClick', function(eventData){
		getCities(eventData.region);
	});
	
	chart.draw(data, options);
}

function getCities(requireRegion)
{
	var strURL = $('#pageurl').val();
	$.post(strURL+"revadmins/getAllCities",{country_code:requireRegion},function(cityData){
		//alert(JSON.stringify(cityData, null, 4));
		
		var data = new google.visualization.DataTable(); 
		data.addRows(cityData.length); 
		
		data.addColumn('string', 'City'); 
		data.addColumn('number', 'Click'); 
		
		for(var i=0; i<cityData.length; i++)
		{
			var city_name = cityData[i]['ad_clicks']['City'];
			var click_count  = cityData[i][0]['total_count'];
			
			data.setValue(i, 0, city_name);
			data.setValue(i, 1, parseInt(click_count));
		}
		
		var options = {
			region: requireRegion,
			displayMode: 'markers',
			colorAxis: {colors: ['green', 'blue']}
		};
	
		var map= document.getElementById('chart_div') 
		var chart = new google.visualization.GeoChart(map); 
	
		chart.draw(data, options);
		
	},'json');
}

</script>
<div class="container">
	<div class="row">
		<h2>Total Click Activity</h2>
	</div>
</div><br/>
<div class="container well">
	<div class="row">
		<div id="chart_div" style="width:100%; height: 500px;margin-left:10px;"></div>
	</div>
</div>