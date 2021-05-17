<a href="{cms_action_url action='delete' record_id=0 type_compet=journal record_id=1}">{admin_icon icon="delete.gif"}Supprimer tout le journal</a>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0 && is_array($items) && count($items)>0}

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