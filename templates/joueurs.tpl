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
{*
<div id="filter_form" style="display: none;" title="Alertes du module">
  <table>
    <tr>
      <td style="vertical-align: top;">
        {if $alertCompte >0}
		<div class="pageoverflow">
          	<p class="pagetext">
			Attention !! Vous devez renseigner vos paramètres dans l'onglet "Compte"
			</p>
        </div>
		{/if}
		
		{if $alertConfig >0}
		<div class="pageoverflow">
          	<p class="pagetext">
			Attention !! Vous devez renseigner vos paramètres dans l'onglet "Configuration"
			</p>
        </div>
        {/if}

		{if $nb_dep  == 0}
		<div class="pageoverflow">
          	<p class="pagetext">
			{$compet_dep}
			</p>
        </div>
        {/if}

        
      </td>

    </tr>
  </table>
 
</div>

{if $alertCompte >0 || $alertConfig >0}
<div class="pageoptions">
  <a id="toggle_filter">Ouvrir les alertes du module</a>
</div>
{/if}
*}
{* les messages ci-dessous proviennent de la page action.updateoptions.php*}
{if $msg =='Full'}
<p>Cliquez ci-après pour finaliser le changement de saison {$delete_all}</p>
{/if}



<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;|&nbsp;{$retrieve_users}</p></div>
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
	    <td{if $entry->actif =="0"} class="warning"{else} class="info"{/if}>{$entry->actif}</td>
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
{/if}
	
