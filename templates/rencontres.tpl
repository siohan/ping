
{*<fieldset><legend>Filtres</legend>

{form_start action="admin_rencontres_tab"}
<select name="idepreuve">{html_options options=$liste_epreuves selected=$idepreuve}</select>
<input type="text" name="tour" value="{$tour}" placeholder="N°tour">
<select name="saison">{html_options options=$seasons_list selected=$saison}</select> 
<input type="checkbox" name="myclubonly" {if $myclubonly== 'on'}checked{/if}>Mon club seul ?
<input type="submit" name="submit" value="Go !"> {form_end}
</fieldset>*}
{if true == $alertConfig}
<p class="warning">Tes identifiants FFTT ne sont pas  encore enregistrés !! <br />
Laisse-toi guider dans le processus d'installation. Si une erreur survient, tu auras l'occasion de pouvoir la corriger en manuel.<br />
<a href="{cms_action_url action=admin_compte_tab}">Je rentre mes identifiants !</a></p>
{else}
	
	{if $itemcount>0}
	{$form2start}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable table">
		<thead>
					<tr>
						<th>Date</th>
						<th>Tour</th>
						<th>Equipe A</th>
						<th>Horaire/Score</th>
						<th>Equipe B</th>
						<th>Affichage</th>
						<th>Compte à rebours</th>
						<th><input type="checkbox" id="selectall" name="selectall"></th>
					</tr>
				</thead>
				<tbody>
				{foreach from=$items item=entry}
					{*{if $entry->club ==1}
					<tr style="background-color: #bfc9ca">
					{else}
					<tr>
					{/if}
					*}
					<tr>
						<td>{$entry->date_event|date_format:"%d-%m-%Y"}</td>
						<td>{$entry->tour}</td>
						<td>{$entry->equa}</td>
						<td>{if $entry->date_smarty gt $entry->actual_time}{$entry->horaire}{else}{$entry->scorea} - {$entry->scoreb}{/if}</td>
						<td>{$entry->equb}</td>
						<td>{if $entry->display=="1"}<a href="{cms_action_url action='misc_actions' obj=affiche_ko record_id=$entry->renc_id}">{admin_icon icon="true.gif"}{else}<a href="{cms_action_url action='misc_actions' obj=affiche_ok record_id=$entry->renc_id}">{admin_icon icon="false.gif"}{/if}</td>
						<td>{if $entry->countdown =="1"}<a href="{cms_action_url action='misc_actions' obj=countdown_ko record_id=$entry->renc_id}">{admin_icon icon="true.gif"}{else}<a href="{cms_action_url action='misc_actions' obj=countdown_ok record_id=$entry->renc_id}">{admin_icon icon="false.gif"}{/if}</td>
						
						<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->renc_id}" class="select"></td>
					</tr>
				{/foreach}
			</table>
			<!-- SELECT DROPDOWN -->
	<div class="pageoptions" style="float: right;">
	<br/>{$actiondemasse}{$submit_massaction}
	  </div>
	{$form2end}
	
	{/if}
{/if}
