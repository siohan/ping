<h1>Compétitions individuelles</h1>
<!--a href="{cms_action_url action=view_indivs_details record_id=$idepreuve}">{admin_icon icon="back.gif"}</a-->

<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
	<th>Date</th>
	<th>Nom</th>
	<th>Epreuve (division)</th>
	<th>Tableau</th>
	<th>Tour</th>	
	<th>Nb de résultats</th>
	<th>Joueurs du club</th>
	<th>Téléchargé ?</th>
	<th><input type="checkbox" id="selectall" name="selectall"></th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr>
   		<td>{$entry->date_prevue}</td>
   		<td>{$entry->nom_epr}</td>
   		<td>{$entry->libelle}  ({$entry->iddivision})</td>
		<td>{$entry->tableau}</td>
		<td>{$entry->tour}</td>		
		<td>{$entry->tab_in_cla}</td>
		<td>{$entry->players}</td>
		<td>{if $entry->uploaded =="1"}{admin_icon icon="true.gif"}{else}{admin_icon icon="false.gif"}{/if}</td>
		<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->tableau}" class="select"></td>
		
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

