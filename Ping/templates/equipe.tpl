<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Clt</th>
		<th>Equipe</th>
		<th>Joue</th>
		<th>Pts</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->clt}</td>
    <td>{$entry->equipe}</td>
    <td>{$entry->joue}</td>
	<td>{$entry->pts}</td>
    
  </tr>
{/foreach}
 </tbody>
</table>
{/if}

