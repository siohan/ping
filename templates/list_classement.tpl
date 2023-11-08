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
<div class="pageoptions"><p class="pageoptions"><a href="{cms_action_url action=view_indivs_details record_id=$idepreuve}">{admin_icon icon="back.gif"}</a></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

{if $itemcount > 0}
<h1>{$titre}</h1>
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
	<th>Tableau</th>
	<th>Place</th>
	<th>Nom</th>
	<th>Club</th>
	<!--<th colspan="2">Actions</th>
	<th><input type="checkbox" id="selectall" name="selectall"></th>-->
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
		<td>{$entry->tableau}</td>
   		<td>{$entry->rang}</td>
		<td>{$entry->nom}</td>
		
		{if $entry->club|@strstr:"{$club}"}<td style="background-color:green; color:white;">{$entry->club}</td>{else}<td>{$entry->club}</td>{/if}
		
		<!--<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->tour_id}" class="select"></td>-->

  </tr>
{/foreach}
 </tbody>
</table>
<!-- SELECT DROPDOWN 
<div class="pageoptions" style="float: right;">
<br/>{$actiondemasse}{$submit_massaction}
  </div>
{$form2end}
-->
{else}
{$recup_classement}
{/if}


