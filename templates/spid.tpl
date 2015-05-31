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
	<p class="pagetext">Type Compétition:</p>
    <p class="pageinput">{$input_compet} </p>
    <!--<p class="pagetext">{$prompt_tour}:</p>
    <p class="pageinput">{$input_tour} </p>-->
	<p class="pagetext">Date:</p>
    <p class="pageinput">{$input_date} </p>
	<p class="pagetext">Joueur :</p>
    <p class="pageinput">{$input_player} </p>
	<p class="pagetext">Erreurs uniquement:</p>
	<p class="pageinput">{$input_error_only} </p>
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} | {$retrieve_all}</p></div>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>	
		<th>Id</th>
		<th>Joueur</th>
		<th>Date</th>
		<th>Epreuve</th>
		<th>Nom adversaire</th>
		<th>Classement</th>
		<th>Victoire</th>
		<th>Ecart</th>
		<th>Coeff</th>
		<th>Points</th>
		<th>Forfait</th>
		<th colspan="3">Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->record_id}</td>
	<td>{$entry->joueur}</td>	
    <td>{$entry->date_event|date_format:"%A %e %B %Y"}</td>
    <td>{$entry->epreuve}</td>
	<td>{$entry->name}</td>
	<td>{$entry->classement}</td>
	<td>{$entry->victoire}</td>
	{if $entry->ecart eq "0.00" || $entry->ecart==-$entry->classement}<td style="background-color: orange;">{else}<td>{/if}{$entry->ecart}</td>
	{if $entry->coeff  eq "0.00"}<td style="background-color: red;">{else}<td>{/if}{$entry->coeff}</td>
	<td>{$entry->pointres}</td>
	<td>{$entry->forfait}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->duplicatelink}</td>
	<td>{$entry->deletelink}</td>
	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->record_id}" class="select"></td>
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

<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
