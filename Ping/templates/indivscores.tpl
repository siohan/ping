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
	<p class="pagetext">Saison:</p>
    <p class="pageinput">{$input_saison} </p>
	<p class="pagetext">Joueur :</p>
    <p class="pageinput">{$input_player} </p>
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}
<div class="pageoptions"><p class="pageoptions">{$retrieve_all_parties}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>{$id}</th>
  <th>N° Journée</th>
  <th>{$joueur}</th>
  <th>{$victoire}</th>
  <th>{$adversaire}</th>
	<th>{$points}</th>
  <th><input type="checkbox" id="selectall" name="selectall"></th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->numjourn}</td>
    <td>{$entry->joueur}</td>
    <td>{$entry->vd}</td>
    <td>{$entry->advnompre} </td>
	<td>{$entry->pointres} </td>
    <td>{$entry->editlink}</td>
    <td>{$entry->deletelink}</td>
	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->licence}" class="select"></td>
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

<div class="pageoptions"><p class="pageoptions">{$retour}</p></div><hr />
<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
