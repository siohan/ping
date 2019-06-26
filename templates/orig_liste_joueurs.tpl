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
    $('#filter_form').dialog({
      modal: true,
      width: 'auto',
    });
  });
  {if isset($tablesorter)}
  if( typeof($.tablesorter) != 'undefined' ) $('#liste_joueurs').tablesorter({ sortList:{$tablesorter} });
  {/if}
});
//]]>
</script>


{if $itemcount > 0}
	<table id="liste_joueurs" border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Joueur</th>
			<th>Licence</th>
			<th>Type</th>
			<th>Cat</th>
			<th>Pts</th>
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->joueur}</td>
		<td>{$entry->licence}</td>
		<td>{$entry->type}</td>
		<td>{$entry->cat}</td>
		<td>{$entry->points}</td>
	    </tr>
	{/foreach}
	 </tbody>
	</table>
{/if}
	
