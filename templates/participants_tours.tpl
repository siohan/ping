{$retour} - {$add}
{if $itemcount >0}
<h3>{$joueur}</h3>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
   	<th>licence</th>
  	<th>Tour</th>
	<th>Niveau</th>
	<th>Division</th>
	<th>Tableau</th>
	<th colspan="3">Actions</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->licence}</td>
    <td>{$entry->tour}</td>
	<td>{$entry->idorga}</td>
 	<td>{$entry->libelle} ({$entry->iddivision})</td>
 	<td>{$entry->tableau}</td>
	<td>{$entry->parties}</td>
	<td>{$entry->uploaded_classement}{$entry->classement}</td>
	<td>{$entry->affectation}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}