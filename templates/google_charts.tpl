{*$dataPoints2|@print_r*}
{*assign var=foo value=""|explode:$dataPoints*}
{assign var=record_id value=$record_id scope=global}
{*$foo[0]|@print_r*}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    {literal}
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['% Victoires',{/literal}{$victoires}{literal}],
          ['% Défaites',  {/literal}{$defaites}{literal}]
          
          
        ]);

        var options = {
          title: 'Victoires et défaites en %',
           //is3D: true,
           pieHole: 0.3

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
        
      }
      setInterval(drawChart, 1000);
    </script>
    {/literal}
    {literal}
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart2);
		

   
    function drawChart2() {
		

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Mois');
      data.addColumn('number', 'Points');
      

      data.addRows([
      
      {/literal}{$dataPoints2}{literal}
       
      ]);

      var options = {
        animation:{
        startup: true,
        duration: 14000,
        easing: 'in'
      },
      chart: {
          title: 'Courbe des points',
          subtitle: ''
        },
             
       
      };
      

      var chart = new google.charts.Line(document.getElementById('linechart_material'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
	setInterval(drawChart, 1000);
    </script>
	{/literal}
	
	{literal}
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Victoires normales',{/literal}{$victoires_normales}{literal}],
          ['Victoires anormales',   {/literal}{$victoires_anormales}{literal}],
          ['defaites normales',  {/literal}{$defaites_normales}{literal}],
          ['defaites anormales', {/literal}{$defaites_anormales}{literal}]
          
        ]);

        var options = {
          title: 'Victoires et défaites',
          colors: ['blue', 'green', 'orange', 'red'],
           is3D: true,
           animation: {
                 duration: 1000,
                 easing: 'in',
                 startup: true}
                

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);
        var percent = 0;
        var handler = setInterval(function(){
            // values increment
            percent += 1;
            // apply new values
            data.setValue(0, 1, percent);
            data.setValue(1, 1, 100 - percent);
            // update the pie
            chart.draw(data, options);
            // check if we have reached the desired value
            if (percent > 74)
                // stop the loop
                clearInterval(handler);
        }, 120);
      }
    </script>
	{/literal}
	
	<!-- Les points par épreuve -->
	{literal}
		<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart3);
    function drawChart3() {
		var data = google.visualization.arrayToDataTable([
			
			["epreuve", "Points"],
			{/literal}{$bardata}{literal}
			
			
		]);
      /*var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Copper", 8.94, "#b87333"],
        ["Silver", 10.49, "silver"],
        ["Gold", 19.30, "gold"],
        ["Platinum", 21.45, "color: #e5e4e2"]
      ]);
		
      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
		*/
      var options = {
        title: "Points par épreuve",
        //width: 600,
        //height: 400,
        //bar: {groupWidth: "95%"},
        //legend: { position: "none" },
        animation:{
        
        duration: 100,
        easing: 'out'
      }

      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(data, options);
      /*var percent = 0;
        var handler = setInterval(function(){
            // values increment
            percent += 1;
            // apply new values
            data.setValue(0, 1, percent);
            data.setValue(1, 1, 100 - percent);
            // update the pie
            chart.draw(data, options);
            // check if we have reached the desired value
            if (percent > 74)
                // stop the loop
                clearInterval(handler);
        }, 120);
        */
  }
  </script>
  {/literal}

<h2>Victoires et défaites</h2>
<div id="piechart"></div> <!--style="width: 900px; height: 500px;"></div-->
<h2>Victoires et défaites (normales et anormales)</h2>
<div id="piechart2"></div> <!--style="width: 900px; height: 500px;"></div-->
<div id="linechart_material"></div> <!--style="width: 900px; height: 500px"></div-->
<h2>Points par épreuve</h2>
<div id="columnchart_values"></div> <!--style="width: 900px; height: 300px;"></div-->
<br />
<div class="container text-center">
	<div class="row"> 
		<div class="col"><a class="btn btn-primary" role="button" href="{cms_action_url action=user_results record_id=$record_id}">Tous les résultats de {$nom}</a></div>
	</div>
</div>
<br />
