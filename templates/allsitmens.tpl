{*<pre>{$items|var_dump}</pre>*}
<div class="pageoptions">
{if $jour <10}
<p class="warning">Attention ! L'accès n'est pas encore libre ! Vous ne pouvez pas récupérer les situations mensuelles automatiquement</p>{else}<p class="success">L'accès est désormais libre, vous pouvez  récupérer les situations mensuelles.</p>{/if}</div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} | {$retrieveallsitmens} </p></div>
<h3>Les situations mensuelles du mois en cours</h3>
<a href="{cms_action_url action='defaultadmin' __activetab='situation' mois=$mois_prec}"> &lt Préc</a>
<a href="{cms_action_url action='defaultadmin' __activetab='situation' mois=$mois_suivant}"> Suiv &gt</a>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>ID</th>
		<th>Licence</th>
		<th>Mois</th>
		<th>Joueur</th>
		<th>Points</th>
		<th>Rang nat</th>
		<th>Rang reg</th>
		<th>Rang dép</th>
		<th>Progression mens</th>
		<th colspan="2">Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
	<td>{$entry->licence}</td>
	<td>{$entry->mois}</td>
    <td>{$entry->joueur}</td>
    <td>{$entry->points}</td>
	<td>{$entry->clnat}</td>
	<td>{$entry->rangreg}</td>
	<td>{$entry->rangdep}</td>
	<td>{$entry->progmois}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->licence}" class="select"></td>
  </tr>
{/foreach}
 </tbody>
</table>
<!-- SELECT DROPDOWN -->
<div class="pageoptions" style="float: right;">
<br/>{$actiondemasse}{$submit_massaction}
  </div>
{$form2end}
{/if}
<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
