<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<div class="pageoptions"><p class="pageoptions">{$retrieve_all}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>	
		<th>Joueur</th>
		<th>Date</th>
		<th>Epreuve</th>
		<th>Nom adversaire</th>
		<th>Classement</th>
		<th>Victoire</th>
		<th>Ecart</th>
		<th>Coeff</th>
		<th>Points</th>
		<th>Forfait</th>
		<th colspan="2">Actions</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->joueur}</td>	
    <td>{$entry->date_event}</td>
    <td>{$entry->epreuve}</td>
	<td>{$entry->name}</td>
	<td>{$entry->classement}</td>
	<td>{$entry->victoire}</td>
	<td>{$entry->ecart}</td>
	{if $entry->coeff  eq "0.00"}<td style="background-color: red;">{else}<td>{/if}{$entry->coeff}</td>
	<td>{$entry->pointres}</td>
	<td>{$entry->forfait}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
	<td></td>
  </tr>
{/foreach}
 </tbody>
</table>
(Source Spid)
{/if}

<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
