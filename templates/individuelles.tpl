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
<table class="pagetable table table-bordered">
 <thead>
	<tr>	
		<th>Joueur</th>
		<th>Vic</th>
		<th>Sur</th>
		<th>Points</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  {if $entry->victoire =='1'}<tr class="{$entry->rowclass} vic">{else}<tr class="{$entry->rowclass} def">{/if}
	<td>{$entry->date_event|date_format:"%d/%m"}</td>	
    <td>{$entry->joueur}</td>	
    <td>{$entry->nom}({$entry->classement})</td>
    <td>{$entry->victoire}</td>
	<td>{$entry->pointres}</td>
	</tr>
{/foreach}
 </tbody>
</table>
(Source Spid)
{/if}

<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
