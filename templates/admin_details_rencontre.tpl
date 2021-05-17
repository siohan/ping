<a href="{cms_action_url action='defaultadmin'}">{admin_icon icon="back.gif"}Revenir</a> | <a href="{cms_action_url action=misc_actions obj=delete_details_rencontre record_id=$record_id}">{admin_icon icon='delete.gif'}Supprimer tout</a> | <a href="{cms_action_url action='retrieve_details_rencontres2' record_id=$record_id}">{admin_icon icon="import.gif"} Télécharger les détails</a>
{if $itemcount > 0}
<h3>La feuille de match : </h3>
<table class="pagetable">
 <thead>
	<tr>
		<th>Joueur A</th>
		<th>Clt A</th>
		<th>Joueur B</th>
		<th>Clt B</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td><strong>{$entry->xja}</strong></td>
    <td>{$entry->xca}</td>
    <td><strong>{$entry->xjb}</strong></td>
	<td>{$entry->xcb}</td>   
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
{if $itemcount2 > 0}
<h3>Ordre des parties</h3>
<table class="pagetable table-bordered">
	<tr>
		<th>Score</th>
		<th>Equipe A</th>
		<th>Score A</th>
		<th>Score B</th>
		<th>Equipe B</th>
	</tr>
{foreach from=$items2 item=entry}  	
	<tr>
		<td>{$entry->detail}</td>
		<td>{$entry->joueurA}</td>
		<td>{$entry->scoreA}</td>
		<td>{$entry->scoreB}</td>
		<td>{$entry->joueurB}</td>
	</tr>
{/foreach}
</table>
{/if}

