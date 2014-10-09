<h2>Liste des joueurs inactifs</h2>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}  {$display_enable_players}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>{$id}</th>
  <th>Joueur</th>
<th>Actions</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}

  <tr  class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->joueur}</td>
	<td>{$entry->editlink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}

