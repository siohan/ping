<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} <a href="{cms_action_url action=brulage1}">Rafraichir le brûlage</a> | <a href="{cms_action_url action=brulage_par_eq}">Brûlage individuel</a> | <a href="{cms_action_url action=change_genid_licence}">Switch genid to licence</a></p></div>

{if $itemcount > 0}

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		
		<th>Joueur</th>
		{if $phase == 1}
		<th>J1</th>
		<th>J2</th>
		<th>J3</th>
		<th>J4</th>
		<th>J5</th>
		<th>J6</th>
		<th>J7</th>
		{else}
		<th>J8</th>
		<th>J9</th>
		<th>J10</th>
		<th>J11</th>
		<th>J12</th>
		<th>J13</th>
		<th>J14</th>{/if}
		
		<th colspan="2">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	
	<td>{$entry->licence}</td>
	{if $phase == "1"}
	<td>{$entry->J1}</td>	
	<td>{$entry->J2}</td>
	<td>{$entry->J3}</td>
	<td>{$entry->J4}</td>
	<td>{$entry->J5}</td>
	<td>{$entry->J6}</td>
	<td>{$entry->J8}</td>
	{else}
		<th>{$entry->J8}</th>
		<th>{$entry->J9}</th>
		<th>{$entry->J10}</th>
		<th>{$entry->J11}</th>
		<th>{$entry->J12}</th>
		<th>{$entry->J13}</th>
		<th>{$entry->J14}</th>{/if}
	
	<td>{$entry->editlink}</td>
    <td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}

