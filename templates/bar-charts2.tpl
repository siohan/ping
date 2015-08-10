<pre>{$datadonnees|var_dump}</pre>
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
<script class="include" type="text/javascript" src="modules/Ping/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.pointLabels.min.js"></script>

<script class="include" type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
{*<script type="text/javascript" src="modules/Ping/jqplot/example.min.js"></script>*}

<div id="chart4" style="height:300px; width:500px;"></div>

{literal}
<script class="code" type="text/javascript">
	$(document).ready(function(){
		var line1 = {/literal}{$datadonnees};{literal}
		
		
	 
	  var plot4 = $.jqplot('chart4', [line1], {
	      title: 'Stacked Bar Chart with Cumulative Point Labels', 
	      stackSeries: true, 
	      seriesDefaults: {
	          renderer: $.jqplot.BarRenderer,
	          rendererOptions:{barMargin: 25}, 
	          pointLabels:{show:true, stackedValue: true}
	      },
	      axes: {
	          xaxis:{renderer:$.jqplot.CategoryAxisRenderer}
	      }
	  });
	});
</script>
{/literal}


<!-- Don't touch this! -->


    

<!--
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="modules/Ping/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" hrf="modules/Ping/jqplot/jquery.jqplot.min.css" />
-->