<div class="pageoptions">
	<p>
		<a href="{cms_action_url action=retrieve retrieve=teams type=M}">{admin_icon icon="import.gif"}Equipes Masculines</a> |
		<a href="{cms_action_url action=retrieve retrieve=teams type=F}">{admin_icon icon="import.gif"}Equipes Féminines</a> |
		<a href="{cms_action_url action=retrieve retrieve=teams type=U}">{admin_icon icon="import.gif"}Autres équipes</a> | 
		<a href="{cms_action_url action=retrieve_poule_rencontres cal=all}">{admin_icon icon="import.gif"}Tous les derniers résultats</a> </p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<fieldset><legend>Choix de la saison et de la phase</legend>
{form_start action="admin_teams_tab"}
<select name="saison">{html_options options=$liste_saisons selected=$saison_choisie}</select>
<select name="phase">{html_options options=$liste_phases selected=$phase}</select>
<input type="submit" name="submit" value="Choisir">
{form_end}
</fieldset>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>idequipe</th>
		<th>Equipe</th>
		<th>Niveau</th>
		<th>idepreuve</th>
		<th>Phase</th>
		<th>Nom court</th>
		<th>Horaire</th>
		<th>Page dans le site</th>
		<th colspan="3">Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->numero_equipe}</td>
	<td>{$entry->libequipe}</td>
    <td>{$entry->libdivision}</td>
    <td>{$entry->idepreuve}</td>
	<td>{$entry->phase}</td>
    <td>{$entry->friendlyname}</td>
	<td>{$entry->horaire}</td>
	<td>{if $entry->page_contenu == 0}{admin_icon icon="warning.gif" title="Pas de contenu"}{else}{admin_icon icon="true.gif" title=$entry->page_contenu}{/if}</td>
	<td><a href="{cms_action_url action=admin_poules_tab3 record_id=$entry->eq_id}">{admin_icon icon="view.gif"}</a></td>
	<td><a href="{cms_action_url action=edit_team record_id=$entry->eq_id}">{admin_icon icon="edit.gif"}</td>
    <td><a href="{cms_action_url action=delete type_compet=teams record_id=$entry->eq_id}">{admin_icon icon="delete.gif"}</a></td>
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


