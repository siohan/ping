<div class="pageoptions<"><p><span class="pageoptions warning">{$retrieve_all} | {$retrieve_calendriers} | {$classements}</span></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>{if $itemcount > 0}
<p class="pageoptions">{$phase1} | {$phase2}</p>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>{$id}</th>
		<th>{$equipe}</th>
		<th>Niveau</th>
		<th>Compétition</th>
		<th>Nom court</th>
		<th>Tag pour affichage</th>
		<th colspan="4">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
    <td>{$entry->libequipe}</td>
    <td>{$entry->libdivision}</td>
	<td>{$entry->name}</td>
    <td>{$entry->friendlyname}</td>
	<td>{$entry->tag}</td>
	<td>{$entry->view}</td>
	<td>{$entry->editlink}</td>
    <td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}

