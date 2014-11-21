<pre>{*$items|var_dump*}</pre>
<h3>Les résultats du {$entree->date_event}</h3>
<table>
	
	{foreach from=$items item=entry}
	<tr>
		<td>{$i++}</td>
		<td>{$entry->equa}</td>
		<td>{$entry->scorea}</td>
		<td>{$entry->scoreb}</td>
		<td>{$entry->equb}</td>
		<td>{$entry->details}</td>
	</tr>
	{/foreach}
</table>
