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
{**}
	{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
  <div class="pageoverflow">
{*	<p class="pagetext">Type Compétition:</p>
    <p class="pageinput">{$input_compet} </p>*}
    <p class="pagetext">Poule</p>
    <p class="pageinput">{$input_tour} </p>
{*	<p class="pagetext">{$prompt_equipe}:</p>
    <p class="pageinput">{$input_equipe} </p>
    <p class="pagetext">&nbsp;</p>*}
    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}
{*
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>*}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}

{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>Id</th>
  <th>Poule</th>
  <th>Equipe A</th>
  <th colspan="2">Score</th>
  <th>Equipe B</th>
<th colspan="3">Actions</th>
<th><input type="checkbox" id="selectall" name="selectall"/></th>
 
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
    <td>{$entry->libelle}</td>
    <td>{$entry->equa}</td>
    <td>{$entry->scorea}</td>
	<td>{$entry->scoreb}</td>
	<td>{$entry->equb}</td>
    <td>{$entry->retrieve_poule_rencontres}</td>
<td>{$entry->display}</td>
    <td>{$entry->deletelink}</td>
	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->id}" class="select"></td>
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
