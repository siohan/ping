{*debug*}
{if isset($message)}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{*if $itemcount > 0*}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>{$id}</th>
  <th>Nom</th>
<th>Prénom</th>
  <th colspan='3'>Actions</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->nom}</td>
    <td>{$entry->prenom}</td>
    <td>{$entry->sitmenslink}</td>
	<td>{$entry->getpartieslink}</td>
	<td>{$entry->getpartiesspid}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{*/if*}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
