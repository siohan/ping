<h1>{$titre}</h1>
<a href="{cms_action_url action=view_indivs_details record_id=$idepreuve}">{admin_icon icon="back.gif"}</a>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

{if $itemcount > 0}

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
	<th>Epreuve (division)</th>
	<th>Tableau</th>
	<th>Tour</th>
	<th>Nb de résultats</th>
	
	<th><input type="checkbox" id="selectall" name="selectall"></th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
   		<td>{$entry->libelle}  ({$entry->iddivision})</td>
		<td>{$entry->tableau}</td>
		<td>{$entry->tour}</td>
		<td>{$entry->tab_in_cla}</td>
		<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->tableau}" class="select"></td>
		
  </tr>
{/foreach}
 </tbody>
</table>

{/if}

