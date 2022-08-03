{if $itemcount > 0}

<table class="pagetable, table-bordered">
 <thead>
	<tr>
		<th>Joueur</th>
		<th>Ecart</th>
		<th>Points</th>
	</tr>
</thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->joueur}</td>
	<td>{$entry->adv} ({$entry->advclaof})</td>
    <td>{$entry->pointres}</td>
    </tr>
{/foreach}
{if $getmore == 'True'} <tr><td colspan="3">{$more}</td></tr>{/if}  
 </tbody>
<tfoot>
</table>
{/if}
