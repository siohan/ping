<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} | <a href="{cms_action_url action=defaultadmin __activetab=compets}">Compétitions par équipes</a> | <a href="{cms_action_url action=defaultadmin __activetab=compets indivs_suivies=1}">Compétitions individuelles</a> {cms_help key=help_compets_suivies}  | <a href="{cms_action_url action=defaultadmin __activetab=compets active=2}">Compétitions inactives</a></p></div>
	
	<p class="green"><a href="{cms_action_url action='retrieve_all_compets'}">{admin_icon icon="import.gif"}Récupérer toutes les compétitions disponibles</a></p>
	{if $itemcount > 0}<p class="green">Clique sur les chevrons {admin_icon icon="true.gif"} {admin_icon icon="false.gif"} pour activer (désactiver) les compets</p>
	<p class="red">Désactiver une épreuve et elle n'apparait plus en frontal</p>
	{if true == $indivs}<div class="pageoptions">Recherche une compét : {form_start action=admin_compets_indivs_tab}<input type="text" name="recherche" value=""><input type="submit" name="submit" value="Go!"> {form_end}</div>
	<p><a href="{cms_action_url action=misc_actions obj=all_divisions}">Récupérer toutes les divisions</a> | <a href="{cms_action_url action=misc_actions obj=all_tours}">Récupérer tous les tours</a> | <a href="{cms_action_url action=misc_actions obj=all_classements}">Récupérer tous les classements</a> | <a href="{cms_action_url action=misc_actions obj=set_uploaded}">Vérifier les uploads</a> <a href="{cms_action_url action=misc_actions obj=deactive_epreuve}">Désactiver les épreuves sans joueurs du club</a></p>{/if}
	{$form2start}
<h1>{$titreTableau}</h1>
{if $suivant >1}<a href="{cms_action_url action=defaultadmin __activetab=compets indivs_suivies=1 page_number=$precedent}"> < Précédent</a> |{/if} {if $suivant < $nb_pages}<a href="{cms_action_url action=defaultadmin __activetab=compets indivs_suivies=1 page_number=$suivant}">Suivant ></a>{/if}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  	<th>Id</th>
  	<th>Nom sympa (coeff)</th>  		
  	<th>Actif ?</th>
  		
  	{if true == $indivs}
  	<th>Dates</th>
  	<th>Divisions</th>
  	<th>Tours(poules)</th>
  	<th>Classements</th>
  	<th>Joueurs ds Clt</th>
  	<th>Action(s)</th>
  	{else}
  	<th>Equipes concernées {cms_help key="nb_equipes_chpt"}</th>
  	<th>Actions</th>
  	{/if}
	
	<th><input type="checkbox" id="selectall" name="selectall"></th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr{if isset($entry->date_epr) && $entry->date_epr < $now} class="outdated"{/if}>
    <td>{$entry->idepreuve}</td>
    <td>{$entry->friendlyname} ({$entry->coefficient}){if false == $indivs}
															{if isset($entry->has_teams) &&$entry->has_teams < 1}
																{admin_icon icon="warning.gif" title="Si une compétiton ne concerne aucune équipe, tu peux la désactiver"}
															{/if}
														{else}
															{if $entry->nb_cla >0 && $entry->nb_players ==0 && $entry->date_epr < $now}{admin_icon icon="warning.gif" title="Si la date est dépassée, tu peux désactiver cette épreuve"}
															{/if}
														{/if}
	</td>
    
    <td>{if $entry->actif == '1'}<a href="{cms_action_url action=misc_actions obj=desactive_epreuve record_id=$entry->idepreuve}">{admin_icon icon="true.gif"}</a>{else}{admin_icon icon="false.gif"}{/if}</td>
        
    {if true == $indivs}
    <td>{$entry->date_prevue}</td>
    <td>{$entry->divisions}</td>
    <td>{$entry->tours}</td>
    <td>{$entry->nb_cla}</td>
    <td>{if $entry->nb_players >0}<a href="{cms_action_url action=admin_div_classement idepreuve=$entry->idepreuve club=$club}" title="Voir les joueurs du club">{$entry->nb_players}{admin_icon icon="groupassign.gif"}</a>{else}{$entry->nb_players}{/if}</td>
    {else}<td>{$entry->has_teams}</td>{/if}
   
    <td><a href="{cms_action_url action=view_indivs_details record_id=$entry->idepreuve}">{admin_icon icon="view.gif"}</a></td>
   
	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->idepreuve}" class="select"></td>
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
