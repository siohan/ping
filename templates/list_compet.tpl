	<div class="pageoptions"><p class="pageoptions warning">Récupérer les différentes compétitions - > {$Nat_indivs} - {$Nat_equipes} - {$zone_indivs} - {$zone_equipes} - {$ligue_indivs} - {$ligue_equipes} - {$dep_indivs} - {$dep_equipes}</p></div>
	<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  	<th>Nom</th>
  	<th>Coefficient</th>
	<th>Echelon</th>
	<th>Tag pour affichage</th>
	<th colspan="4">Récupérer les divisions</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->name} ({$entry->idepreuve})</td>
   	<td>{$entry->coefficient}</td>
	<td>{$entry->orga}</td>
	<td>{$entry->tag}</td>
	<td>{$entry->natio}-{$entry->zone}-{$entry->ligue}-{$entry->dep}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
