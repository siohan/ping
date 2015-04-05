{*debug*}
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
{*<div class="pageoptions"><p class="pageoptions">{$retrieve_users} | {$retrieve_teams} | {$retrieve_teams_autres} | {$retrieve_all_parties} | {$retrieve_all_spid} | {$retrieve_details_rencontres}</p></div>*}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Id</th>
		<th>Date de mise à jour</th>
		<th>designation</th>
		<!--<th colspan="2">Actions</th>-->
		<th><input type="checkbox" id="selectall" name="selectall"/></th>
    </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->datecreated|date_format:"%A %e %B %Y à %H:%M:%S"}</td>
    <td>{$entry->designation}</td>
	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->id}" class="select"></td>
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







