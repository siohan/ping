
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;|&nbsp;
<a href="{cms_action_url action=retrieve retrieve=users}">{admin_icon icon="import.gif"} Importer les joueurs</a>
 | {if $act ==0}<a href="{cms_action_url action=defaultadmin __activetab=joueurs}">Actifs</a>{else}<a href="{cms_action_url action=defaultadmin __activetab=joueurs actif=0}">Inactifs</a>{/if}</p></div>
{if $itemcount > 0}
	{$form2start}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
	 <thead>
		<tr>
			<th>Joueur</th>
			<!--th>Photo</th -->
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
		<td><a href="{cms_action_url action=view_adherent_details record_id=$entry->licence}">{$entry->joueur}</a></td>
		<!--<td>{if $entry->img !=' '}<a href="{cms_action_url action=upload_image genid=$entry->licence}" title="Téléverser une photo"><img src="{$entry->img}" width="40" height="40"></a>{else}<a href="{cms_action_url action=upload_image genid=$entry->licence}">{admin_icon icon="edit.gif" title="Changer la photo"}</a>{/if}</td> -->
		<td>{$entry->licence}</td>
	    <td>{if $entry->actif =="1"}<a href="{cms_action_url action=retrieve retrieve=desactivate licence=$entry->licence}">{admin_icon icon="true.gif"}</a>{else}<a href="{cms_action_url action=retrieve retrieve=activate licence=$entry->licence}">{admin_icon icon="false.gif"}</a>{/if}</td>
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
	
