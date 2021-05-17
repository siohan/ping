<div class="pageoptions"><p><span class="pageoptions warning"><a href="{cms_action_url action=retrieve retrieve=teams type=M}">{admin_icon icon="import.gif"}Equipes Masculines</a> | {$retrieve_teams_fem} | {$retrieve_teams_autres}</span> </p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

	{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Equipe</th>
		<th>Niveau (idepreuve)</th>
		<th>Phase</th>
		<th>Nom court</th>
		<th>Horaire</th>
		<th>Tag pour affichage</th>
		<th colspan="3">Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->libequipe}</td>
    <td>{$entry->libdivision} ({$entry->idepreuve})</td>
	<td>{$entry->phase}</td>
    <td>{$entry->friendlyname}</td>
	<td>{$entry->horaire}</td>
	<td>{$entry->tag}</td>
	<td><a href="{cms_action_url action=admin_poules_tab3 record_id=$entry->eq_id}">{admin_icon icon="view.gif"}</a></td>
	<td><a href="{cms_action_url action=edit_team record_id=$entry->eq_id}">{admin_icon icon="edit.gif"}</td>
    <td>{$entry->deletelink}</td>
<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->eq_id}"
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


