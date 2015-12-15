{*<pre>{$items|var_dump}</pre>{*debug*}
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
{*
{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
  <div class="pageoverflow">
	<!--<p class="pagetext">Type Compétition:</p>
    <p class="pageinput">{$input_compet} </p>-->
    <p class="pagetext">Date:</p>
    <p class="pageinput">{$input_date} </p>
	<p class="pagetext">Statut:</p>
    <p class="pageinput">{$input_status} </p>
	<!--<p class="pagetext">Joueur :</p>
    <p class="pageinput">{$input_player} </p>-->
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}
*}
<p style="width: 100%"><span style="text-align: left">{if $phase ==1}{$Sep} | {$Oct} | {$Nov} | {$Dec} {$mois_suivant}{else}{$mois_precedent}  {$Jan} | {$Fev} | {$Mar} | {$Avr} | {$Mai} | {$Juin} | {$Juil}{/if}</span></p>
{*<div class="pageoptions"><p class="pageoptions">{$retrieve_users} | {$retrieve_teams} | {$retrieve_teams_autres} | {$retrieve_all_parties} | {$retrieve_all_spid} | {$retrieve_details_rencontres}</p></div>*}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}  | {$createlink} {*$maintenant*}</p></div>
{if $itemcount > 0 && is_array($items) && count($items)>0}

{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Id</th>
		<th>Nom_compet</th>
		<th>Date</th>
		<th>N° Tour</th>
		<th>Tag pour affichage</th>
		<th colspan="2">Actions</th>
    </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
{*{if $entry->date_fin < $maintenant}<tr class="{$entry->rowclass} past" style="background: grey; font-color: white;">{else}
  <tr class="{$entry->rowclass}">{/if}*}
   <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->name}</td>
	<td>{$entry->date_debut|date_format:"%d-%m-%Y"}->{$entry->date_fin|date_format:"%d-%m-%Y"}</td>
	<td>{$entry->numjourn}</td>
	<td>{$entry->tag}</td>
	<td>{$entry->retrievelink}</td>
    <td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
	</tr>
{/foreach}
 </tbody>
</table>
{/if}
<div style="width: 100%;">
<div class="pageoptions" style="float: left;">
	<p class="pageoptions">{*$addlink*}</p>
</div>
{if $itemcount > 0}
  <div class="pageoptions" style="float: right; text-align: right;">
    {$submit_massdelete}
  </div>
{/if}
<div class="clearb"></div>
</div>
{$form2end}







