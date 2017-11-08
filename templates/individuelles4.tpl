{*<pre>{$items|var_dump}</pre>*}

<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<h3>{$libelle}</h3>
<table>
	<thead>
		<tr>
			<th>Nom</th>
			<th>Rang</th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
  
	
			<tr class="{$entry->rowclass}">
				<td>{$entry->nom}</td>
				<td>{$entry->rang}</td>
			</tr>
		
{/foreach}
</tbody>
</table> 

{/if}

<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
