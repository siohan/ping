
<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<div class="pageoptions"><p class="pageoptions">{$retrieveallsitmens}| {$createlink}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
	<thead>
		<th>Joueur</th>
		<th>Mai</th>
		<th>Juin</th>
	</thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->joueur}</td>
    <td>{$entry->mai}</td>
	<td>{$entry->juin}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{else}
<p>Les situations mensuelles sont à jour</p>
{/if}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
