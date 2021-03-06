<!--
{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
  <div class="pageoverflow">
	<p class="pagetext">Id:</p>
    <p class="pageinput">Nom </p>
    <p class="pagetext">{$prompt_tour}:</p>
    <p class="pageinput">{$input_tour} </p>
	<p class="pagetext">{$prompt_equipe}:</p>
    <p class="pageinput">{$input_equipe} </p>
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}
-->
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
});
//]]>
</script>
{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
  <div class="pageoverflow">
	<p class="pagetext">Tour:</p>
    <p class="pageinput">{$input_tour} </p>
	<p class="pagetext">Mois:</p>
    <p class="pageinput">{$input_mois} </p>

    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}
{$returnlink}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p><p>{$refresh}</p></div>

{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
	<th>Epreuve (division)</th>
	<th>Tableau</th>
	<th>Tour</th>
	<th>Date</th>
	<th colspan="3">Actions</th>
	<th><input type="checkbox" id="selectall" name="selectall"></th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
   		<td>{$entry->libelle}  ({$entry->iddivision})</td>
		<td>{$entry->tableau}</td>
		<td>{$entry->tour}</td>
		<td>{$entry->date_debut}->{$entry->date_fin}</td>
		<td>{$entry->uploaded_parties}{$entry->partie} - {$entry->uploaded_classement}{$entry->classement} - {$entry->participants}</td>
		<td>{$entry->editlink}</td>
		<td>{$entry->deletelink}</td>
		<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->tableau}" class="select"></td>
		<td>
  </tr>
{/foreach}
 </tbody>
</table>
<!-- SELECT DROPDOWN -->
<div class="pageoptions" style="float: right;">
<br/>{$actiondemasse}{$submit_massaction}
  </div>
{$form2end}
{else}
<p class="warning">Récupérer les tours ? {$recup_tours}</p>
{/if}

