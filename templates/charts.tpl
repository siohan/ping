{literal}
<script>
	FuncOL = new Array();
function StkFunc(Obj) {
	FuncOL[FuncOL.length] = Obj;
}
// Execution des scripts au chargement de la page 
window.onload = function() {
	for(i=0; i<FuncOL.length; i++)
		{FuncOL[i]();}
}
 function f1() {

var options = {
	title: {
		text: "Pourcentage de victoires/ Défaites"
	},
	subtitles: [{
		text: "Saison 2022-2023"
	}],
	animationEnabled: true,
	data: [{
		type: "pie",
		startAngle: 40,
		toolTipContent: "<b>{label}</b>: {y}",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} : {y}%",
		dataPoints: [
			{ y: {/literal}{$pourcentage_victoires}{literal}, label: "Victoires" },
			{ y: {/literal}{$pourcentage_defaites}{literal}, label: "Défaites" },
			
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);

}
StkFunc(f1);
</script>
{/literal}

{literal}<script>
function f2() {

var options = {
	title: {
		text: "Pourcentage de victoires/ Défaites"
	},
	subtitles: [{
		text: "Saison 2022-2023"
	}],
	animationEnabled: true,
	data: [{
		type: "pie",
		startAngle: 40,
		toolTipContent: "<b>{label}</b>: {y}",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y}%",
		dataPoints: [
			{ y: {/literal}{$pourcentage_victoires}{literal}, label: "Victoires en %" },
			{ y: {/literal}{$pourcentage_defaites}{literal}, label: "Défaites en %" },
			
		]
	}]
};
$("#chartContainer2").CanvasJSChart(options);

}
StkFunc(f2);
</script>
{/literal}
