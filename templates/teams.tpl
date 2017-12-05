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
  $('#toggle_filter2').click(function(){
    $('#filter_form2').dialog({
      modal: true,
      width: 'auto',
    });
  });
  {if isset($tablesorter)}
  if( typeof($.tablesorter) != 'undefined' ) $('#articlelist').tablesorter({ sortList:{$tablesorter} });
  {/if}
});
//]]>
</script>
<div class="pageoptions"><p class="pageoptions warning">Récupérez les {$retrieve_teams} | {$retrieve_teams_fem} | {$retrieve_teams_autres} </p></div>
{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
  <div class="pageoverflow">
	<p class="pagetext">Type Compétition:</p>
    <p class="pageinput">{$input_compet} </p>
	<p class="pagetext">Phase :</p>
	<p class="pageinput">{$curphase} </p>
    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}


<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

	{if $itemcount > 0}
<div class="pageoptions<"><p><span class="pageoptions warning">{$retrieve_all} | {$retrieve_calendriers} | {$classements}</span></p></div>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Equipe</th>
		<th>Niveau</th>
		<th>Nom court</th>
		<th>Tag pour affichage</th>
		<th colspan="4">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->libequipe}</td>
    <td>{$entry->libdivision}</td>
    <td>{$entry->friendlyname}</td>
	<td>{$entry->tag}</td>
	<td>{$entry->view}</td>
	<td>{$entry->editlink}</td>
    <td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}


