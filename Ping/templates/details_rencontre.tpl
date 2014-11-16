<pre>{$items|var_dump}</pre>
<pre>{$entrees|var_dump}</>
	<table class="table">
{foreach from=$items key=key item = entry}

	<tr><td>({$key} - {$entry->equa} {$entry->resa}</td><td> - {$entry->resb} {$entry->equb}</td></tr>
	<tr>
		<td>{$entry->xja0} {$entry->scorea0} - {$entry->scoreb0}{$entry->xjb0}</td>
	</tr>

{/foreach}
</table>