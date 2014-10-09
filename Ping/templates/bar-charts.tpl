<script class="include" type="text/javascript" src="modules/Ping/jqplot/jqplot.barRenderer.min.js"></script>
<script class="include" type="text/javascript" src="modules/Ping/jqplot/jqplot.categoryAxisRenderer.min.js"></script>
<script class="include" type="text/javascript" src="modules/Ping/jqplot/jqplot.pointLabels.min.js"></script>


{literal}
<script class="code" type="text/javascript">
$(document).ready(function(){
    var s1 = [200, 600, 700, 1000];
    var s2 = [460, -210, 690, 820];
    var s3 = [-260, -440, 320, 200];
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
    var ticks = [{/literal}'{$mai}'{literal}, 'June', 'July', 'August'];
    
    var plot1 = $.jqplot('chart1', [s1, s2, s3], {
        // The "seriesDefaults" option is an options object that will
        // be applied to all series in the chart.
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true}
        },
        // Custom labels for the series are specified with the "label"
        // option on the series option.  Here a series option object
        // is specified for each series.
        series:[
            {label:'hotel'},
            {label:'Event Regristration'},
            {label:'Airfare'}
        ],
        // Show the legend and put it outside the grid, but inside the
        // plot container, shrinking the grid to accomodate the legend.
        // A value of "outside" would not shrink the grid and allow
        // the legend to overflow the container.
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axes: {
            // Use a category axis on the x axis and use our custom ticks.
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },
            // Pad the y axis just a little so bars can get close to, but
            // not touch, the grid boundaries.  1.2 is the default padding.
            yaxis: {
                pad: 1.05,
                tickOptions: {formatString: '$%d'}
            }
        }
    });
});
  </script>
{/literal}
 <p class="text include">
{$mai} - Charts on this page may depend on the following plugins:
</p>

<div class="code prettyprint include">
<pre class="include prettyprint brush: html gutter: false"></pre>
</div>        
    <div id="chart1" style="width:600px; height:250px;"></div>
<div class="code prettyprint">
    <pre class="code prettyprint brush: js"></pre>
</div>
    <div id="chart2" style="width:400px; height:300px;"></div>
<div class="code prettyprint">
    <pre class="code prettyprint brush: js"></pre>
</div>
    <p class="text">{$hotel} Click on a bar in the plot below to update the text box.</p>
    <p class="text">You Clicked: 
    <span id="info3">Nothing yet.</span>
    </p>
    <div id="chart3" style="width:400px; height:300px;"></div>
<div class="code prettyprint">
    <pre class="code prettyprint brush: js"></pre>
</div>
