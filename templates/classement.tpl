{*debug*}
{if $itemcount > 0}
{*<p class="pageoptions">{$phase1} | {$phase2}</p>*}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		
		<th>Equipe</th>
		<th>Classement</th>
		
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->friendlyname}</td>
    <td>{$entry->clt}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{else}
<p>No results yet</p>
{/if}

