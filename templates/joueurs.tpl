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
{* les messages ci-dessous proviennent de la page action.updateoptions.php*}
{if $msg =='Full'}
<p class="warning">Cliquez ci-après pour finaliser le changement de saison {$delete_all}</a></p>
{/if}

{if $saison_en_cours != $saison}
<p class="warning">Attention !! Vous devez changer vos paramètres dans l'onglet "Configuration"</p>{/if}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;|&nbsp;{$retrieve_users}&nbsp;|&nbsp;{$createlink}&nbsp;| &nbsp;| {$display_unable_players}&nbsp;</p></div>
{if $itemcount > 0}
{$form2start}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>{$id}</th>
		<th>Joueur</th>
		<th>Licence</th>
		<th>Actif</th>
		<th>Sexe</th>
		<th>Date naissance</th>
		<th colspan='2'>Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
	</tr>
</thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
	<td>{$entry->joueur}</td>
	<td>{$entry->licence}</td>
    <td>{$entry->actif}</td>
	<td>{$entry->sexe}</td>
	<td>{$entry->birthday}</td>
	<td>{$entry->doedit}</td>
	<td>{$entry->view_contacts}</td>
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
{else}
<div class="pageoptions"><p class="pageoptions">{$retrieve_users}</p></div>
{/if}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
