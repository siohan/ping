{*<pre>{$items|var_dump}</pre>*}

<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
{*<div class="pageoptions"><p class="pageoptions" style="float: right">{$indivs_courant}</p></div>*}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{*if $itemcount > 0*}

{foreach from=$items item=entry}
  
	<h3>{$entry->name} du {$entry->date_event|date_format:"%d/%m"}</h3>	
	{**}{if $itemscount_{$entry->valeur} >0 }
    <table class="table table-bordered">
		<tr><th>Tableau</th><th>Rang</th><th>Nom</th></tr>
		{foreach from=$prods_{$entry->valeur} item=donnee}
		{*<pre>{$prods_{$entry->valeur}|var_dump}</pre>*}	<tr><td>{$donnee->libelle}</td><td>{$donnee->rang}</td><td>{$donnee->nom}</td><!--<td>{$donnee->details}</td>--></tr>
		{/foreach}
		</table>
	{/if}{**}
{/foreach}
 

{*/if*}

<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
