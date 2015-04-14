{*<pre>{$items|var_dump}</pre>*}
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
<div class="pageoptions"><p class="pageoptions">{$mois_precedent}&nbsp;{$mois_suivant} </p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} </p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="table table-hover" id="articlelist">
 <thead>
	<tr>
		<th>Joueur</th>
		<th>Points</th>
		<th>Rang nat</th>
		<th>Rang reg</th>
		<th>Rang dép</th>
		<th>Progression mens</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->joueur}</td>
    <td>{$entry->points}</td>
	<td>{$entry->clnat}</td>
	<td>{$entry->rangreg}</td>
	<td>{$entry->rangdep}</td>
	<td>{$entry->progmois}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
