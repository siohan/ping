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
<h2>Récupérations des parties validées (FFTT)</h2>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} - <a href="{cms_action_url action=retrieve retrieve=fftt_all}">{admin_icon icon="import.gif"}Téléchagez les résultats</a></p></div>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Id</th>
		<th>Joueur</th>
		<th>Parties FFTT</th>
		<th>Mise à jour</th>
		<th colspan='2'>Actions</th>
	<!--	<th><input type="checkbox" id="selectall" name="selectall"></th>-->
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	
	<td>{$entry->licence}</td>
	<td>{$entry->joueur}</td>
	<td>{$entry->fftt}</td>
	<td>{$entry->maj_fftt|date_format:"%A %e %B"}</td> 
	<td>{$entry->view}</td>   
	<td>{$entry->getpartieslink}</td>
<!--	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->licence}" class="select"></td>-->
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
