{$affectations}
{if $itemcount >0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
   	<th>licence</th>
  	<th>Joueur</th>
	<th>Affectations</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->licence}</td>
    <td>{$entry->joueur}</td>
	<td>{$entry->affectation}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}