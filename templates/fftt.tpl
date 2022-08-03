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


<div class="pageoptions"><p class="pageoptions">{$retour} | {$rafraichir} | {$retrieve_fftt}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<h3>Parties validées de {$joueur}</h3>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>
	<th>Id</th>
	<th>N° Journée</th>
	<th>Date</th>
	<th>Vic/def</th>
	<th>Adversaire</th>
	<th>Points</th>
	<th>Coeff</th>
	<th>Code</th> 
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
	<td>{$entry->numjourn}</td>
	<td>{$entry->date_event|date_format:"%d/%m"}
    <td>{$entry->vd}</td>
    <td>{$entry->advnompre} </td>
	<td>{$entry->pointres} </td>
    <td>{$entry->coefchamp}</td>
    <td>{$entry->codechamp}</td>
  </tr>
{/foreach}
 </tbody>
</table>

{/if}
