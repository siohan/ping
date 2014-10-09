{*debug*}
{if isset($message)}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<div class="pageoptions"><p class="pageoptions">{$retrieveallsitmens}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>ID</th>
  <th>Licence</th>
  <th>Nom</th>
  <th>Prenom</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
    <td>{$entry->joueur}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{else}
<p>Les situations mensuelles sont à jour</p>
{/if}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
