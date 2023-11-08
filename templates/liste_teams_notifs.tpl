<h2>Liste des nouvelles équipes</h2>
<div class="pageoptions"><p class="pageoptions"></p></div>
{if $itemcount > 0}

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Libellé</th>
		<th>Division</th>
		<th>Ajouté le</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->libequipe}</td>
	<td>{$entry->libdivision}</td>
	<td>{$entry->timbre}</td>
  </tr>
{/foreach}
 </tbody>
</table>

{/if}
<p>Consultez la liste en temps réel</p> 
