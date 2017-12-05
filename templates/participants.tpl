
{if $itemcount >0}
<h3>{$compet} : Liste des participants</h3>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
   	<th>licence</th>
  	<th>Joueur</th>
	<th>Nb affectations</th>
	<th>Affectations</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->licence}</td>
    <td>{$entry->joueur}</td>
	<td>{$entry->nb}</td>
	<td>{$entry->affectation}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}