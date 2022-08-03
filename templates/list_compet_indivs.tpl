<p>Récupérez les compétitions :</p>
<p> 
	<a href="{cms_action_url action='retrieve' retrieve=compets idorga=10001 type=E }">{admin_icon icon="import.gif"}Nationales Equipes</a> | 
	<a href="{cms_action_url action='retrieve' retrieve=compets idorga=10001 type=I}">{admin_icon icon="import.gif"}Nationales indivs</a> | 
	<a href="{cms_action_url action='retrieve' retrieve=compets idorga=$zone type=E}">{admin_icon icon="import.gif"}Zone Equipes</a> | 
	<a href="{cms_action_url action='retrieve' retrieve=compets idorga=$zone type=I}">{admin_icon icon="import.gif"}Zone indivs</a> | 
	<a href="{cms_action_url action='retrieve' retrieve=compets idorga=$ligue type=E}">{admin_icon icon="import.gif"}Ligue Equipes</a> | 
	<a href="{cms_action_url action='retrieve' retrieve=compets idorga=ligue type=I}">{admin_icon icon="import.gif"}Ligue indivs</a> |
	<a href="{cms_action_url action='retrieve' retrieve=compets idorga=$dep type=E}">{admin_icon icon="import.gif"}Dép Equipes</a> | 
	<a href="{cms_action_url action='retrieve' retrieve=compets idorga=dep type=I}">{admin_icon icon="import.gif"}Dép indivs</a> |
</p>
	{if $itemcount > 0}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  	<th>{$id}</th>
  	<th>Nom</th>
  	<th>Actif ?</th>
	<th>Tag pour affichage</th>
	<th colspan="2">Actions</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
    <td>{$entry->name} ({$entry->idepreuve})</td>
   	<td>{if $entry->actif == '1'}<a href="{cms_action_url action=misc_actions obj=desactive_epreuve record_id=$entry->idepreuve}">{admin_icon icon="true.gif"}</a>{else}{admin_icon icon="false.gif"}{/if}</td>
	<td>{$entry->tag}</td>
	<td><a href="{cms_action_url}">{admin_icon icon="delete.gif"}</a></td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
