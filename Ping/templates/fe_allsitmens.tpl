{*<pre>{$monthslist|var_dump}</pre>*}
{*<pre>{$items|var_dump}</pre>*}
<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<table class="table table-bordered">
	<thead>
		<th>Joueur</th>
		{foreach from=$monthslist item=entree}
			<th>{$mois[$entree]}</th>
		{/foreach}
		<!--<th>Prog mois</th>-->
		<th>Nat</th>
		<th>Reg</th>
		<th>Dép</th>
	</thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->joueur}</td>
    {if $entry->sept != NULL}<td>{$entry->sept}</td>{/if}
	{if $entry->oct != NULL}<td>{$entry->oct}</td>{/if}
	{if $entry->nov != NULL}<td>{$entry->nov}</td>{/if}
	{if $entry->dec != NULL}<td>{$entry->dec}</td>{/if}
	{if $entry->jan != NULL}<td>{$entry->jan}</td>{/if}
	{if $entry->fev != NULL}<td>{$entry->fev}</td>{/if}
	{if $entry->mar != NULL}<td>{$entry->mar}</td>{/if}
	{if $entry->avr != NULL}<td>{$entry->avr}</td>{/if}
	{if $entry->mai != NULL}<td>{$entry->mai}</td>{/if}
	{if $entry->juin != NULL}<td>{$entry->juin}</td>{/if}
	{if $entry->juil != NULL}<td>{$entry->juil}</td>{/if}
	{*<td>{$entry->progmois}</td>*}
	<td>{$entry->clnat}</td>
	<td>{$entry->rangreg}</td>
	<td>{$entry->rangdep}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{else}
<p>Les situations mensuelles sont à jour</p>
{/if}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
