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
  if( typeof($.tablesorter) != 'undefined' ) $('#articlelist').tablesorter({ sortList:{$tablesorter} });
  {/if}
});
//]]>
</script>

		
		{if $alertConfig >0}
		<div class="pageoverflow">
          	<p class="pagetext">
			Attention !! Vous devez renseigner vos paramètres dans l'onglet "Compte"
			</p>
        </div>
        {/if}

{*Lien vers le formulaire de satisfaction *}

<div class="pageoptions"><p class="pageoptions">{$club} - {$itemcount}&nbsp;{$itemsfound}&nbsp;|&nbsp;{$retrieve_users} | <a href="{cms_action_url action=delete_all}">{admin_icon icon=delete}</a> {if $act ==0}{$actifs}{else} {$inactifs}{/if}</p></div>
{if $itemcount > 0}
	{$form2start}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
	 <thead>
		<tr>
			<th>Joueur</th>
			<th>Licence</th>
			<th>Actif</th>
			<th>Type</th>
			<th>Sexe</th>
			<th>Certif</th>
			<th>Validation</th>
			<th>Cat</th>
			<th><input type="checkbox" id="selectall" name="selectall"></th>
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->joueur}</td>
		<td>{$entry->licence}</td>
	    <td>{$entry->actif}</td>
		<td>{$entry->type}</td>
		<td>{$entry->sexe}</td>
		<td>{$entry->certif}</td>
		<td>{$entry->validation}</td>
		<td>{$entry->cat}</td>
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
	
