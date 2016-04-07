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
<div id="filter_form2" style="display: none;" title="Actions globales">
  <table>
    <tr>
      <td style="vertical-align: top;">
        
		<div class="pageoverflow">
          	<h3>Calendriers</h3>
			<ul>
			{foreach from=$donnees item=donnee}
				<li>{$donnee->links_chpt}</li>
				
			{/foreach}	
			</ul>
        </div>
		
		
		
		
        
      </td>

    </tr>
  </table>
 
</div>


<div class="pageoptions">
  <a id="toggle_filter2">Actions globales</a>
</div>

{*
	{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
  <div class="pageoverflow">
	<p class="pagetext">Type Compétition:</p>
    <p class="pageinput">{$input_compet} </p>
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
*}
{*$classement*}
<div class="pageoptions<"><p><span class="pageoptions warning">Récupérez les {$retrieve_teams} | {$retrieve_teams_fem} | {$retrieve_teams_autres} </span></p></div>
<div class="pageoptions<"><p><span class="pageoptions warning">{$retrieve_all} | {$retrieve_calendriers} | {$classements}</span></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<p class="pageoptions">{$phase1} | {$phase2}</p>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>{$id}</th>
		<th>{$equipe}</th>
		<th>Niveau</th>
		<th>Compétition</th>
		<th>Nom court</th>
		<th>Tag pour affichage</th>
		<th colspan="4">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
    <td>{$entry->libequipe}</td>
    <td>{$entry->libdivision}</td>
	<td>{$entry->name}</td>
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

