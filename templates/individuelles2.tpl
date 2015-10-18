{*<pre>{$items|var_dump}</pre>*}

<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
{*<div class="pageoptions"><p class="pageoptions" style="float: right">{$indivs_courant}</p></div>*}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Tableau</th>
			<th>Rang</th>
			<th>Nom</th>
			<th>Points</th>		
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
	<tr>
		<td>{$entry->libelle}</td>
		<td>{$entry->rang}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->points}</td>
	</tr>		
{/foreach}
	</tbody>
 </table>

{/if}

<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
