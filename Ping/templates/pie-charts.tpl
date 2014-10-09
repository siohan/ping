<script type="text/javascript" src="modules/Ping/jqplot/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="modules/Ping/jqplot/jqplot.donutRenderer.min.js"></script>
{literal}
<script class="code" type="text/javascript">
$(document).ready(function(){
  var data = [{/literal}

['{$Label_victoires}', {$donnees.Victoires}],['{$Label_defaite}', {$donnees.Defaites}]
    {literal}
  ];
  var plot1 = jQuery.jqplot ('chart1', [data], 
    { 
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});
</script>
{/literal}
{foreach from=$items item=entry}
<p> {$entry->victoires}  ------------ {$entry->defaites}{/foreach}</p>
<div id="chart1" style="height:300px; width:500px;"></div>
<div class="code prettyprint">
<pre class="code prettyprint brush: js"></pre>
</div>





