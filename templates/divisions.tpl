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

    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}
{$retourlien} <p class="warning">{$alert_message}</p>{*$recup_div*}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}  {if $itemcount > 0}   --->{$tours}</p></div>{else}</p></div>{/if}
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>
	<th>Id</th>
	<th>Epreuve (N°)</th>
	<th>Niveau</th>
	<th>Division (N°)</th>
	<th colspan="2">Actions</th>
  <th><input type="checkbox" id="selectall" name="selectall"></th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass} ">
    <td>{$entry->id}</td>
	<td>{$entry->name} ({$entry->idepreuve})</td>
	<td>{$entry->scope}</td>
	<!--<td>{$entry->date_event|date_format:"%d/%m"}</td>-->
    <td>{$entry->libelle} ({$entry->iddivision})</td>
 	<td>{$entry->uploaded}</td>
	<td>{$entry->poule}</td>
    <td>{$entry->deletelink}</td>
	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->iddivision}" class="select"></td>
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
<p>Récupérer les divisions ?{$recup_div}</p>
{/if}
