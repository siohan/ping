{debug}
{if isset($message)}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{*if $itemcount > 0*}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>{$id}</th>
  <th>{$tour}</th>
  <th>{$equipe}</th>
  <th>{$joueur}</th>
  <th>{$adversaire}</th>
  <th>{$victoire}</th>
  <th>{$points}</th>
  <th class="pageicon">&nbsp;</th>
  <th class="pageicon">&nbsp;</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->tour}</td>
    <td>{$entry->equipe}</td>
    <td>{$entry->joueur}</td>
	<td>{$entry->adversaire}</td>
	<td>{$entry->vic_def}</td>
	<td>{$entry->points}</td>
	<td>{$entry->idlink}</td>
    <td>{$entry->editlink}</td>
    <td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{*/if*}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
