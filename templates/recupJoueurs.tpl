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
{if isset($message)}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<div class="pageoptions"><p class="pageoptions">{$retrieve_users} | {$retrieve_teams} | {$retrieve_teams_autres} | {$retrieve_all_parties} | {$retrieve_all_spid} | {$retrieve_details_rencontres}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>Id</th>
  <th>Date de mise à jour</th>
  <th>designation</th>
  <th colspan="3">Actions</th>
	<th><input type="checkbox" id="selectall" name="selectall"/></th>
    </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->datemaj}</td>
    <td>{$entry->designation}</td>
    <td>{$entry->editlink}</td>
	<td>{$entry->deletelink}</td>
	<td>{$entry->select}</td>
    
  </tr>
{/foreach}
 </tbody>
</table>

  <div class="pageoptions" style="float: right;">
{if isset($submit_massdelete)}<br/>{$submit_massdelete}{/if}
  </div>
{$form2end}
{/if}






