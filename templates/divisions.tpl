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
<a href="{cms_action_url action=view_indivs_details record_id=$idepreuve}">{admin_icon icon="back.gif"}</a>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}  </p></div>
{if $itemcount > 0}

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>
	<th>Id</th>
	<th>Epreuve (N°)</th>
	<th>Niveau</th>
	<th>Division (N°)</th>
	
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
 	
  </tr>
{/foreach}
 </tbody>
</table>
{/if}

