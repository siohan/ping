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
  	<th>Coefficient</th>
	<th>Tag pour affichage</th>
	<th colspan="2">Actions</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
    <td>{$entry->name} ({$entry->idepreuve})</td>
   	<td>{$entry->coefficient}</td>
	<td>{$entry->tag}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}