{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
    <p class="pageinput">{$input_player} </p>
    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}<p>Les résultats de {$player}</p>
<ul><li>{$liensaison2}</li><li>{$liensaison}</li></ul>
<div id="chart1" style="width:600px; height:300px"></div>

    <p>This plot animates the bars bottom to top and the line series left to right upon initial page load.  Since the <code>animateReplot: true</code> option is set, the bars and line will also animate upon calls to <code>plot1.replot( { resetAxes: true } )</code>.</p>

    <pre class="code brush:js"></pre>

{literal}
<script class="code" type="text/javascript">

    $(document).ready(function () {
        var s1 = [{/literal}
{foreach $items  as $entry}

[{$entry->mois},{$entry->points}]{if $entry@last} {else}, {/if}
{/foreach}{literal}];
//[2002, 112000], [2003, 122000], [2004, 104000], [2005, 99000], [2006, 121000], 
     //   [2007, 148000], [2008, 114000], [2009, 133000], [2010, 161000], [2011, 173000]];
        var s2 = [{/literal}{foreach $items  as $entry}

		[{$entry->mois},{$entry->victoires}]{if $entry@last} {else}, {/if}
		{/foreach}{literal}];
		//[2002, 10200], [2003, 10800], [2004, 11200], [2005, 11800], [2006, 12400], 
     //   [2007, 12800], [2008, 13200], [2009, 12600], [2010, 13100]];
     var ticks = ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "juil", "Aou", "Sep", "Oct", "Nov", "déc"];
        plot1 = $.jqplot("chart1", [s2], {
            // Turns on animatino for all series in this plot.
            animate: true,
            // Will animate plot on calls to plot1.replot({resetAxes:true})
            animateReplot: true,
            cursor: {
                show: true,
                zoom: true,
                looseZoom: true,
                showTooltip: false
            },
            series:[
                {
                    pointLabels: {
                        show: true
                    },
                    renderer: $.jqplot.BarRenderer,
                    showHighlight: false,
                    yaxis: 'y2axis',
                    rendererOptions: {
                        // Speed up the animation a little bit.
                        // This is a number of milliseconds.  
                        // Default for bar series is 3000.  
                        animation: {
                            speed: 2500
                        },
                        barWidth: 15,
                        barPadding: -15,
                        barMargin: 0,
                        highlightMouseOver: false
                    }
                }, 
                {
                    rendererOptions: {
                        // speed up the animation a little bit.
                        // This is a number of milliseconds.
                        // Default for a line series is 2500.
                        animation: {
                            speed: 2000
                        }
                    }
                }
            ],
            axesDefaults: {
                pad: 0
            },
            axes: {
                // These options will set up the x axis like a category axis.
                xaxis: {
                    tickInterval: 1,
                    drawMajorGridlines: false,
                    drawMinorGridlines: true,
                    drawMajorTickMarks: false,
                    rendererOptions: {
                    tickInset: 0.5,
                    minorTicks: 1
                }
                },
                yaxis: {
                    tickOptions: {
                        formatString: "Pts%'d"
                    },
                    rendererOptions: {
                        forceTickAt0: true
                    }
                },
                y2axis: {
                    tickOptions: {
                        formatString: "Vic%'d"
                    },
                    rendererOptions: {
                        // align the ticks on the y2 axis with the y axis.
                        alignTicks: true,
                        forceTickAt0: true
                    }
                }
            },
            highlighter: {
                show: true, 
                showLabel: true, 
                tooltipAxes: 'y',
                sizeAdjust: 7.5 , tooltipLocation : 'ne'
            }
        });
      
    });


</script>

{/literal}
<!-- Don't touch this! -->


    <script class="include" type="text/javascript" src="../jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="modules/Ping/jqplot/syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="modules/Ping/jqplot/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="modules/Ping/jqplot/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- Additional plugins go here -->

  <script class="include" type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.barRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.highlighter.min.js"></script>
  <script class="include" type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.cursor.min.js"></script> 
  <script class="include" type="text/javascript" src="modules/Ping/jqplot/plugins/jqplot.pointLabels.min.js"></script>

<!-- End additional plugins -->

