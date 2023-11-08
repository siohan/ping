<a href="{cms_action_url action='delete' record_id=0 type_compet=journal record_id=1}">{admin_icon icon="delete.gif"}Supprimer tout le journal</a>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0 && is_array($items) && count($items)>0}
<p class="pagerows"><a href="{cms_action_url action=admin_journal_tab number='0'}"><<</a> <a href="{cms_action_url module='Ping' action=admin_journal_tab number=$precedent}">< Préc </a> 
	{if $nb_pages > 10}
	
		{for $i=$page_actuelle-2 to $page_actuelle+2}
		<a href="{cms_action_url action='admin_journal_tab'  number=$i*100-100}">{if $page_actuelle == $i}<strong>{$i}{*$entry->libequipe*}</strong>{else}{$i}{/if}</a>
		{/for} ....
		{for $i=$nb_pages-4 to $nb_pages}
		<a href="{cms_action_url action='admin_journal_tab'  number=$i*100-100}">{if $page_actuelle == $i}<strong>{$i}{*$entry->libequipe*}</strong>{else}{$i}{/if}</a>
		{/for}

	{/if}
<a href="{cms_action_url module='Ping' action=admin_journal_tab number=$suivant}">Suivant >></a></p>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Id</th>
		<th>Date de mise à jour</th>
		<th>designation</th>
    </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->datecreated|date_format:"%A %e %B %Y à %H:%M:%S"}</td>
    <td>{$entry->designation}</td>
	</tr>
{/foreach}
 </tbody>
</table>
{/if}
