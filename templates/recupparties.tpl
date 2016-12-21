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
<h2>Etat des récupérations des joueurs actifs</h2>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}  {*$barcharts*}</p></div>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Id</th>
		<th>Joueur</th>
		<th>Dernière Situation</th>
		<th>Parties FFTT</th>
		<th>Spid du mois/Erreurs</th>
		<th colspan='3'>Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
	<td>{$entry->joueur} ({$entry->licence})</td>
	<td>{if $entry->sit_mens ==''}{$entry->push_player}{else}{$entry->sit_mens}{/if}</td>
	<td>{$entry->fftt}<br />(maj le {$entry->maj_fftt|date_format:"%A %e %B"})</td>
	<td>{$entry->spid}/{$entry->spid_errors}{if $entry->spid_errors >0} {$attention_img}{/if}<br />(maj le {$entry->maj_spid|date_format:"%A %e %B"})</td>
    
	<td>{$entry->getpartieslink}</td>
	{if $affichage != FALSE}
	<td>{$entry->sitmenslink}</td>
	<td>{$entry->getpartiesspid}</td>
	{/if}
	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->licence}" class="select"></td>
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
