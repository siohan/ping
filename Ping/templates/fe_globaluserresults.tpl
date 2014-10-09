{*debug*}
{*
{if isset($message)}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
*}

	<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>	
		<th>Joueur</th>
		<th>Vic</th>
		<th>Sur</th>
		<th>Total</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->joueur}</td>	
    <td>{$entry->victoires}</td>
    <td>{$entry->sur}</td>
	<td>{$entry->total}</td>
  </tr>
{/foreach}
 </tbody>
</table>
(Source Spid)
{/if}

<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
