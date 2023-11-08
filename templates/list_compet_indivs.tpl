<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
  $('#selectall').click(function(){
    var v = $(this).attr('checked');
    if( v == 'checked' ) {
      $('.select').attr('checked','checked');
    } else {
      $('.select').removeAttr('checked');
    }
  });
  $('.select').click(function(){
    $('#selectall').removeAttr('checked');
  });
  $('#toggle_filter').click(function(){
    $('#filter_form').toggle();
  });
  {if isset($tablesorter)}
  $('#articlelist').tablesorter({ sortList:{$tablesorter} });
  {/if}
$('#filter_btn').click(function(){
      $('#filter_zone').toggle();
});
//]]>
</script>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} | <a href="{cms_action_url action=defaultadmin __activetab=compets}">Compétitions par équipes</a> | <a href="{cms_action_url action=defaultadmin __activetab=compets indivs_suivies=1}">Compétitions individuelles suivies</a> {cms_help key=help_compets_suivies} | <a href="{cms_action_url action=defaultadmin __activetab=compets indivs_suivies=0}">Compétitions individuelles non suivies</a> | <a href="{cms_action_url action=defaultadmin __activetab=compets active=2}">Compétitions inactives</a></p></div>
	
	<p class="green"><a href="{cms_action_url action='retrieve_all_compets'}">{admin_icon icon="import.gif"}Récupérer toutes les compétitions disponibles</a></li>
	</p>
	{if $itemcount > 0}<p class="green">Clique sur les chevrons {admin_icon icon="true.gif"} {admin_icon icon="false.gif"} pour activer (désactiver) suivre ou ne plus suivre les compets</p>
	{$form2start}
<h1>{$titreTableau}</h1>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  	<th>Id</th>
  	<th>Nom sympa (coeff)</th>
  		
  	<th>Actif ?</th>
  	<th>Suivie ?</th>
  	<th>Organisateur</th>
  	{if true == $indivs}
  	<th>Divisions</th>
  	<th>Tours(poules)</th>
  	<th>Classements</th>
  	<th>Joueurs ds Clt</th>
  	{/if}
	<th colspan="2">Actions</th>
	<th><input type="checkbox" id="selectall" name="selectall"></th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->idepreuve}</td>
    <td>{$entry->friendlyname} ({$entry->coefficient})</td>
    
    <td>{if $entry->actif == '1'}<a href="{cms_action_url action=misc_actions obj=desactive_epreuve record_id=$entry->idepreuve}">{admin_icon icon="true.gif"}</a>{else}{admin_icon icon="false.gif"}{/if}</td>
    <td>{if $entry->typepreuve == 'E'}{admin_icon icon="true.gif"}{elseif $entry->suivi =="0"}<a href="{cms_action_url action=misc_actions obj=suivi_ok record_id=$entry->idepreuve}">{admin_icon icon="false.gif"}</a>{else}{admin_icon icon="true.gif"}{/if}</td>
    <td>{$entry->orga}</td>
    {if true == $indivs}
    <td>{$entry->divisions}</td>
    <td>{$entry->tours}</td>
    <td>{$entry->nb_cla}</td>
    <td>{if $entry->nb_players >0}<a href="{cms_action_url action=admin_div_classement idepreuve=$entry->idepreuve club=$club}" title="Voir les joueurs du club">{$entry->nb_players}{admin_icon icon="groupassign.gif"}</a>{else}{$entry->nb_players}{/if}</td>{/if}
    <!--td><a href="{cms_action_url action=retrieve_indivs obj=divisions idepreuve=$entry->idepreuve idorga=$entry->idorga}" title="Télécharge les résultats">{admin_icon icon="export.gif"}</a></td-->	
    <td><a href="{cms_action_url action=view_indivs_details record_id=$entry->idepreuve}">{admin_icon icon="view.gif"}</a></td>
    <!--td><a href="{cms_action_url action=misc_actions obj=raz_epreuve record_id=$entry->idepreuve}" title="Remise à zéro de toutes les données de cette épreuve">Raz</a></td>
	<!--td><a href="{cms_action_url action=misc_actions obj=delete_epreuve record_id=$entry->id}">{admin_icon icon="delete.gif"}</a></td>
	<td><a href="{cms_action_url action=add_type_compet name=$entry->name saison=$entry->saison}">{admin_icon icon="edit.gif"}</a></td-->
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
