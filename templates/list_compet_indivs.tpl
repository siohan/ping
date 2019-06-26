{if $itemcount > 0}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  	<th>{$id}</th>
  	<th>Nom</th>
  	<th>Coefficient</th>
	<th>Indivs</th>
	<th>Echelon</th>
	<th>Tag pour affichage</th>
	<th>Inscrits</th>
	<th>Ajouter</th>
	<th colspan="3">Accéder aux divisions</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
    <td>{$entry->name} ({$entry->idepreuve})</td>
   	<td>{$entry->coefficient}</td>
	<td>{if $entry->indivs =='1'}Oui{else}Non{/if}</td>
	<td>{$entry->orga}</td>
	<td>{$entry->tag}</td>
	<td>{$entry->nb_participants}</td>
	<td>{$entry->participants}</td>
	<td>{$entry->natio}-{$entry->zone}-{$entry->ligue}-{$entry->dep}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}