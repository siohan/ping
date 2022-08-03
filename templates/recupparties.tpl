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
<h2>Tableau de récupération des parties SPID du mois courant</h2>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} {if true == $nettoyage}| {$rafraichir} {$Verif} | <a href="{cms_action_url action=erase_spid}">Supprimer les parties obsolètes</a>{/if}</p></div>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Joueur</th>
		<th>Licence</th>
		<th>Spid du mois</th>
		<th>Erreurs</th>
		<th>Points</th>
		<th>Mise à jour</th>
		<th colspan='2'>Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td><a href="{cms_action_url action=view_adherent_details record_id=$entry->licence}">{$entry->joueur}</a></td>
	<td> {$entry->licence}</td>
	<td>{$entry->spid}</td>
	<td>{$entry->spid_errors} {if $entry->spid_errors >0} {$attention_img}{/if}</td>
	<td>{$entry->points}</td>
	<td>{$entry->maj_spid}</td>    
	<td>{$entry->getpartiesspid}</td>
	<td>{$entry->view}</td>
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
