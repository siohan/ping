<table id="tableau" class="table table-bordered">
{foreach from=$items  item=entry}	
		<tr>
			<td class="left">{$entry->equa}</td>
			<td>{$entry->scorea}</td>
			<td>{$entry->scoreb}</td>
			<td class="right">{$entry->equb}</td>
		</tr>
{/foreach}
</table>
	


